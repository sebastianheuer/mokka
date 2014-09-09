<?php
namespace Mokka\Tests\Integration;

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

} 