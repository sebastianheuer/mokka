<?php
namespace Mokka\Method\Invokation;

class Any implements ExpectedInvokationCount
{
    /**
     * Determines if the fiven invokation count is valid for this InvokationRule
     *
     * @param int $count
     * @return boolean
     */
    public function isValidInvokationCount($count)
    {
        return TRUE;
    }

    /**
     * Returns an error message
     *
     * @param int $actualCount
     * @return string
     */
    public function getErrorMessage($actualCount)
    {
        return ''; // no message, since isValidInvokationCount() is always true
    }


} 