Shorty Documentation
====================

.. image:: https://poser.pugx.org/rezzza/Shorty/version.png
   :target: https://packagist.org/packages/rezzza/Shorty

.. image:: https://travis-ci.org/rezzza/Shorty.png?branch=master
   :target: http://travis-ci.org/Rezzza/Shorty

Underwear for your long urls

Installation
------------
Use `Composer <https://github.com/composer/composer/>`_ to install: ``rezzza/shorty``.

In your `composer.json` you should have:

.. code-block:: yaml

    {
        "require": {
            "rezzza/shorty": "1.0.*"
        }
    }

Requirements
~~~~~~~~~~~~
Shorty requires `Guzzle <https://github.com/guzzle/guzzle>`_.

Usage
-----
Example with the Google shortener:

.. code-block:: php

    $googleShortener = new \Rezzza\Shorty\Provider\Google();
    $googleShortener->setHttpAdapter(new \Rezzza\Shorty\Http\GuzzleAdapter());
    // or
    // $googleShortener->setHttpAdapter(new \Rezzza\Shorty\Http\CurlAdapter());
    $shortUrl        = $googleShortener->shorten('http://www.verylastroom.com/');
    $longUrl         = $googleShortener->expand('http://goo.gl/YY5Tz');


Unit Tests
----------

You can run tests with:

.. code-block:: sh

    bin/atoum -d tests/units

Release notes
-------------

1.0.0

* Added Google Url Shortener.
* Added Bitly Url Shortener.
* Added Curl Http adapter.
