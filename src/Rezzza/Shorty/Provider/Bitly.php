<?php

namespace Rezzza\Shorty\Provider;

use Rezzza\Shorty\Http\Response;

/**
 * Bitly 
 *
 * @uses AbstractProvider
 * @author Sébastien HOUZÉ <s@verylastroom.com> 
 */
class Bitly extends AbstractProvider
{
    CONST ENDPOINT = 'https://api-ssl.bitly.com/v3';

    /**
     * @var string
     */
    protected $accessToken;

    /**
     * @param string $accessToken accessToken
     */
    public function __construct($accessToken)
    {
        if (empty($accessToken)) {
            throw new \LogicException('You must provide an accessToken on bitly provider creation');
        }

        $this->accessToken = $accessToken;
    }

    /**
     * {@inheritdoc}
     */
    public function shorten($url)
    {
        $url = self::ENDPOINT.'/shorten?'.http_build_query(array(
            'access_token' => $this->accessToken,
            'longUrl'      => $url,
        ));

        $response = $this->call($url, 'GET', array(
            'Content-Type' => 'application/json'
        ));

        return $this->extractKeyFromResponse('[data][url]', $response);
    }

    /**
     * {@inheritdoc}
     */
    public function expand($url)
    {
        $url = self::ENDPOINT.'/expand?'.http_build_query(array(
            'access_token' => $this->accessToken,
            'shortUrl'     => $url,
        ));

        $response = $this->call($url, 'GET', array(
            'Content-Type' => 'application/json'
        ));

        return $this->extractKeyFromResponse('[data][expand][0][long_url]', $response);
    }
}
