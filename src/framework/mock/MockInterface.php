<?php
namespace Mokka\Mock;

interface MockInterface
{
    public function listen();

    public function setOwner(Mokka $owner);
} 