<?php
namespace Mokka\Comparator;

use Mokka\Method\AnythingArgument;
use Mokka\Method\ArgumentInterface;

class ArgumentComparator
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
     * @param ArgumentInterface $argumentA
     * @param ArgumentInterface $argumentB
     * @return bool
     */
    public function isEqual(ArgumentInterface $argumentA, ArgumentInterface $argumentB)
    {
        if ($argumentA instanceof AnythingArgument || $argumentB instanceof AnythingArgument) {
            return true;
        }
        return $this->_comparatorLocator->getComparatorFor(
            $argumentA->getValue(), $argumentB->getValue()
        )->isEqual($argumentA->getValue(), $argumentB->getValue());
    }
}