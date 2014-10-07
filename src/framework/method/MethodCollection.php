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
namespace Mokka\Method;
use Mokka\NotFoundException;

/**
 * @author     Sebastian Heuer <belanur@gmail.com>
 * @copyright  Sebastian Heuer <belanur@gmail.com>, All rights reserved.
 * @license    BSD License
 * @link       https://github.com/belanur/mokka
 */
class MethodCollection 
{
    /**
     * @var Method[]
     */
    private $_methods = array();

    /**
     * @param Method $method
     */
    public function addMethod(Method $method)
    {
        $this->_methods[] = $method;
    }

    /**
     * @param string $methodName
     * @param ArgumentCollection $arguments
     * @return bool
     */
    public function hasMethod($methodName, ArgumentCollection $arguments)
    {
        foreach ($this->_methods as $key => $method)
        {
            if ($method->getName() !== $methodName) {
                continue;
            }
            foreach ($method->getArguments()->getArguments() as $index => $expectedArgument)
            {
                if (!$expectedArgument->matches($arguments->getArgumentAtPosition($index))) {
                    return FALSE;
                }
            }
            return TRUE;
        }
        return FALSE;
    }

    /**
     * @param string $methodName
     * @param ArgumentCollection $arguments
     * @return Method
     * @throws NotFoundException
     */
    public function getMethod($methodName, ArgumentCollection $arguments)
    {
        foreach ($this->_methods as $key => $method)
        {
            if ($method->getName() !== $methodName) {
                continue;
            }
            foreach ($method->getArguments()->getArguments() as $index => $expectedArgument)
            {
                if (!$expectedArgument->matches($arguments->getArgumentAtPosition($index))) {
                    continue 2;
                }
            }
            return $method;
        }
        throw new NotFoundException('No matching Method found');
    }
} 
