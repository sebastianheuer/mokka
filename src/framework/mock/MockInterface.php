<?php
namespace Mokka\Mock;

use Mokka\Mokka;

interface MockInterface
{
    public function listen();

    public function setOwner(Mokka $owner);
} 