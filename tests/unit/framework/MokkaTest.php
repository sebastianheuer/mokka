<?php
namespace Mokka\Tests;

use Mokka\Mokka;

class MokkaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Mokka
     */
    private $_mokka;

    public function setUp()
    {
        $this->_mokka = new Mokka();
    }

    public function testWhenLetsMockListen()
    {
        $mock = $this->getMock('\Mokka\Mock\MockInterface');
        $mock->expects($this->once())
            ->method('listenForStub');
        $this->_mokka->when($mock);
    }

    public function testVerifyLetsMockListen()
    {
        $mock = $this->getMock('\Mokka\Mock\MockInterface');
        $mock->expects($this->once())
            ->method('listenForVerification');
        $this->_mokka->verify($mock);
    }

    public function testWhenReturnsMock()
    {
        $mock = new MockStub();
        $this->assertSame($mock, $this->_mokka->when($mock));
    }

}