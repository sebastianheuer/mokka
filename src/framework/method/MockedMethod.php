<?php
namespace Mokka\Method;

use Mokka\Method\Invokation\ExpectedInvokationCount;
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
     * @var ExpectedInvokationCount number of times this method should be called during execution
     */
    private $_expectedInvokationCount;

    /**
     * @param array $expectedArgs
     * @param Invokation\ExpectedInvokationCount $expectedInvokationCount
     */
    public function __construct(array $expectedArgs, ExpectedInvokationCount $expectedInvokationCount)
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
        if (!$this->_expectedInvokationCount->isValidInvokationCount($this->_invokationCounter)) {
            throw new VerificationException($this->_expectedInvokationCount->getErrorMessage($this->_invokationCounter));
        }
    }

}
