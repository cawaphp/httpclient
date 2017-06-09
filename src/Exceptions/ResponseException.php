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

namespace Cawa\HttpClient\Exceptions;

use Cawa\Http\Request;
use Cawa\Http\Response;

class ResponseException extends ConnectionException
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param int $code
     * @param string $message
     * @param \Throwable $previous
     */
    public function __construct(Request $request, Response $response, int $code, string $message, \Throwable $previous = null)
    {
        $this->response = $response;

        parent::__construct($request, $message, $code, $previous);
    }
}
