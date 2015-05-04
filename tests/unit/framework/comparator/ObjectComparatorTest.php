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
use Mokka\Comparator\ObjectComparator;
use Mokka\Comparator\ComparatorLocator;

/**
 * @author     Sebastian Heuer <sebastian@phpeople.de>
 * @copyright  Sebastian Heuer <sebastian@phpeople.de>, All rights reserved.
 * @license    BSD License
 * @link       https://github.com/belanur/mokka
 */
class ObjectComparatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider equalObjectsProvider
     *
     * @param $object1
     * @param $object2
     */
    public function testIsEqualReturnsTrueForEqualObjects($object1, $object2)
    {
        $comparator = new ObjectComparator(new ComparatorLocator());
        $this->assertTrue($comparator->isEqual($object1, $object2));
    }

    public function equalObjectsProvider()
    {
        return array(
            array(new \StdClass(), new \StdClass()),
            array(new TestClass(), new TestClass()),
            array(new TestClass('foo'), new TestClass('foo')),
            array(new TestClass(new \StdClass()), new TestClass(new \StdClass)),
            array(new TestClass(new TestClass('foo')), new TestClass(new TestClass('foo')))
        );
    }

    /**
     * @dataProvider unequalObjectsProvider
     *
     * @param $object1
     * @param $object2
     */
    public function testIsEqualReturnsFalseForUnequalObjects($object1, $object2)
    {
        $comparator = new ObjectComparator(new ComparatorLocator());
        $this->assertFalse($comparator->isEqual($object1, $object2));
    }

    public function unequalObjectsProvider()
    {
        $dom = new \DOMDocument();
        $element1 = $dom->createElement('foo', 'bar');
        $element2 = $dom->createElement('foo', 'baz');

        return array(
            array(new \StdClass(), new TestClass()),
            array(new TestClass('foo'), new TestClass('bar')),
            array(new TestClass(new \StdClass()), new TestClass(new TestClass())),
            array(new TestClass(new TestClass('foo')), new TestClass(new TestClass('bar'))),
            array(new TestClass($element1), new TestClass($element2))
        );
    }


}
