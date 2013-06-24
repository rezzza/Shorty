<?php

namespace Rezzza\Shorty\Http;

use Guzzle\Http\Client;

class GuzzleAdapter implements AdapterInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($path, array $headers = array())
    {
        $client   = new Client();
        $request  = $client->get($path, $headers);

        $response = $request->send();

        return new Response($response->getStatusCode(), $response->getBody(true));
    }

    /**
     * {@inheritdoc}
     */
    public function post($path, $body = null, array $headers = array())
    {
        $client   = new Client();
        $request  = $client->post($path, $headers, $body);

        $response = $request->send();

        return new Response($response->getStatusCode(), $response->getBody(true));
    }
}
