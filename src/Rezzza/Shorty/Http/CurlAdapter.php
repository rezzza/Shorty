<?php

namespace Rezzza\Shorty\Http;

use Rezzza\Shorty\Exception;

/**
 * CurlAdapter
 *
 * @uses AdapterInterface
 * @author Stephane PY <py.stephane1@gmail.com>
 */
class CurlAdapter implements AdapterInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($path, array $headers = array())
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL            => $path,
            CURLOPT_HTTPHEADER     => $this->formatHeaders($headers),
            CURLOPT_RETURNTRANSFER => 1,
        ));


        $body = curl_exec($ch);

        if(!curl_errno($ch)){
            $info = curl_getinfo($ch);

            return new Response($info['http_code'], $body);
        } else {
            throw new Exception\RemoteErrorException(curl_error($ch));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function post($path, $body = null, array $headers = array())
    {
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL            => $path,
            CURLOPT_POST           => 1,
            CURLOPT_POSTFIELDS     => $body,
            CURLOPT_HTTPHEADER     => $this->formatHeaders($headers),
            CURLOPT_RETURNTRANSFER => 1,
        ));

        $body = curl_exec($ch);

        if(!curl_errno($ch)){
            $info = curl_getinfo($ch);

            return new Response($info['http_code'], $body);
        } else {
            throw new Exception\RemoteErrorException(curl_error($ch));
        }
    }

    /**
     * formatHeaders for CURLOPT_HTTPHEADER
     *
     * @param array $headers headers
     *
     * @return array
     */
    private function formatHeaders(array $headers)
    {
        $h = array();
        foreach ($headers as $key => $header) {
            $h[] = sprintf('%s: %s', $key, $header);
        }

        return $h;
    }
}
