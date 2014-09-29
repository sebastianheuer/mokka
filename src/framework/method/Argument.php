<?php
namespace Mokka\Method;

class Argument 
{

    /**
     * @var mixed
     */
    private $_value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->_value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
    }

} 
