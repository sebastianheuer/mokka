<?php
namespace Mokka\Method\Invokation;

class Exactly implements ExpectedInvokationCount
{
    /**
     * @var int
     */
    private $_times = 0;

    /**
     * @param int $times
     */
    public function __construct($times)
    {
        $this->_times = $times;
    }

    /**
     * Determines if the fiven invokation count is valid for this InvokationRule
     *
     * @param int $count
     * @return boolean
     */
    public function isValidInvokationCount($count)
    {
        return $this->_times === $count;
    }

    /**
     * Returns an error message
     *
     * @param int $actualCount
     * @return string
     */
    public function getErrorMessage($actualCount)
    {
        return sprintf(
            'Method should have been called exactly %d times, but was called %d times',
            $this->_times,
            $actualCount
        );
    }


} 