<?php
namespace Mokka\Mock;

use Mokka\Mokka;

interface MockInterface
{
    /**
     * @param mixed $returnValue
     */
    public function addStub($returnValue);

    /**
     *
     */
    public function listen();

    /**
     * @param Mokka $owner
     */
    public function setOwner(Mokka $owner);
} 