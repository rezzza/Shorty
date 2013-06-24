<?php

namespace Rezzza\Shorty\Provider;

use Guzzle\Service\Client;
use Rezzza\Shorty\Http\AdapterInterface;
use Rezzza\Shorty\Http\Response;

/**
 * AbstractProvider
 *
 * @author Jérémy Romey <jeremy@free-agent.fr>
 */
abstract class AbstractProvider implements ProviderInterface
{
    /**
     * @var AdapterInterface
     */
    protected $httpAdapter;

    /**
     * @param AdapterInterface $adapter adapter
     */
    public function setHttpAdapter(AdapterInterface $adapter)
    {
        $this->httpAdapter = $adapter;
    }

    /**
     * @param string $path   path
     * @param string $method  method
     * @param mixed  $body    body
     * @param array  $headers headers
     *
     * @return Response
     */
    protected function call($path, $method, $body = null, array $headers = array())
    {
        if (!$this->httpAdapter) {
            throw new \LogicException('HTTP Adapter was not injected in provider.');
        }

        switch (strtolower($method)) {
            case 'post':
                $response = $this->httpAdapter->post($path, $body, $headers);
                break;
            case 'get':
                $response = $this->httpAdapter->get($path, $headers);
                break;
            default:
                break;
        }

        return $response;
    }
}
