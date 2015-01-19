<?php
namespace Mokka\Comparator;

class DefaultComparator implements ComparatorInterface
{
    /**
     * @param mixed $a
     * @param mixed $b
     * @return boolean
     */
    public function isEqual($a, $b)
    {
        return $a == $b;
    }

}