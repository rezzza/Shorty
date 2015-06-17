<?php

namespace Rezzza\Shorty\Http;

use Guzzle\Http\Client;
use Rezzza\Shorty\Exception;

/**
 * GuzzleAdapter
 *
 * @uses AdapterInterface
 * @author Stephane PY <py.stephane1@gmail.com>
 */
class GuzzleAdapter implements AdapterInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($path, array $headers = array())
    {
        $client   = new Client();
        $request  = $client->get($path, $headers);

        try {
            $response = $request->send();
        } catch (\Exception $e) {
            throw new Exception\RemoteErrorException($e->getMessage());
        }

        return new Response($response->getStatusCode(), $response->getBody(true));
    }

    /**
     * {@inheritdoc}
     */
    public function post($path, $body = null, array $headers = array())
    {
        $client  = new Client();
        $request = $client->post($path, $headers, $body);

        try {
            $response = $request->send();
        } catch (\Exception $e) {
            throw new Exception\RemoteErrorException($e->getMessage());
        }

        return new Response($response->getStatusCode(), $response->getBody(true));
    }
}
