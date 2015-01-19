<?php
namespace Mokka\Comparator;


class ComparatorLocator
{
    /**
     * @param mixed $valueA
     * @param mixed $valueB
     * @return ComparatorInterface
     */
    public function getComparatorFor($valueA, $valueB)
    {
        if ($valueA instanceof \DOMNode && $valueB instanceof \DOMNode) {
            return new DOMNodeComparator();
        }
        if (is_object($valueA) && is_object($valueB)) {
            return new ObjectComparator($this);
        }
        return new DefaultComparator();
    }
}