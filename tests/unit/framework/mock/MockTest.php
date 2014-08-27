<?php
namespace Mokka\Tests;

use Mokka\Method\MockedMethod;
use Mokka\Method\StubbedMethod;
use Mokka\Mock;

class MockTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MockStub
     */
    private $_mock;

    public function setUp()
    {
        $this->_mock = new MockStub();
    }

    public function testAddsExpectedStub()
    {
        $this->_mock->listenForStub(TRUE);
        $this->_mock->doFoo();
        $this->_mock->thenReturn('someValue');
        $expected = array(
            md5('doFoo') => new StubbedMethod(array(), 'someValue')
        );
        $this->assertAttributeEquals($expected, '_methods', $this->_mock);
    }

    public function testAddsExpectedMethod()
    {
        $this->_mock->listenForStub(FALSE);
        $this->_mock->doFoo();
        $expected = array(
            md5('doFoo') => new MockedMethod(array(), 'someValue')
        );
        $this->assertAttributeEquals($expected, '_methods', $this->_mock);
    }

} 