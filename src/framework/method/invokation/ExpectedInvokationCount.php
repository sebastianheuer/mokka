<?php
namespace Mokka\Method\Invokation;

interface ExpectedInvokationCount
{
    /**
     * Determines if the fiven invokation count is valid for this InvokationRule
     *
     * @param int $count
     * @return boolean
     */
    public function isValidInvokationCount($count);

    /**
     * Returns an error message
     *
     * @param int $actualCount
     * @return string
     */
    public function getErrorMessage($actualCount);
} 