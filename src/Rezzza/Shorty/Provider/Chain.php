<?php

namespace Rezzza\Shorty\Provider;

use Rezzza\Shorty\Exception\Exception;

/**
 * Chain
 *
 * @uses ProviderInterface
 * @author Stephane PY <py.stephane1@gmail.com>
 */
class Chain implements ProviderInterface
{
    /**
     * @var array<ProviderInterface>
     */
    protected $providers = array();

    /**
     * @param ProviderInterface $provider provider
     */
    public function addProvider(ProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function shorten($url)
    {
        return $this->callOnProviders('shorten', $url);
    }

    /**
     * {@inheritdoc}
     */
    public function expand($url)
    {
        return $this->callOnProviders('expand', $url);
    }

    private function callOnProviders($method, $url)
    {
        foreach ($this->providers as $provider) {
            try {
                return $provider->{$method}($url);
            } catch (Exception $e) {
            }
        }

        throw new Exception(sprintf("%s providers cannot %s url %s", count($this->providers), $method, $url));
    }
}
