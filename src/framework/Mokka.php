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
namespace Mokka;

use Mokka\Method\AnythingArgument;
use Mokka\Method\Invokation\AtLeast;
use Mokka\Method\Invokation\Exactly;
use Mokka\Method\Invokation\InvokationRule;
use Mokka\Method\Invokation\Never;
use Mokka\Method\Invokation\Once;
use Mokka\Mock\MockBuilder;
use Mokka\Mock\MockInterface;

/**
 * @author     Sebastian Heuer <sebastian@phpeople.de>
 * @copyright  Sebastian Heuer <sebastian@phpeople.de>, All rights reserved.
 * @license    BSD License
 * @link       https://github.com/belanur/mokka
 */
class Mokka
{
    /**
     * @var MockBuilder
     */
    private static $_mockBuilder;

    /**
     * Mock an object
     *
     * @param string $classname
     * @return \Mokka\Mock\MockInterface
     */
    public static function mock($classname)
    {
        return static::_getMockBuilder()->getMock($classname);
    }

    /**
     * @param MockInterface $mock
     * @return MockInterface
     */
    public static function when(MockInterface $mock)
    {
        $mock->listenForStub();

        return $mock;
    }

    /**
     * @param MockInterface $mock
     * @param InvokationRule|NULL|int $expectedInvokationCount
     * @throws \InvalidArgumentException
     * @return MockInterface
     */
    public static function verify(MockInterface $mock, $expectedInvokationCount = null)
    {
        $mock->listenForVerification($expectedInvokationCount);

        return $mock;
    }

    /**
     * @return MockBuilder
     */
    private static function _getMockBuilder()
    {
        if (null === static::$_mockBuilder) {
            static::$_mockBuilder = new MockBuilder();
        }

        return static::$_mockBuilder;
    }

    /**
     * @return Never
     */
    public static function never()
    {
        return new Never();
    }

    /**
     * @return Once
     */
    public static function once()
    {
        return new Once();
    }

    /**
     * @param int $count
     * @return AtLeast
     */
    public static function atLeast($count)
    {
        return new AtLeast($count);
    }

    /**
     * @param int $count
     * @return Exactly
     */
    public static function exactly($count)
    {
        return new Exactly($count);
    }

    /**
     * @return AnythingArgument
     */
    public static function anything()
    {
        return new AnythingArgument();
    }

} 
