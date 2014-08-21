<?php
namespace Mokka;

interface MockInterface
{
    public function listen();

    public function setOwner(Mokka $owner);
} 