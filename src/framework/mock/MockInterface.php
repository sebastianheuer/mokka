<?php
namespace Mokka\Mock;

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
     *
     */
    public function listenForVerification();
} 