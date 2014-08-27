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

} 