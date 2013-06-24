<?php

namespace Rezzza\Shorty\tests\units\Provider;

require_once __DIR__ . '/../../../vendor/autoload.php';

use \mageekguy\atoum;
use Rezzza\Shorty\Provider\Google as TestedGoogle;
use Rezzza\Shorty\Http\GuzzleAdapter;

/**
 * @author Jérémy Romey <jeremy@free-agent.fr>
 */
class Google extends atoum\test
{
    public function testShorten()
    {
        $this
            ->if($shortener = new TestedGoogle())
            ->and($shortener->setHttpAdapter(new GuzzleAdapter()))
                ->string($shortener->shorten('http://www.verylastroom.com/'))
                    ->isIdenticalTo('http://goo.gl/YY5Tz')
        ;
    }

    public function testExpand()
    {
        $this
            ->if($shortener = new TestedGoogle())
            ->and($shortener->setHttpAdapter(new GuzzleAdapter()))
                ->string($shortener->expand('http://goo.gl/YY5Tz'))
                    ->isIdenticalTo('http://www.verylastroom.com/')
        ;
    }
}
