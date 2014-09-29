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
namespace Mokka\Method;

use Mokka\Method\Invokation\InvokationRule;
use Mokka\VerificationException;

/**
 * @author     Sebastian Heuer <belanur@gmail.com>
 * @copyright  Sebastian Heuer <belanur@gmail.com>, All rights reserved.
 * @license    BSD License
 * @link       https://github.com/belanur/mokka
 */
class MockedMethod implements Method
{
    /**
     * @var ArgumentCollection
     */
    private $_expectedArgs;

    /**
     * @var bool indicates if this method has been called during execution (only relevant if $_mustBeCalled is TRUE)
     */
    private $_invokationCounter = 0;

    /**
     * @var InvokationRule number of times this method should be called during execution
     */
    private $_invokationRule;

    /**
     * @var string
     */
    private $_name = '';

    /**
     * @param string $name
     * @param ArgumentCollection $expectedArgs
     * @param Invokation\InvokationRule $expectedInvokationCount
     */
    public function __construct($name, ArgumentCollection $expectedArgs, InvokationRule $expectedInvokationCount)
    {
        $this->_name = $name;
        $this->_expectedArgs = $expectedArgs;
        $this->_invokationRule = $expectedInvokationCount;
    }

    /**
     * @param ArgumentCollection $actualArgs
     * @throws VerificationException
     * @return null
     */
    public function call(ArgumentCollection $actualArgs)
    {
        $this->_invokationCounter++;
        $i = 0;
        foreach ($this->_expectedArgs->getArguments() as $index => $expectedArgument) {
            if (!$actualArgs->hasArgumentAtPosition($index)) {
                throw new VerificationException(
                    sprintf('Argument %s should be %s, is missing', $i, $expectedArgument->getValue())
                );
            }
            $actualArgument = $actualArgs->getArgumentAtPosition($i);
            if ($actualArgument != $expectedArgument) {
                throw new VerificationException(
                    sprintf('Argument %s should be %s, is %s', $i, $expectedArgument->getValue(), $actualArgument->getValue())
                );
            }
            $i++;
        }
        return NULL;
    }

    /**
     *
     */
    public function __destruct()
    {
        if (!$this->_invokationRule->isValidInvokationCount($this->_invokationCounter)) {
            throw new VerificationException($this->_invokationRule->getErrorMessage($this->_invokationCounter));
        }
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return md5($this->_name . json_encode($this->_expectedArgs));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return ArgumentCollection
     */
    public function getArguments()
    {
        return $this->_expectedArgs;
    }
}
