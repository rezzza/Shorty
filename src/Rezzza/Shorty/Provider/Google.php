<?php

namespace Rezzza\Shorty\Provider;

use Rezzza\Shorty\Http\Response;

/**
 * Google
 *
 * @author Jérémy Romey <jeremy@free-agent.fr>
 */
class Google extends AbstractProvider
{
    CONST ENDPOINT = 'https://www.googleapis.com/urlshortener/v1/url';

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @param string $apiKey apiKey
     */
    public function __construct($apiKey = null)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function shorten($url)
    {
        $endpoint = self::ENDPOINT;

        if ($this->apiKey) {
            $endpoint .= '?'.http_build_query(array('key' => $this->apiKey));
        }

        $response = $this->call($endpoint, 'POST', json_encode(array(
            'longUrl' => $url,
        )), array(
            'Content-Type' => 'application/json'
        ));

        return $this->extractKeyFromResponse('[id]', $response);
    }

    /**
     * {@inheritdoc}
     */
    public function expand($url)
    {
        $endpoint = self::ENDPOINT.'?'.http_build_query(array(
            'key'      => $this->apiKey,
            'shortUrl' => $url,
        ));

        $response = $this->call($endpoint, 'GET', array(
            'Content-Type' => 'application/json'
        ));

        return $this->extractKeyFromResponse('[longUrl]', $response);
    }
}
