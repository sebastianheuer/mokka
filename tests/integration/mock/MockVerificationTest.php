<?php
namespace Mokka\Tests\Integration;

use Mokka\Method\Invokation\Exactly;
use Mokka\Method\Invokation\Never;
use Mokka\Mock\Mock;
use Mokka\Mokka;
use Mokka\Tests\Integration\Fixtures\SampleClass;

class MockVerificationTest extends MockTestCase
{
    /**
     * @expectedException \Mokka\VerificationException
     */
    public function testThrowsExceptionIfVerificationIsNotMet()
    {
        $mock = Mokka::mock(SampleClass::class);
        Mokka::verify($mock)->setBar();
    }

    public function testDoesNotThrowExeptionIfVerifiedMethodWasCalled()
    {
        $mock = Mokka::mock(SampleClass::class);
        Mokka::verify($mock)->setBar();
        $this->assertNull($mock->setBar());
    }

    public function testVerifiesIfParamIsNull()
    {
        $mock = Mokka::mock(SampleClass::class);
        Mokka::verify($mock)->setFoobar('foo', NULL);
        $this->assertNull($mock->setFoobar('foo', NULL));
    }

    /**
     * @expectedException \Mokka\VerificationException
     * @expectedExceptionMessage Method should have been called exactly 3 times, but was called 2 times
     */
    public function testThrowsExceptionIfExpectedInvokationCountIsNotMet()
    {
        $mock = Mokka::mock(SampleClass::class);
        Mokka::verify($mock, new Exactly(3))->setBar();
        $mock->setBar();
        $mock->setBar();
    }

    /**
     * @expectedException \Mokka\VerificationException
     */
    public function testVerifiesThatMethodWasNotCalled()
    {
        $mock = Mokka::mock(SampleClass::class);
        Mokka::verify($mock, new Never())->setBar();
        $mock->setBar();
    }

} 