<?php

namespace Rezzza\Shorty;

/**
 * ShortenerInterface
 *
 * @author Jérémy Romey <jeremy@free-agent.fr>
 */
interface ShortenerInterface
{
    public function getShortenPath();
    public function getExpandPath();
    public function getPath($params = array());
    public function setFormat($format);
    public function getDefaultParams();
    public function getShortenParams();
    public function getExpandParams();
    public function getApiUrl();
    public function getApiKey();
    public function getFormat();
    public function getClient();
    public function shorten($url);
    public function expand($url);
}
