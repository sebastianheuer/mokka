<?php
namespace Mokka\Tests\Integration;

use Mokka\Mokka;
use Mokka\Tests\Integration\Fixtures\Foo;
use Mokka\Tests\Integration\Fixtures\SampleClass;

class MockTest extends MockTestCase
{
    /**
     * @var Mokka
     */
    private $_mokka;

    public function setUp()
    {
        $this->_mokka = new Mokka();
    }

    /**
     * @dataProvider magicMethodProvider
     * @param string $method
     */
    public function testMockedMagicMethodIsEmpty($method)
    {
        $mock = $this->_mokka->mock(SampleClass::class);
        $mockedMethod = new \ReflectionMethod($mock, $method);
        $this->assertEquals(0, $mockedMethod->getNumberOfParameters());
        $this->assertNull($mock->$method());
    }

    public static function magicMethodProvider()
    {
        return array(
            array('__construct'),
            array('__destruct'),
        );
    }

    /**
     * @testdox the mocked method contains the array parameter of the original method
     */
    public function testMockedMethodHasArrayParam()
    {
        $mock = $this->_mokka->mock(SampleClass::class);
        $mockedMethod = new \ReflectionMethod($mock, 'setFoos');
        $this->assertEquals(1, $mockedMethod->getNumberOfParameters());
        $this->assertParameterIsArray($mockedMethod, 'foos');
    }

    /**
     * @testdox the mocked method contains the class parameter of the original method
     */
    public function testMockedMethodHasClassParam()
    {
        $mock = $this->_mokka->mock(SampleClass::class);
        $mockedMethod = new \ReflectionMethod($mock, 'setFoo');
        $this->assertEquals(1, $mockedMethod->getNumberOfParameters());
        $this->assertParameterHasType($mockedMethod, 'foo', Foo::class);
    }

} 