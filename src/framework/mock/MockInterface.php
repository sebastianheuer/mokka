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
     * @return mixed
     */
    public function listenForVerification();
} 