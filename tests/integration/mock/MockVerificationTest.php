<?php
/**
 * Copyright (c) 2014, 2015 Sebastian Heuer <belanur@gmail.com>
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
namespace Mokka\Tests\Integration;

use Mokka\Method\Invokation\Exactly;
use Mokka\Method\Invokation\Never;
use Mokka\Mock\Mock;
use Mokka\Mokka;
use Mokka\Tests\Integration\Fixtures\SampleClass;

/**
 * @author     Sebastian Heuer <belanur@gmail.com>
 * @copyright  Sebastian Heuer <belanur@gmail.com>, All rights reserved.
 * @license    BSD License
 * @link       https://github.com/belanur/mokka
 */
class MockVerificationTest extends MockTestCase
{
    /**
     * @expectedException \Mokka\VerificationException
     */
    public function testThrowsExceptionIfVerificationIsNotMet()
    {
        $mock = Mokka::mock('\Mokka\Tests\Integration\Fixtures\SampleClass');
        Mokka::verify($mock)->setBar();
    }

    public function testDoesNotThrowExeptionIfVerifiedMethodWasCalled()
    {
        $mock = Mokka::mock('\Mokka\Tests\Integration\Fixtures\SampleClass');
        Mokka::verify($mock)->setBar();
        $this->assertNull($mock->setBar());
    }

    public function testVerifiesIfParamIsNull()
    {
        $mock = Mokka::mock('\Mokka\Tests\Integration\Fixtures\SampleClass');
        Mokka::verify($mock)->setFoobar('foo', NULL);
        $this->assertNull($mock->setFoobar('foo', NULL));
    }

    public function testVerifiesMethodWithAnythingParam()
    {
        $mock = Mokka::mock('\Mokka\Tests\Integration\Fixtures\SampleClass');
        Mokka::verify($mock)->setFoobar(Mokka::anything(), 'foo');
        $this->assertNull($mock->setFoobar('bar', 'foo'));
    }

    /**
     * @expectedException \Mokka\VerificationException
     * @expectedExceptionMessage Method should have been called exactly 3 times, but was called 2 times
     */
    public function testThrowsExceptionIfExpectedInvokationCountIsNotMet()
    {
        $mock = Mokka::mock('\Mokka\Tests\Integration\Fixtures\SampleClass');
        Mokka::verify($mock, new Exactly(3))->setBar();
        $mock->setBar();
        $mock->setBar();
    }

    /**
     * @expectedException \Mokka\VerificationException
     */
    public function testVerifiesThatMethodWasNotCalled()
    {
        $mock = Mokka::mock('\Mokka\Tests\Integration\Fixtures\SampleClass');
        Mokka::verify($mock, new Never())->setBar();
        $mock->setBar();
    }

} 
