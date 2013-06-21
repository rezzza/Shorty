<?php

namespace Rezzza\Shorty\tests\units;

require_once __DIR__ . '/../../vendor/autoload.php';

use \mageekguy\atoum;
use Rezzza\Shorty\Google as TestedGoogle;

/**
 * @author Jérémy Romey <jeremy@free-agent.fr>
 */
class Google extends atoum\test
{
    public function testConstruct()
    {
        $this
            ->if($shortener = new TestedGoogle())
                ->variable($shortener->getApiKey())
                    ->isNull()
                ->string($shortener->getFormat())
                    ->isIdenticalTo('json')
            ->if($apiKey = 'chuck-testa-key')
            ->and($shortener = new TestedGoogle($apiKey))
                ->string($shortener->getApiKey())
                    ->isIdenticalTo('chuck-testa-key')
                ->string($shortener->getFormat())
                    ->isIdenticalTo('json')
            ->if($format = 'xml')
            ->and($shortener = new TestedGoogle(null, $format))
                ->variable($shortener->getApiKey())
                    ->isNull()
                ->string($shortener->getFormat())
                    ->isIdenticalTo('xml')
            ->if($apiKey = 'chuck-testa-key')
            ->and($format = 'xml')
            ->and($shortener = new TestedGoogle($apiKey, $format))
                ->string($shortener->getApiKey())
                    ->isIdenticalTo('chuck-testa-key')
                ->string($shortener->getFormat())
                    ->isIdenticalTo('xml')
        ;
    }

    public function testShorten()
    {
        $this
            ->if($shortener = new TestedGoogle())
                ->string($shortener->shorten('http://www.verylastroom.com/'))
                    ->isNotNull()
        ;
    }

    public function testExpand()
    {
        $this
            ->if($shortener = new TestedGoogle())
                ->string($shortener->expand('http://goo.gl/YY5Tz'))
                    ->isNotNull()
                    ->isIdenticalTo('http://www.verylastroom.com/')
        ;
    }
}
