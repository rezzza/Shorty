<?php

namespace Rezzza\Shorty\Provider;

/**
 * ProviderInterface
 *
 * @author Jérémy Romey <jeremy@free-agent.fr>
 */
interface ProviderInterface
{
    /**
     * @param string $url url
     *
     * @return string
     */
    public function shorten($url);

    /**
     * @param string $url url
     *
     * @return string
     */
    public function expand($url);
}
