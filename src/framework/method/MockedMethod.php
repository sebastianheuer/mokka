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
    private $_hasBeenCalled = FALSE;

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
        $this->_hasBeenCalled = TRUE;
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
        if (!$this->_hasBeenCalled) {
            throw new VerificationException(sprintf('Method should have been called, but wasn\'t'));
        }
    }
}
