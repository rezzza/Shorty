Shorty Documentation
====================

.. image:: https://poser.pugx.org/rezzza/shorty/version.png
   :target: https://packagist.org/packages/rezzza/shorty

.. image:: https://secure.travis-ci.org/Rezzza/Shorty.png?branch=master
   :target: http://travis-ci.org/Rezzza/Shorty

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
Shorty requires `Guzzle`.

Usage
-----
Example with the Google shortener:

.. code-block:: php

    $googleShortener = new \Rezzza\Shorty\Google();
    $shortUrl = $googleShortener->shorten('http://www.verylastroom.com/');
    $longUrl = $googleShortener->expand('http://goo.gl/YY5Tz');


Unit Tests
----------

You can run tests with:

.. code-block:: sh

    bin/atoum -d tests/units

Release notes
-------------

1.0.0

* Added Google Url Shortener.
