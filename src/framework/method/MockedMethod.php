<?php
namespace Mokka\Method;

use Mokka\VerificationException;

class MockedMethod implements Method
{
    /**
     * @var array
     */
    private $_expectedArgs = array();

    /**
     * @var bool indicates if this method has been called during execution (only relevant if $_mustBeCalled is TRUE)
     */
    private $_invokationCounter = 0;

    /**
     * @var int number of times this method should be called during execution
     */
    private $_expectedInvokationCount = 1;

    /**
     * @param array $expectedArgs
     * @param int $expectedInvokationCount
     */
    public function __construct(array $expectedArgs, $expectedInvokationCount = 1)
    {
        $this->_expectedArgs = $expectedArgs;
        $this->_expectedInvokationCount = $expectedInvokationCount;
    }

    /**
     * @param array $actualArgs
     * @return null
     * @throws VerificationException
     */
    public function call(array $actualArgs)
    {
        $this->_invokationCounter++;
        foreach ($this->_expectedArgs as $index => $arg) {
            if (!array_key_exists($index, $actualArgs)) {
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

    /**
     *
     */
    public function __destruct()
    {
        if ($this->_invokationCounter != $this->_expectedInvokationCount) {
            throw new VerificationException($this->_getInvokationErrorMessage());
        }
    }

    /**
     * @return string
     */
    private function _getInvokationErrorMessage()
    {
        switch ($this->_expectedInvokationCount) {
            case 0:
                return sprintf('Method should NOT have been called, but was called %d times', $this->_invokationCounter);
            case 1:
                return sprintf('Method was expected to be called once, but was called %d times', $this->_invokationCounter);
            default:
                return sprintf(
                    'Method was expected to be called %d times, but was called %d times',
                    $this->_expectedInvokationCount,
                    $this->_invokationCounter
                );
        }
    }
}
