<?php
namespace Mokka\Method;

class StubbedMethod extends MockedMethod
{
    private $_returnValue;

    /**
     * @param array $expectedArgs
     * @param $returnValue
     */
    public function __construct(array $expectedArgs, $returnValue)
    {
        parent::__construct($expectedArgs);
        $this->_returnValue = $returnValue;
    }

    /**
     * @param array $actualArgs
     * @return null
     */
    public function call(array $actualArgs)
    {
        parent::call($actualArgs);
        return $this->_returnValue;
    }
} 