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
namespace Mokka\Mock;

use Mokka\Method\Invokation\Exactly;
use Mokka\Method\Invokation\ExpectedInvokationCount;
use Mokka\Method\Invokation\Once;
use Mokka\Method\Method;
use Mokka\Method\MockedMethod;
use Mokka\Method\StubbedMethod;

/**
 * @author     Sebastian Heuer <belanur@gmail.com>
 * @copyright  Sebastian Heuer <belanur@gmail.com>, All rights reserved.
 * @license    BSD License
 * @link       https://github.com/belanur/mokka
 */
trait Mock
{
    /**
     * @var Method[]
     */
    private $_methods = array();

    /**
     * @var StubbedMethod[]
     */
    private $_stubs = array();

    /**
     * @var bool
     */
    private $_listeningForVerification = FALSE;

    /**
     * @var int
     */
    private $_expectedInvokationCount = 1;

    /**
     * @var bool
     */
    private $_listeningForStub = FALSE;

    /**
     * @var string|NULL
     */
    private $_lastMethod;

    /**
     * @var array
     */
    private $_lastArgs = array();

    /**
     * @param string $identifier
     * @param string $name
     * @param Method $method
     */
    private function _addMockedMethod($identifier, $name, Method $method)
    {
        $this->_methods[$identifier] = $method;
        $this->_lastMethod = $name;
        $this->_listeningForVerification = FALSE;
    }

    /**
     * @param string $identifier
     * @param Method $method
     */
    private function _addStubbedMethod($identifier, Method $method)
    {
        $this->_stubs[$identifier] = $method;
        $this->_lastMethod = NULL;
        $this->_listeningForStub = FALSE;
    }

    /**
     * @param string $methodName
     * @param array $args
     * @return string
     */
    private function _getIdentifier($methodName, array $args)
    {
        return md5($methodName . json_encode($args));
    }

    /**
     * @param mixed $returnValue
     * @throws \BadMethodCallException
     */
    public function thenReturn($returnValue)
    {
        if (!$this->_listeningForStub) {
            throw new \BadMethodCallException('Mock is not listening for a stubbed return value.');
        }
        $identifier = $this->_getIdentifier($this->_lastMethod, $this->_lastArgs);
        $this->_addStubbedMethod($identifier, new StubbedMethod($this->_lastArgs, $returnValue));
    }

    /**
     *
     */
    public function listenForStub()
    {
        $this->_listeningForStub = TRUE;
    }

    /**
     * @param int|NULL|ExpectedInvokationCount $expectedInvokationCount
     * @throws \InvalidArgumentException
     */
    public function listenForVerification($expectedInvokationCount = NULL)
    {
        if (NULL === $expectedInvokationCount) {
            $expectedInvokationCount = new Once();
        } elseif (is_int($expectedInvokationCount)) {
            $expectedInvokationCount = new Exactly($expectedInvokationCount);
        } elseif (!$expectedInvokationCount instanceof ExpectedInvokationCount) {
            throw new \InvalidArgumentException(
                'expected invokation count must be either NULL, an integer or implement ExpectedInvocationCount interface'
            );
        }
        $this->_listeningForVerification = TRUE;
        $this->_expectedInvokationCount = $expectedInvokationCount;
    }

    /**
     * @param string $originalMethod
     * @param array $args
     * @return NULL
     */
    private function _call($originalMethod, array $args)
    {
        $this->_lastMethod = $originalMethod;
        $identifier = $this->_getIdentifier($originalMethod, $args);

        if ($this->_listeningForVerification || $this->_listeningForStub) {
            $this->_lastArgs = $args;
            if ($this->_listeningForVerification) {
                $this->_addMockedMethod(
                    $identifier, $originalMethod, new MockedMethod($args, $this->_expectedInvokationCount)
                );
            }
            return $this;
        }

        if (isset($this->_methods[$identifier])) {
            $this->_methods[$identifier]->call($args);
        }
        if (isset($this->_stubs[$identifier])) {
            return $this->_stubs[$identifier]->call($args);
        }

        return NULL;
    }

} 