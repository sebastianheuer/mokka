<?php
namespace Mokka\Method\Invokation;

class Once implements ExpectedInvokationCount
{
    /**
     * Determines if the fiven invokation count is valid for this InvokationRule
     *
     * @param int $count
     * @return boolean
     */
    public function isValidInvokationCount($count)
    {
        return $count === 1;
    }

    /**
     * Returns an error message
     *
     * @param int $actualCount
     * @return string
     */
    public function getErrorMessage($actualCount)
    {
        return sprintf('Method was expected to be called once, but was called %d times', $actualCount);
    }

} 