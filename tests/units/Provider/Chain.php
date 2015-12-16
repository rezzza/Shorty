<?php

namespace Rezzza\Shorty\tests\units\Provider;

require_once __DIR__ . '/../../../vendor/autoload.php';

use \mageekguy\atoum;
use Rezzza\Shorty\Exception\Exception;

/**
 * Chain
 *
 * @uses atoum\test
 * @author Stephane PY <py.stephane1@gmail.com>
 */
class Chain extends atoum\test
{
    public function testShorten()
    {
        $this
            ->if($shortener = new \mock\Rezzza\Shorty\Provider\Chain())
            // google
            ->and($this->mockGenerator->orphanize('__construct'))
            ->and($google = new \mock\Rezzza\Shorty\Provider\Google())
            ->and($google->getMockController()->shorten = function() { return 'bar'; })
            // bitly
            ->and($this->mockGenerator->orphanize('__construct'))
            ->and($bitly = new \mock\Rezzza\Shorty\Provider\Bitly())
            // add providers
            ->and($shortener->addProvider($google))
            ->and($shortener->addProvider($bitly))

            ->phpString($shortener->shorten('foo'))->isEqualTo('bar')
            ->mock($google)->call('shorten')->once()
            ->mock($bitly)->call('shorten')->never()

            ->mock($google)->reset()
            ->mock($bitly)->reset()

            // recall with exception on google
            ->and($google->getMockController()->shorten = function() { throw new Exception(); })
            ->and($bitly->getMockController()->shorten = function() { return 'baz'; })

            ->phpString($shortener->shorten('foo'))->isEqualTo('baz')
            ->mock($google)->call('shorten')->once()
            ->mock($bitly)->call('shorten')->once()

            ->mock($google)->reset()
            ->mock($bitly)->reset()

            // 2 providers throws exception
            ->and($google->getMockController()->shorten = function() { throw new Exception(); })
            ->and($bitly->getMockController()->shorten = function() { throw new Exception(); })

            ->exception(function() use ($shortener) {
                $shortener->shorten('foo');
            })
                ->isInstanceOf('Rezzza\Shorty\Exception\Exception')
                ->hasMessage('2 providers cannot shorten url foo')
        ;
    }

    public function testExpand()
    {
        $this
            ->if($expander = new \mock\Rezzza\Shorty\Provider\Chain())
            // google
            ->and($this->mockGenerator->orphanize('__construct'))
            ->and($google = new \mock\Rezzza\Shorty\Provider\Google())
            ->and($google->getMockController()->expand = function() { return 'bar'; })
            // bitly
            ->and($this->mockGenerator->orphanize('__construct'))
            ->and($bitly = new \mock\Rezzza\Shorty\Provider\Bitly())
            // add providers
            ->and($expander->addProvider($google))
            ->and($expander->addProvider($bitly))

            ->phpString($expander->expand('foo'))->isEqualTo('bar')
            ->mock($google)->call('expand')->once()
            ->mock($bitly)->call('expand')->never()

            ->mock($google)->reset()
            ->mock($bitly)->reset()

            // recall with exception on google
            ->and($google->getMockController()->expand = function() { throw new Exception(); })
            ->and($bitly->getMockController()->expand = function() { return 'baz'; })

            ->phpString($expander->expand('foo'))->isEqualTo('baz')
            ->mock($google)->call('expand')->once()
            ->mock($bitly)->call('expand')->once()

            ->mock($google)->reset()
            ->mock($bitly)->reset()

            // 2 providers throws exception
            ->and($google->getMockController()->expand = function() { throw new Exception(); })
            ->and($bitly->getMockController()->expand = function() { throw new Exception(); })

            ->exception(function() use ($expander) {
                $expander->expand('foo');
            })
                ->isInstanceOf('Rezzza\Shorty\Exception\Exception')
                ->hasMessage('2 providers cannot expand url foo')
        ;
    }
}
