<?php

/*
 * This file is part of the Сáша framework.
 *
 * (c) tchiotludo <http://github.com/tchiotludo>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Cawa\Cache;

use Cawa\Core\DI;
use Cawa\HttpClient\HttpClient;

trait HttpClientFactory
{
    /**
     * @param string $name config key or class name
     *
     * @return Cache
     */
    private static function httpClient(string $name = null) : Cache
    {
        list($container, $config, $return) = DI::detect(__METHOD__, 'httpclient', $name);

        if ($return) {
            return $return;
        }

        if (is_callable($config)) {
            $item = $config();
        } else {
            $item = new HttpClient();
            $item->setBaseUri($config);
        }

        return DI::set(__METHOD__, $container, $item);
    }
}
