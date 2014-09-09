<?php
namespace Mokka\Tests\Integration;

use Mokka\Mock\Mock;
use Mokka\Mokka;
use Mokka\Tests\Integration\Fixtures\Foo;
use Mokka\Tests\Integration\Fixtures\FooInterface;
use Mokka\Tests\Integration\Fixtures\SampleClass;

class MockTest extends MockTestCase
{
    /**
     * @var SampleClass
     */
    private $_mock;

    public function setUp()
    {
        $this->_mock = Mokka::mock(SampleClass::class);
    }

    /**
     * @testdox mocked magic methods (like __construct()) have no parameters
     *
     * @dataProvider magicMethodProvider
     * @param string $method
     */
    public function testMockedMagicMethodHasNoParameters($method)
    {
        $mockedMethod = new \ReflectionMethod($this->_mock, $method);
        $this->assertEquals(0, $mockedMethod->getNumberOfParameters());
    }

    public static function magicMethodProvider()
    {
        return array(
            array('__construct'),
            array('__destruct'),
        );
    }

    /**
     * @testdox mocked method contains the array parameter of the original method
     */
    public function testMockedMethodHasArrayParam()
    {
        $mockedMethod = new \ReflectionMethod($this->_mock, 'setFoos');
        $this->assertEquals(1, $mockedMethod->getNumberOfParameters());
        $this->assertParameterIsArray($mockedMethod, 'foos');
    }

    /**
     * @testdox mocked method contains the parameter type of the original method
     */
    public function testMockedMethodHasClassParam()
    {
        $mockedMethod = new \ReflectionMethod($this->_mock, 'setFoo');
        $this->assertEquals(1, $mockedMethod->getNumberOfParameters());
        $this->assertParameterHasType($mockedMethod, 'foo', Foo::class);
    }

    /**
     * @testdox mocked method contains the optional parameter of the original method
     */
    public function testMockedMethodHasOptionalParameter()
    {
        $mockedMethod = new \ReflectionMethod($this->_mock, 'setBar');
        $this->assertParameterHasDefaultValue($mockedMethod, 'bar', NULL);

        $mockedMethod = new \ReflectionMethod($this->_mock, 'setBaz');
        $this->assertParameterHasDefaultValue($mockedMethod, 'baz', 'baz');
    }

    public function testMocksInterface()
    {
        $mock = Mokka::mock(FooInterface::class);
        $this->assertNull($mock->getFoo());
    }

    public function testAllowsCombinationOfMockAndStub()
    {
        Mokka::verify($this->_mock)->setBar();
        Mokka::when($this->_mock)->setBar()->thenReturn(TRUE);
        $this->assertTrue($this->_mock->setBar());
    }

    /**
     * @expectedException \Mokka\VerificationException
     */
    public function testThrowsExceptionIfCombinedMockAndStubWasNotCalled()
    {
        Mokka::verify($this->_mock)->setBar();
        Mokka::when($this->_mock)->setBar()->thenReturn(TRUE);
        unset($this->_mock);
    }

} 