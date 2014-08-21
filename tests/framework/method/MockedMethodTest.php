<?php
namespace Mokka\Tests;

use Mokka\MockedMethod;

class MockedMethodTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Mokka\VerificationException
     */
    public function testCallThrowsExceptionIfArgumentIsMissing()
    {
        $method = new MockedMethod(array('foo'));
        $method->call(array());
    }

    /**
     * @expectedException \Mokka\VerificationException
     */
    public function testCallThrowsExceptionIfArgumentDoesNotMatchExpectedValue()
    {
        $method = new MockedMethod(array('foo'));
        $method->call(array('bar'));
    }

    /**
     *
     */
    public function testCallReturnsNullIfArgumentsMatch()
    {
        $method = new MockedMethod(array('foo'));
        $this->assertNull($method->call(array('foo')));
    }
} 