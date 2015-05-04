<?php
/**
 * Copyright (c) 2014, 2015 Sebastian Heuer <sebastian@phpeople.de>
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

use Mokka\Method\Argument;
use Mokka\Method\ArgumentCollection;
use Mokka\Method\Invokation\Any;
use Mokka\Method\MockedMethod;

/**
 * @author     Sebastian Heuer <sebastian@phpeople.de>
 * @copyright  Sebastian Heuer <sebastian@phpeople.de>, All rights reserved.
 * @license    BSD License
 * @link       https://github.com/belanur/mokka
 */
class MockedMethodTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \Mokka\VerificationException
     */
    public function testCallThrowsExceptionIfArgumentIsMissing()
    {
        $arguments = new ArgumentCollection(array('foo'));
        $method = new MockedMethod('foo', $arguments, new Any());
        $method->call(new ArgumentCollection());
        $method->verify();
    }

    /**
     * @expectedException \Mokka\VerificationException
     */
    public function testCallThrowsExceptionIfArgumentDoesNotMatchExpectedValue()
    {
        $arguments = new ArgumentCollection();
        $arguments->addArgument(new Argument('foo'));
        $method = new MockedMethod('foo', $arguments, new Any());
        $method->call(new ArgumentCollection(array('bar')));
        $method->verify();
    }

    /**
     *
     */
    public function testCallReturnsNullIfArgumentsMatch()
    {
        $method = new MockedMethod('foo', new ArgumentCollection(array('foo')), new Any());
        $this->assertNull($method->call(new ArgumentCollection(array('foo'))));
        $method->verify();
    }

    public function testGetIdentifierReturnsExpectedString()
    {
        $method = new MockedMethod('foo', new ArgumentCollection(array('foo')), new Any());
        $expectedIdentifier = '691e456906864441ca48f76144b59794';
        $this->assertSame($expectedIdentifier, $method->getIdentifier());
        $method->verify();
    }

} 
