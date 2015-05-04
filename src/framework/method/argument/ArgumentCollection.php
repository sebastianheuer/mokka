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
namespace Mokka\Method;

use Mokka\NotFoundException;

/**
 * @author     Sebastian Heuer <belanur@gmail.com>
 * @copyright  Sebastian Heuer <belanur@gmail.com>, All rights reserved.
 * @license    BSD License
 * @link       https://github.com/belanur/mokka
 */
class ArgumentCollection
{
    /**
     * @var ArgumentInterface[]
     */
    private $_arguments = array();

    /**
     * @param array $arguments
     */
    public function __construct(array $arguments = array())
    {
        foreach ($arguments as $argument) {
            $this->addArgument(new Argument($argument));
        }
    }

    /**
     * @param ArgumentInterface $argument
     */
    public function addArgument(ArgumentInterface $argument)
    {
        $this->_arguments[] = $argument;
    }

    /**
     * @param int $position
     * @return bool
     */
    public function hasArgumentAtPosition($position)
    {
        return isset($this->_arguments[$position]);
    }

    /**
     * @param int $position
     * @return ArgumentInterface
     * @throws NotFoundException
     */
    public function getArgumentAtPosition($position)
    {
        if (!$this->hasArgumentAtPosition($position)) {
            throw new NotFoundException(sprintf('No Argument at position %s', $position));
        }

        return $this->_arguments[$position];
    }

    /**
     * @return ArgumentInterface[]
     * @TODO implement Iterator
     */
    public function getArguments()
    {
        return $this->_arguments;
    }

} 
