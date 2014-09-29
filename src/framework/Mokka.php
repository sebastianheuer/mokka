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
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT  * NOT LIMITED TO,
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
use Mokka\Mock\MockInterface;

/**
 * @author     Sebastian Heuer <belanur@gmail.com>
 * @copyright  Sebastian Heuer <belanur@gmail.com>, All rights reserved.
 * @license    BSD License
 * @link       https://github.com/belanur/mokka
 */
class Mokka
{
    /**
     * Mock an object
     *
     * @param string $classname
     * @return \Mokka\Mock\MockInterface
     */
    public static function mock($classname)
    {
        $mockClassname = self::_getMockClassname($classname);
        $classDefinition = self::_getClass($mockClassname, $classname);
        /* TODO this is probably the most evil line of code I have ever written.
           Maybe there is a nicer way to dynamically create a class */
        eval($classDefinition);
        /** @var MockInterface $mock */
        return new $mockClassname();
    }

    /**
     * @param string $originalClassname
     * @return string
     */
    private static function _getMockClassname($originalClassname)
    {
        $originalClassname = str_replace('\\', '_', $originalClassname);
        return sprintf('Mokka_Mocked_%s_%s', $originalClassname, (string)new Token());
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
     * @param string $mockClassname
     * @param string $classname
     * @return string
     */
    private static function _getClass($mockClassname, $classname)
    {
        $builder = new ClassBuilder(new FunctionBuilder());
        return $builder->build($mockClassname, $classname);
    }

    /**
     * @param MockInterface $mock
     * @param InvokationRule|NULL|int $expectedInvokationCount
     * @throws \InvalidArgumentException
     * @return MockInterface
     */
    public static function verify(MockInterface $mock, $expectedInvokationCount = NULL)
    {
        $mock->listenForVerification($expectedInvokationCount);
        return $mock;
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
