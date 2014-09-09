<?php
namespace Mokka\Method\Invokation;

class Never implements ExpectedInvokationCount
{
    /**
     * Determines if the fiven invokation count is valid for this InvokationRule
     *
     * @param int $count
     * @return boolean
     */
    public function isValidInvokationCount($count)
    {
        return $count === 0;
    }

    /**
     * Returns an error message
     *
     * @param int $actualCount
     * @return string
     */
    public function getErrorMessage($actualCount)
    {
        return sprintf('Method should NOT have been called, but was called %d times', $actualCount);
    }


} 