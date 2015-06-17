<?php

namespace Rezzza\Shorty\tests\units\Provider;

require_once __DIR__ . '/../../../vendor/autoload.php';

use \mageekguy\atoum;
use Rezzza\Shorty\Provider\Google as TestedGoogle;
use Rezzza\Shorty\Http\GuzzleAdapter;
use Rezzza\Shorty\Http\Response;

/**
 * @author Jérémy Romey <jeremy@free-agent.fr>
 */
class Google extends atoum\test
{
    public function testShorten()
    {
        $this
            ->given(
                $longUrl = 'http://www.verylastroom.com/',
                $shortUrl = 'http://goo.gl/YY5Tz',

                $shortener = new TestedGoogle(),
                $adapter = $this->getMockGuzzleAdapter(),
                $adapter->getMockController()->post = new Response('200', json_encode(array('id' => $shortUrl))),
                $shortener->setHttpAdapter($adapter)
        )
            ->when($shortenUrl = $shortener->shorten($longUrl))
                ->mock($adapter)->call('post')->withArguments('https://www.googleapis.com/urlshortener/v1/url', json_encode(array('longUrl' => $longUrl)), array('Content-Type' => 'application/json'))->once()
                ->string($shortenUrl)->isIdenticalTo($shortUrl)
        ;
    }

    public function testExpand()
    {
        $this
            ->given(
                $longUrl = 'http://www.verylastroom.com/',
                $shortUrl = 'http://goo.gl/YY5Tz',

                $shortener = new TestedGoogle(),
                $adapter = $this->getMockGuzzleAdapter(),
                $adapter->getMockController()->get = new Response('200', json_encode(array('longUrl' => $longUrl))),
                $shortener->setHttpAdapter($adapter)
        )
            ->when($longUrl = $shortener->expand($shortUrl))
                ->mock($adapter)->call('get')->withArguments('https://www.googleapis.com/urlshortener/v1/url?'.http_build_query(array('shortUrl' => $shortUrl)), array())->once()
                ->string($longUrl)->isIdenticalTo($longUrl)
        ;
    }

    private function getMockGuzzleAdapter()
    {
        return new \mock\Rezzza\Shorty\Http\GuzzleAdapter();
    }
}
