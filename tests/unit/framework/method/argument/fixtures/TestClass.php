<?php
namespace Mokka\Tests;

class TestClass
{
    private $_someProperty;

    public function __construct($someProperty = NULL)
    {
        $this->_someProperty = $someProperty;
    }
}