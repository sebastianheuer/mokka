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

    public function testSetOwner()
    {
        $this->assertAttributeEmpty('_owner', $this->_mock);
        $owner = $this->getMockBuilder('\Mokka\Mokka')->disableOriginalConstructor()->getMock();
        $this->_mock->setOwner($owner);
        $this->assertAttributeEquals($owner, '_owner', $this->_mock);
    }

    public function testListenSetsProperties()
    {
        $this->assertAttributeEquals(FALSE, '_listening', $this->_mock);
        $this->assertAttributeEquals(FALSE, '_listeningForStub', $this->_mock);

        $this->_mock->listen(FALSE);
        $this->assertAttributeEquals(TRUE, '_listening', $this->_mock);
        $this->assertAttributeEquals(FALSE, '_listeningForStub', $this->_mock);

        $this->_mock->listen(TRUE);
        $this->assertAttributeEquals(TRUE, '_listening', $this->_mock);
        $this->assertAttributeEquals(TRUE, '_listeningForStub', $this->_mock);
    }

    public function testAddsExpectedStub()
    {
        $this->_mock->listen(TRUE);
        $this->_mock->doFoo();
        $this->_mock->addStub('someValue');
        $expected = array(
            md5('doFoo') => new StubbedMethod(array(), 'someValue')
        );
        $this->assertAttributeEquals($expected, '_methods', $this->_mock);
    }

    public function testAddsExpectedMethod()
    {
        $this->_mock->listen(FALSE);
        $this->_mock->doFoo();
        $expected = array(
            md5('doFoo') => new MockedMethod(array(), 'someValue')
        );
        $this->assertAttributeEquals($expected, '_methods', $this->_mock);
    }

} 