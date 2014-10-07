<?php
/**
 * Copyright (c) 2014 Sebastian Heuer <belanur@gmail.com>
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 *   * Redistributions of source code must retain the above copyright notice,
 *     this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright notice,
 *     this list of conditions and the following disclaimer in the documentation
 *     and/or other materials provided with the distribution.
 *
 *   * Neither the name of Sebastian Heuer nor the names of contributors
 *     may be used to endorse or promote products derived from this software
 *     without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER ORCONTRIBUTORS
 * BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 */
namespace Mokka\Tests;

use Mokka\Method\ArgumentCollection;
use Mokka\Method\Invokation\Once;
use Mokka\Method\MethodCollection;
use Mokka\Method\MockedMethod;
use Mokka\Method\StubbedMethod;
use Mokka\Mock;

/**
 * @author     Sebastian Heuer <belanur@gmail.com>
 * @copyright  Sebastian Heuer <belanur@gmail.com>, All rights reserved.
 * @license    BSD License
 * @link       https://github.com/belanur/mokka
 */
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
        $this->_mock->listenForStub();
        $this->_mock->doFoo();
        $this->_mock->thenReturn('someValue');
        $expected = new MethodCollection();
        $expected->addMethod(new StubbedMethod('doFoo', new ArgumentCollection(), 'someValue'));
        $this->assertAttributeEquals($expected, '_stubs', $this->_mock);
    }

    public function testAddsExpectedMethod()
    {
        $this->_mock->listenForVerification();
        $this->_mock->doFoo();

        $expectedMethod = new MockedMethod('doFoo', new ArgumentCollection(), new Once());
        $expected = new MethodCollection();
        $expected->addMethod($expectedMethod);
        $this->assertAttributeEquals($expected, '_methods', $this->_mock);

        // Workaround to prevent a VerificationException on $expectedMethod
        $expectedMethod->call(new ArgumentCollection());
        $this->_mock->doFoo();
    }

    /**
     * @expectedException \Mokka\VerificationException
     */
    public function testThrowsExceptionIfVerifiedMethodWasNotCalled()
    {
        $this->_mock->listenForVerification();
        $this->_mock->doFoo();
        unset($this->_mock);
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testThenReturnThrowsExceptionIfMockIsNotListeningForStub()
    {
        $this->_mock->thenReturn('foo');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testListenForVerificationThrowsExceptionIfInvokationRuleIsInvalid()
    {
        $this->_mock->listenForVerification('foo');
    }

} 
