<?php

require_once "../src/DummyFileGenerator.php";

use CodeCauldron\Tools\File\DummyFileGenerator;
use PHPUnit\Framework\TestCase;

class DummyFileGeneratorTest extends TestCase
{

    const SIZE_3 = 3;

    const SIZE_100 = 100;

    const SIZE_125 = 125;

    protected static function getMethod(string $name): ReflectionMethod
    {
        $class  = new ReflectionClass('CodeCauldron\Tools\File\DummyFileGenerator');
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    protected static function convertToByte(int $size, int $unit): int
    {
        return floor($size * pow(1024, $unit));
    }

    public function testCreateFile100B()
    {
        $method = self::getMethod('writeDummyFile');
        $gen    = new DummyFileGenerator();
        $unit   = DummyFileGenerator::B;
        $bytes  = self::convertToByte(self::SIZE_100, $unit);
        $method->invokeArgs($gen, [$bytes]);

        self::assertEquals($bytes, filesize(self::SIZE_100.".txt"));

        unlink($bytes.".txt");
    }

    public function testCreateFile125kB()
    {
        $method = self::getMethod('writeDummyFile');
        $gen    = new DummyFileGenerator();
        $unit   = DummyFileGenerator::KB;
        $bytes  = self::convertToByte(self::SIZE_125, $unit);
        $method->invokeArgs($gen, [$bytes]);

        self::assertEquals($bytes, filesize($bytes.".txt"));

        unlink($bytes.".txt");
    }


    public function testCreateFile3MB()
    {
        $method = self::getMethod('writeDummyFile');
        $gen    = new DummyFileGenerator();
        $unit   = DummyFileGenerator::MB;
        $bytes  = self::convertToByte(self::SIZE_3, $unit);
        $method->invokeArgs($gen, [$bytes]);

        self::assertEquals($bytes, filesize($bytes.".txt"));

        unlink($bytes.".txt");
    }

    public function testZipping()
    {
        $zipMethod   = self::getMethod('writeZipFile');
        $dummyMethod = self::getMethod('writeDummyFile');
        $gen         = new DummyFileGenerator();
        $unit        = DummyFileGenerator::MB;
        $bytes       = self::convertToByte(self::SIZE_3, $unit);
        $dummyMethod->invokeArgs($gen, [$bytes]);
        $zipMethod->invokeArgs($gen, [$bytes]);

        self::assertGreaterThan(0, filesize($bytes.".txt.gz"));
        self::assertNotEquals(filesize($bytes.".txt.gz"), filesize($bytes.".txt"));
        self::assertLessThan(filesize($bytes.".txt"), filesize($bytes.".txt.gz"));

        unlink($bytes.".txt");
        unlink($bytes.".txt.gz");
    }

}
