<?php
namespace Mokka\Tests;

use Mokka\Method\StubbedMethod;

class StubbedMethodTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Mokka\VerificationException
     */
    public function testCallThrowsExceptionIfArgumentIsMissing()
    {
        $method = new StubbedMethod(array('foo'), 'bar');
        $method->call(array());
    }

    /**
     * @expectedException \Mokka\VerificationException
     */
    public function testCallThrowsExceptionIfArgumentDoesNotMatchExpectedValue()
    {
        $method = new StubbedMethod(array('foo'), 'bar');
        $method->call(array('bar'));
    }

    /**
     * 
     */
    public function testCallReturnsExpectedReturnValueIfArgumentsMatch()
    {
        $method = new StubbedMethod(array('foo'), 'bar');
        $this->assertEquals('bar', $method->call(array('foo')));
    }
} 