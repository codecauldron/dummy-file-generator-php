# Dummy File Generator in PHP

This is a demo for a Dummy File Generator. The code belongs to a tutorial that you can
find [here](https://www.codecauldron.dev/2021/02/12/dummy-file-generator-in-php/).

## Prerequisites

* PHP 7.1+ (PHP 7.3+ for phpunit)
* fileinfo support enabled in php.ini
* gzip compression enabled in php.ini
* composer (only needed to install dependencies for the unit tests)

## How to use

In the src folder you will find the DummyFileGenerator.php file. This class contains the code for creating and sending a
zipped dummy file to the user.

```php
use CodeCauldron\Tools\File\DummyFileGenerator;

$gen = new DummyFileGenerator();
$gen->generateFile(250, DummyFileGenerator::KB);
````

