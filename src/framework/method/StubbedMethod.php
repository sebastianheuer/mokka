<?php
namespace Mokka\Method;

use Mokka\Method\Invokation\Any;

class StubbedMethod extends MockedMethod
{
    private $_returnValue;

    /**
     * @param array $expectedArgs
     * @param string $returnValue
     */
    public function __construct(array $expectedArgs, $returnValue)
    {
        parent::__construct($expectedArgs, new Any());
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

    public function __destruct()
    {

    }

} 