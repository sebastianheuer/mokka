<?php
namespace Mokka\Method;

use Mokka\NotFoundException;

class ArgumentCollection
{
    /**
     * @var Argument[]
     */
    private $_arguments = array();

    /**
     * @param array $arguments
     */
    public function __construct(array $arguments = array())
    {
        foreach ($arguments as $argument) {
            $this->addArgument(new Argument($argument));
        }
    }

    /**
     * @param Argument $argument
     */
    public function addArgument(Argument $argument)
    {
        $this->_arguments[] = $argument;
    }

    /**
     * @param int $position
     * @return bool
     */
    public function hasArgumentAtPosition($position)
    {
        return isset($this->_arguments[$position]);
    }

    /**
     * @param int $position
     * @return Argument
     * @throws NotFoundException
     */
    public function getArgumentAtPosition($position)
    {
        if (!$this->hasArgumentAtPosition($position)) {
            throw new NotFoundException(sprintf('No Argument at position %s', $position));
        }
        return $this->_arguments[$position];
    }

    /**
     * @return Argument[]
     * @TODO implement Iterator
     */
    public function getArguments()
    {
        return $this->_arguments;
    }

} 
