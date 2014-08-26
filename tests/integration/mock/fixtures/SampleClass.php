<?php
namespace Mokka\Tests\Integration\Fixtures;

class SampleClass 
{
    public function __construct($foo, $bar)
    {
        return 'foo';
    }

    public function __destruct()
    {
        return 'bar';
    }

    public function setFoos(array $foos)
    {

    }

    public function setFoo(Foo $foo)
    {

    }

    public function setBar($bar = NULL)
    {

    }

    public function setBaz($baz = 'baz')
    {

    }
} 