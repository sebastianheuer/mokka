<?php
namespace Mokka\Tests;

use Mokka\Token;

class TokenTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @testdox the generated token value is 40 chars long
     */
    public function testReturnsValidString()
    {
        $token = new Token();
        $actual = (string)$token;
        $this->assertEquals(40, strlen($actual));
    }

    public function testReturnsGivenTokenValue()
    {
        $token = new Token('foo');
        $this->assertEquals('foo', (string)$token);
    }
}
 