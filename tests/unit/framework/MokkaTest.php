<?php
namespace Mokka\Tests;

use Mokka\Mokka;
use Mokka\Method\StubbedMethod;

class MokkaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Mokka
     */
    private $_mokka;

    public function setUp()
    {
        $this->_mokka = new Mokka();
    }

    public function testWhenLetsMockListen()
    {
        $mock = new MockStub();
        $this->_mokka->when($mock);
        $this->assertAttributeEquals(TRUE, '_listening', $mock);
    }

    public function testVerifyLetsMockListen()
    {
        $mock = new MockStub();
        $this->_mokka->verify($mock);
        $this->assertAttributeEquals(TRUE, '_listening', $mock);
    }

    public function testWhenReturnsMock()
    {
        $mock = new MockStub();
        $this->assertSame($mock, $this->_mokka->when($mock));
    }

    public function testThenReturnAddsStubToMock()
    {
        $mock = new MockStub();
        $mock->setOwner($this->_mokka);
        $this->_mokka->when($mock)->doFoo()->thenReturn('bar');
        $expected = array(
            md5('doFoo') => new StubbedMethod(array(), 'bar')
        );
        $this->assertAttributeEquals($expected, '_methods', $mock);
    }

    public function testMockReturnsExpectedMock()
    {
        $mock = $this->_mokka->mock('\Mokka\Tests\ClassStub');
        $this->assertTrue(strpos(get_class($mock), 'Mokka_Mocked__') !== FALSE);
        $this->assertNull($mock->getBar());
    }
}