<?php

namespace Rezzza\Shorty\Http;

/**
 * AdapterInterface
 *
 * @author Stephane PY <py.stephane1@gmail.com>
 */
interface AdapterInterface
{
    /**
     * @param string $path    path
     * @param array  $headers headers
     *
     * @return Response
     */
    public function get($path, array $headers = array());

    /**
     * @param string $path    path
     * @param mixed  $body    body
     * @param array  $headers headers
     *
     * @return Response
     */
    public function post($path, $body = null, array $headers = array());
}
