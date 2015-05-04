<?php
namespace Mokka\Comparator;

class ObjectComparator implements ComparatorInterface
{
    /**
     * @var ComparatorLocator
     */
    private $_comparatorLocator;

    /**
     * @param ComparatorLocator $comparatorLocator
     */
    public function __construct(ComparatorLocator $comparatorLocator)
    {
        $this->_comparatorLocator = $comparatorLocator;
    }

    /**
     * @param mixed $a
     * @param mixed $b
     * @return boolean
     */
    public function isEqual($a, $b)
    {
        if (!$a instanceof $b) {
            return false;
        }
        $reflectedA = new \ReflectionClass($a);
        $reflectedB = new \ReflectionClass($b);
        foreach ($reflectedA->getProperties() as $propertyA) {
            $propertyA->setAccessible(true);
            if (!$reflectedB->hasProperty($propertyA->getName())) {
                return false;
            }
            $propertyB = $reflectedB->getProperty($propertyA->getName());
            $propertyB->setAccessible(true);

            $valueA = $propertyA->getValue($a);
            $valueB = $propertyB->getValue($b);
            $comparator = $this->_comparatorLocator->getComparatorFor($valueA, $valueB);
            if (!$comparator->isEqual($valueA, $valueB)) {
                return false;
            }
        }

        return true;
    }

}