<?php
namespace Mokka\Tests;

use Mokka\Method\Invokation\Any;
use Mokka\Method\MockedMethod;

class MockedMethodTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Mokka\VerificationException
     */
    public function testCallThrowsExceptionIfArgumentIsMissing()
    {
        $method = new MockedMethod(array('foo'), new Any());
        $method->call(array());
    }

    /**
     * @expectedException \Mokka\VerificationException
     */
    public function testCallThrowsExceptionIfArgumentDoesNotMatchExpectedValue()
    {
        $method = new MockedMethod(array('foo'), new Any());
        $method->call(array('bar'));
    }

    /**
     *
     */
    public function testCallReturnsNullIfArgumentsMatch()
    {
        $method = new MockedMethod(array('foo'), new Any());
        $this->assertNull($method->call(array('foo')));
    }

} 