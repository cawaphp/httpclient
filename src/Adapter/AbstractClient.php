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

namespace Cawa\HttpClient\Adapter;

use Cawa\Http\Request;
use Cawa\Http\Response;

abstract class AbstractClient
{
    const OPTIONS_EVENTS_PREFIX = 'EVENTS_PREFIX';
    const OPTIONS_SSL_VERIFY = 'SSL_VERIFY';
    const OPTIONS_SSL_CLIENT_CERTIFICATE = 'SSL_CLIENT_CERTIFICATE';
    const OPTIONS_SSL_CLIENT_KEY = 'SSL_CLIENT_KEY';
    const OPTIONS_TIMEOUT = 'TIMEOUT';
    const OPTIONS_CONNECT_TIMEOUT = 'CONNECT_TIMEOUT';
    const OPTIONS_PROXY = 'PROXY';
    const OPTIONS_DEBUG = 'DEBUG';
    const OPTIONS_ACCEPT_ENCODING = 'ACCEPT_ENCODING';
    const OPTIONS_FOLLOW_REDIRECTION = 'FOLLOW_REDIRECTION';
    const OPTIONS_MAX_REDIRECTION = 'MAX_REDIRECTION';

    /**
     * @var array
     */
    protected $options = [
        self::OPTIONS_EVENTS_PREFIX => 'httpClient',
        self::OPTIONS_CONNECT_TIMEOUT => 5000,
        self::OPTIONS_TIMEOUT => 5000,
        self::OPTIONS_DEBUG => true,
        self::OPTIONS_ACCEPT_ENCODING => true,
        self::OPTIONS_MAX_REDIRECTION => 10,
    ];

    /**
     * @var array
     */
    protected $defaultHeader = [
        'UserAgent' => 'Cawa PHP Client',
    ];

    /**
     * @param string $name
     * @param $value
     *
     * @return $this|self
     */
    public function setDefaultHeader(string $name, $value)
    {
        $this->defaultHeader[$name] = $value;

        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     *
     * @return $this|self
     */
    public function setOption(string $name, $value) : self
    {
        $this->options[$name] = $value;

        return $this;
    }

    /**
     * @var callable
     */
    protected $progress;

    /**
     * @param callable $progress
     *
     * @return $this|self
     */
    public function setProgress(callable $progress) : self
    {
        $this->progress = $progress;

        return $this;
    }

    /**
     * @param array $options
     */
    public function __construct($options = [])
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    abstract public function request(Request $request) : Response;
}
