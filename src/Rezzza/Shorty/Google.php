<?php

namespace Rezzza\Shorty;

use Guzzle\Service\Client;

/**
 * Google
 *
 * @author Jérémy Romey <jeremy@free-agent.fr>
 */
class Google extends AbstractShortener
{
    public function __construct($apiKey = null, $format = null)
    {
        $this->apiUrl = 'https://www.googleapis.com/urlshortener/v1/url';
        $this->apiKey = $apiKey;
        $this->format = $format ? $format : 'json';
    }

    protected function doShorten($url)
    {
        $result = $this->call($this->getShortenPath(), 'POST', $this->getShortenParams());

        return $result['id'];
    }

    protected function doExpand($url)
    {
        $result = $this->call($this->getExpandPath(), 'GET');

        return $result['longUrl'];
    }

    protected function buildRequest(Client $client, $path, $method, $body = null)
    {
        if ('GET' == $method) {
            $request = $client->get($path);
        } elseif ('POST' == $method) {
            $request = $client->post($path);
            $request->setBody(json_encode($body), 'application/json');
        } else {
            throw new \InvalidArgumentException(sprintf('Method %s not supported', $method));
        }

        return $request;
    }
}
