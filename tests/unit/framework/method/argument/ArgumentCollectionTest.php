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
namespace Mokka\Tests;
use Mokka\Method\Argument;
use Mokka\Method\ArgumentCollection;

/**
 * @author     Sebastian Heuer <sebastian@phpeople.de>
 * @copyright  Sebastian Heuer <sebastian@phpeople.de>, All rights reserved.
 * @license    BSD License
 * @link       https://github.com/belanur/mokka
 */
class ArgumentCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ArgumentCollection
     */
    private $_collection;

    public function setUp()
    {
        $this->_collection = new ArgumentCollection();
    }

    public function testAddArgument()
    {
        $this->assertAttributeEmpty('_arguments', $this->_collection);
        $argument = new Argument('foo');
        $this->_collection->addArgument($argument);
        $this->assertAttributeEquals(array($argument), '_arguments', $this->_collection);
    }

    public function testAddsArgumentsPassedToConstructor()
    {
        $expectedArguments = array(
            new Argument('foo'),
            new Argument('bar')
        );
        $collection = new ArgumentCollection(array('foo', 'bar'));
        $this->assertAttributeEquals($expectedArguments, '_arguments', $collection);
    }

    public function testHasArgumentAtPosition()
    {
        $this->assertFalse($this->_collection->hasArgumentAtPosition(0));
        $this->_collection->addArgument(new Argument('foo'));
        $this->assertTrue($this->_collection->hasArgumentAtPosition(0));
    }

    /**
     * @expectedException \Mokka\NotFoundException
     */
    public function testGetArgumentAtPositionThrowsNotFoundException()
    {
        $this->_collection->getArgumentAtPosition(0);
    }

    public function testGetArgumentAtPosition()
    {
        $collection = new ArgumentCollection(array('foo', 'bar'));
        $expectedArgument = new Argument('bar');
        $this->assertEquals($expectedArgument, $collection->getArgumentAtPosition(1));
    }

    public function testGetArguments()
    {
        $expectedArguments = array(
            new Argument('foo'),
            new Argument('bar')
        );
        $collection = new ArgumentCollection(array('foo', 'bar'));
        $this->assertEquals($expectedArguments, $collection->getArguments());
    }
}
