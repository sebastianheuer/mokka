<?php
namespace Mokka\Method;

class MockedMethod implements Method
{
    /**
     * @var array
     */
    private $_expectedArgs = array();

    /**
     * @param array $expectedArgs
     */
    public function __construct(array $expectedArgs)
    {
        $this->_expectedArgs = $expectedArgs;
    }

    /**
     * @param array $actualArgs
     * @return null
     * @throws VerificationException
     */
    public function call(array $actualArgs)
    {
        foreach ($this->_expectedArgs as $index => $arg) {
            if (!isset($actualArgs[$index])) {
                throw new VerificationException(
                    sprintf('Argument %s should be %s, is missing', $index, $arg)
                );
            }
            if ($actualArgs[$index] != $arg) {
                throw new VerificationException(
                    sprintf('Argument %s should be %s, is %s', $index, $arg, $actualArgs[$index])
                );
            }
        }
        return NULL;
    }
} 