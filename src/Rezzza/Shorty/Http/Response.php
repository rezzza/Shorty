<?php

namespace Rezzza\Shorty\Http;

/**
 * Response
 *
 * @author Stephane PY <py.stephane1@gmail.com>
 */
class Response
{
    protected $statusCode;
    protected $body;

    /**
     * @param strig $statusCode statusCode
     * @param strig $body       body
     */
    public function __construct($statusCode, $body)
    {
        $this->statusCode = $statusCode;
        $this->body       = $body;
    }

    /**
     * @return string
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
}
