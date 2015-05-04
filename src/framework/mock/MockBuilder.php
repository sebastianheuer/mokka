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
namespace Mokka\Mock;

use Mokka\ClassDefinitionBuilder;
use Mokka\ClassTemplateLoader;
use Mokka\FunctionDefinitionBuilder;
use Mokka\Token;

/**
 * @author     Sebastian Heuer <belanur@gmail.com>
 * @copyright  Sebastian Heuer <belanur@gmail.com>, All rights reserved.
 * @license    BSD License
 * @link       https://github.com/belanur/mokka
 */
class MockBuilder
{
    /**
     * Create a mock object for the given class
     *
     * @param string $classname
     * @return \Mokka\Mock\MockInterface
     */
    public function getMock($classname)
    {
        $mockClassname = $this->getMockClassname($classname);
        $classDefinition = $this->getClassDefinition($mockClassname, $classname);
        /* This is probably the most evil line of code I have ever written.
           TODO Maybe there is a nicer way to dynamically create a class */
        eval($classDefinition);

        return new $mockClassname();
    }

    /**
     * @param string $originalClassname
     * @return string
     */
    private function getMockClassname($originalClassname)
    {
        $originalClassname = str_replace('\\', '_', $originalClassname);

        return sprintf('Mokka_Mocked_%s_%s', $originalClassname, (string)new Token());
    }

    /**
     * @param string $mockClassname
     * @param string $classname
     * @return string
     */
    private static function getClassDefinition($mockClassname, $classname)
    {
        $builder = new ClassDefinitionBuilder(
            new FunctionDefinitionBuilder(), new ClassTemplateLoader(__DIR__ . '/../builder/template')
        );

        return $builder->build($mockClassname, $classname);
    }

} 
