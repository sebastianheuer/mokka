<?php
namespace Mokka\Mock;

use Mokka\Method\Invokation\ExpectedInvokationCount;

interface MockInterface
{
    /**
     * @param mixed $returnValue
     */
    public function thenReturn($returnValue);

    /**
     *
     */
    public function listenForStub();

    /**
     * @param int|NULL|ExpectedInvokationCount $expectedInvokationCount
     */
    public function listenForVerification($expectedInvokationCount);
} 