<?php

namespace Rezzza\Shorty;

use Guzzle\Service\Client;

/**
 * AbstractShortener
 *
 * @author Jérémy Romey <jeremy@free-agent.fr>
 */
abstract class AbstractShortener implements ShortenerInterface
{
    protected $apiUrl;
    protected $apiKey;
    protected $client;
    protected $format;
    protected $url;

    public function getShortenPath()
    {
        return $this->getPath();
    }

    public function getExpandPath()
    {
        return $this->getPath($this->getExpandParams());
    }

    public function getPath($params = array())
    {
        $query = http_build_query($params);

        return $this->getApiUrl().($query ? '?'.$query : '');
    }

    public function setFormat($format)
    {
        if (!in_array($format, array('xml', 'json'))) {
            throw new \InvalidArgumentException(sprintf('Format %s is not supported', $format));
        }
        $this->format = $format;

        return $this;
    }

    public function getDefaultParams()
    {
        $params = array();
        if ($this->getApiKey()) {
            $params['key'] = $this->getApiKey();
        }

        return $params;
    }

    public function getShortenParams()
    {
        $params = array(
            'longUrl' => $this->url,
        );

        return array_merge($params, $this->getDefaultParams());
    }

    public function getExpandParams()
    {
        $params = array(
            'shortUrl' => $this->url,
        );

        return array_merge($params, $this->getDefaultParams());
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        return $this->apiUrl;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function getFormat()
    {
        return $this->format;
    }

    public function getClient()
    {
        if (!$this->client) {
            $this->client = new Client($this->apiUrl);
        }

        return $this->client;
    }

    public function shorten($url)
    {
        $this->url = $url;

        return $this->doShorten($url);
    }

    public function expand($url)
    {
        $this->url = $url;

        return $this->doExpand($url);
    }

    protected function call($path, $method, $body = null)
    {
        $client = $this->getClient();

        $request = $this->buildRequest($client, $path, $method, $body);

        $response = $request->send();

        $responseMethod = $this->getFormat();

        return $response->$responseMethod();
    }

    abstract protected function doShorten($url);

    abstract protected function doExpand($url);

    abstract protected function buildRequest(Client $client, $path, $method, $body = null);
}
