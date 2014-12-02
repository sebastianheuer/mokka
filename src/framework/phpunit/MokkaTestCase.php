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
namespace Mokka\PHPUnit;

use Mokka\Method\Invokation\InvokationRule;
use Mokka\Mock\MockInterface;
use Mokka\Mokka;

/**
 * @author     Sebastian Heuer <belanur@gmail.com>
 * @copyright  Sebastian Heuer <belanur@gmail.com>, All rights reserved.
 * @license    BSD License
 * @link       https://github.com/belanur/mokka
 */
abstract class MokkaTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $classname
     * @return \Mokka\Mock\Mock
     */
    public function mock($classname)
    {
        return Mokka::mock($classname);
    }

    /**
     * @param MockInterface $mock
     * @return MockInterface
     */
    public function when(MockInterface $mock)
    {
        return Mokka::when($mock);
    }

    /**
     * @param MockInterface $mock
     * @param null|int|InvokationRule $expectedInvokationCount
     * @return MockInterface
     */
    public function verify(MockInterface $mock, $expectedInvokationCount = NULL)
    {
        /* Workaround for PHPUnit Warning "This test did not perform any assertions".
         * A verification on a mock object is some kind of assertion
         */
        $this->assertTrue(TRUE);
        return Mokka::verify($mock, $expectedInvokationCount);
    }

    /**
     * @return \Mokka\Method\Invokation\Once
     */
    public static function once()
    {
        return Mokka::once();
    }

    /**
     * @param int $count
     * @return \Mokka\Method\Invokation\Exactly
     */
    public static function exactly($count)
    {
        return Mokka::exactly($count);
    }

    /**
     * @return \Mokka\Method\Invokation\Never
     */
    public static function never()
    {
        return Mokka::never();
    }

    /**
     * @param int $count
     * @return \Mokka\Method\Invokation\AtLeast
     */
    public static function atLeast($count)
    {
        return Mokka::atLeast($count);
    }

    /**
     * @return \Mokka\Method\AnythingArgument
     */
    public static function anything()
    {
        return Mokka::anything();
    }

} 
