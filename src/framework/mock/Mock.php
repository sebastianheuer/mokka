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
namespace Mokka\Mock;

use Mokka\Comparator\ArgumentComparator;
use Mokka\Comparator\ComparatorLocator;
use Mokka\Method\AnythingArgument;
use Mokka\Method\Argument;
use Mokka\Method\ArgumentCollection;
use Mokka\Method\Invokation\Exactly;
use Mokka\Method\Invokation\InvokationRule;
use Mokka\Method\Invokation\Once;
use Mokka\Method\MethodCollection;
use Mokka\Method\MockedMethod;
use Mokka\Method\StubbedExceptionMethod;
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
     * @var MethodCollection
     */
    private $_methods;

    /**
     * @var MethodCollection
     */
    private $_stubs;

    /**
     * @var bool
     */
    private $_listeningForVerification = FALSE;

    /**
     * @var int|InvokationRule
     */
    private $_invokationRule = 1;

    /**
     * @var bool
     */
    private $_listeningForStub = FALSE;

    /**
     * @var string
     */
    private $_lastMethod = '';

    /**
     * @var ArgumentCollection
     */
    private $_lastArgs;

    /**
     * @param MockedMethod $method
     */
    private function __mokka_addMockedMethod(MockedMethod $method)
    {
        $this->__mokka_getMethods()->addMethod($method);
        $this->_listeningForVerification = FALSE;
    }

    /**
     * @param StubbedMethod $method
     */
    private function __mokka_addStubbedMethod(StubbedMethod $method)
    {
        $this->__mokka_getStubs()->addMethod($method);
        $this->_lastMethod = NULL;
        $this->_listeningForStub = FALSE;
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
        $this->__mokka_addStubbedMethod(new StubbedMethod($this->_lastMethod, $this->_lastArgs, $returnValue));
    }

    /**
     * @param \Exception $exception
     */
    public function thenThrow(\Exception $exception)
    {
        if (!$this->_listeningForStub) {
            throw new \BadMethodCallException('Mock is not listening for a stubbed exception.');
        }
        $this->__mokka_addStubbedMethod(new StubbedExceptionMethod($this->_lastMethod, $this->_lastArgs, $exception));
    }

    /**
     *
     */
    public function listenForStub()
    {
        $this->_listeningForStub = TRUE;
    }

    /**
     * @param int|NULL|InvokationRule $invokationRule
     * @throws \InvalidArgumentException
     */
    public function listenForVerification($invokationRule = NULL)
    {
        if (NULL === $invokationRule) {
            $invokationRule = new Once();
        } elseif (is_int($invokationRule)) {
            $invokationRule = new Exactly($invokationRule);
        } elseif (!$invokationRule instanceof InvokationRule) {
            throw new \InvalidArgumentException(
                'Invokation Rule must be either NULL, an integer or implement InvokationRule interface'
            );
        }
        $this->_listeningForVerification = TRUE;
        $this->_invokationRule = $invokationRule;
    }

    /**
     * @param string $methodName
     * @param array $args
     * @return NULL
     */
    private function _call($methodName, array $args)
    {
        $arguments = new ArgumentCollection();
        foreach ($args as $arg) {
            if ($arg instanceof AnythingArgument) {
                $arguments->addArgument($arg);
                continue;
            }
            $arguments->addArgument(new Argument($arg));
        }
        if ($this->_listeningForVerification || $this->_listeningForStub) {
            $this->_lastMethod = $methodName;
            $this->_lastArgs = $arguments;
            if ($this->_listeningForVerification) {
                $this->__mokka_addMockedMethod(new MockedMethod($methodName, $arguments, $this->_invokationRule));
            }
            return $this;
        }

        if ($this->__mokka_getMethods()->hasMethod($methodName, $arguments)) {
            $this->__mokka_getMethods()->getMethod($methodName, $arguments)->call($arguments);
        }
        
        if ($this->__mokka_getStubs()->hasMethod($methodName, $arguments)) {
            return $this->__mokka_getStubs()->getMethod($methodName, $arguments)->call($arguments);
        }

        return NULL;
    }

    /**
     * @return MethodCollection
     */
    private function __mokka_getMethods()
    {
        if (NULL === $this->_methods) {
            $this->_methods = new MethodCollection(new ArgumentComparator(new ComparatorLocator()));
        }
        return $this->_methods;
    }

    /**
     * @return MethodCollection
     */
    private function __mokka_getStubs()
    {
        if (NULL === $this->_stubs) {
            $this->_stubs = new MethodCollection(new ArgumentComparator(new ComparatorLocator()));
        }
        return $this->_stubs;
    }

    /**
     *
     */
    public function verifyMockedMethods()
    {
        $this->__mokka_getMethods()->verify();
    }

    /**
     * @return int
     */
    public function getVerificationCount()
    {
        return count($this->_methods);
    }
}
