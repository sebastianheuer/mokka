<?php
namespace Mokka\Comparator;

interface ComparatorInterface
{
    /**
     * @param mixed $a
     * @param mixed $b
     * @return boolean
     */
    public function isEqual($a, $b);
}