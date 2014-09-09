<?php
namespace Mokka\Method\Invokation;

class AtLeast implements ExpectedInvokationCount
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
        return $count >= $this->_times;
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
            'Method should have been called at least %d times, but was called %d times',
            $this->_times,
            $actualCount
        );
    }

} 