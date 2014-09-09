<?php
namespace Mokka\PHPUnit;

use Mokka\Mock\MockInterface;
use Mokka\Mokka;

class MokkaTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $classname
     * @return \Mokka\Mock\Mock
     */
    public function mock($classname)
    {
        return Mokka::mock($classname);
    }

    /**
     * @param MockInterface $mock
     * @return MockInterface
     */
    public function when(MockInterface $mock)
    {
        return Mokka::when($mock);
    }

    /**
     * @param MockInterface $mock
     * @return MockInterface
     */
    public function verify(MockInterface $mock)
    {
        return Mokka::verify($mock);
    }
} 