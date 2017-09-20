<?php

/*
 * This file is part of the Сáша framework.
 *
 * (c) tchiotludo <http://github.com/tchiotludo>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Cawa\HttpClient;

use Cawa\Core\DI;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;

trait HttpClientFactory
{
    /**
     * @param string $name config key or class name
     * @param bool $strict
     *
     * @return HttpClient
     */
    private static function httpClient(string $name = null, bool $strict = false) : HttpClient
    {
        list($container, $config, $return) = DI::detect(__METHOD__, 'httpclient', $name, $strict);

        if ($return) {
            return $return;
        }

        if (is_null($config) && $strict == false) {
            $item = new HttpClient();
        } elseif (is_callable($config)) {
            $item = $config();
        } elseif (is_string($config)) {
            $item = new HttpClient();
            $item->setBaseUri($config);
        } else {
            $item = new HttpClient();

            if (isset($config['baseUri'])) {
                $item->setBaseUri($config['baseUri']);
            }

            if (isset($config['clientOptions'])) {
                foreach ($config['clientOptions'] as $name => $value) {
                    $item->setClientOption($name, $value);
                }
            }

            if (isset($config['headers'])) {
                foreach ($config['headers'] as $name => $value) {
                    $item->getClient()->setDefaultHeader($name, $value);
                }
            }
        }

        return DI::set(__METHOD__, $container, $item);
    }

    /**
     * @param string|null $name
     * @param bool $strict
     *
     * @return Client
     */
    private static function guzzle(string $name = null, bool $strict = false) : Client
    {
        list($container, $config, $return) = DI::detect(__METHOD__, 'guzzle', $name, $strict);

        if ($return) {
            return $return;
        }

        $stack = HandlerStack::create();
        $stack->setHandler(new CurlHandler());
        $config['handler'] = $stack;

        if (isset($config['middlewares'])) {
            foreach ($config['middlewares'] as $class => $options) {
                $stack->push(new $class($options ?? []));
            }

            unset($config['middlewares']);
        }

        return DI::set(__METHOD__, $container, new Client($config));
    }

}
