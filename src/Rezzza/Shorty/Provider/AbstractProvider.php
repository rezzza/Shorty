<?php

namespace Rezzza\Shorty\Provider;

use Guzzle\Service\Client;
use Rezzza\Shorty\Exception;
use Rezzza\Shorty\Http\AdapterInterface;
use Rezzza\Shorty\Http\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;

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

    /**
     * @param string   $key      key
     * @param Response $response response
     * @param string   $format   format
     *
     * @return mixed
     */
    protected function extractKeyFromResponse($key, Response $response, $format= 'json')
    {
        if ($format != 'json') {
            throw new \LogicException(__METHOD__.' accepts only json format.');
        }

        $body = json_decode($response->getBody(), true);

        if (null === $body) {
            throw new Exception\UnexpectedResponseException(sprintf('JSON body expected, "%s" returned', $response->getBody()));
        }

        $accessor = PropertyAccess::getPropertyAccessor();
        $value    = $accessor->getValue($body, $key);

        if (null === $value) {
            throw new Exception\UnexpectedResponseException(sprintf('Key "%s" not found in payload "%s"', $key, $response->getBody()));
        }

        return $value;
    }
}
