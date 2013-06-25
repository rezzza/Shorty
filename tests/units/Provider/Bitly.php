<?php

namespace Rezzza\Shorty\tests\units\Provider;

require_once __DIR__ . '/../../../vendor/autoload.php';

use \mageekguy\atoum;
use Rezzza\Shorty\Provider\Bitly as TestedBitly;
use Rezzza\Shorty\Http\GuzzleAdapter;

/**
 * @author Sébastien HOUZÉ <s@verylastroom.com> 
 */
class Bitly extends atoum\test
{
    /*
    public function __construct()
    {
        parent::__construct();

        $this->accessToken = ''; // You have to provide your own access token here
    }

    public function testShorten()
    {
        $this
            ->if($shortener = new TestedBitly($this->accessToken))
            ->and($shortener->setHttpAdapter(new GuzzleAdapter()))
            ->string($shortener->shorten('http://www.verylastroom.com/'))
            ->isIdenticalTo('http://bit.ly/19lJjpY')
            ;
    }

    public function testExpand()
    {
        $this
            ->if($shortener = new TestedBitly($this->accessToken))
            ->and($shortener->setHttpAdapter(new GuzzleAdapter()))
            ->string($shortener->expand('http://bit.ly/19lJjpY'))
            ->isIdenticalTo('http://www.verylastroom.com/')
            ;
    }
     */

    public function testInstanciateWihtoutAccessToken()
    {
        $this
            ->exception(function() { new TestedBitly(null); })
            ->isInstanceOf('\LogicException')
            ->hasMessage('You must provide an accessToken on bitly provider creation');

        $this
            ->exception(function() { new TestedBitly(""); })
            ->isInstanceOf('\LogicException')
            ->hasMessage('You must provide an accessToken on bitly provider creation');
    }
}
