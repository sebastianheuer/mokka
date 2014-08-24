<?php
namespace Mokka\Mock;

use Mokka\Method\Method;
use Mokka\Method\MockedMethod;
use Mokka\Method\StubbedMethod;
use Mokka\Mokka;

trait Mock
{
    /**
     * @var Method[]
     */
    private $_methods = array();

    /**
     * @var bool
     */
    private $_listening = FALSE;

    /**
     * @var bool
     */
    private $_listeningForStub = FALSE;

    /**
     * @var string
     */
    private $_lastMethod = '';

    /**
     * @var array
     */
    private $_lastArgs = array();

    /**
     * @var Mokka
     */
    private $_owner;

    /**
     * @param Mokka $owner
     */
    public function setOwner(Mokka $owner)
    {
        $this->_owner = $owner;
    }

    /**
     * @param string $identifier
     * @param string $name
     * @param \Mokka\Method\Method $method
     */
    private function _addMethod($identifier, $name, Method $method)
    {
        $this->_methods[$identifier] = $method;
        $this->_listening = FALSE;
        $this->_lastMethod = $name;
    }

    /**
     * @param string $methodName
     * @param array $args
     * @return string
     */
    private function _getIdentifier($methodName, array $args)
    {
        return md5($methodName . implode('.', $args));
    }

    /**
     * @param mixed $returnValue
     */
    public function addStub($returnValue)
    {
        $identifier = $this->_getIdentifier($this->_lastMethod, $this->_lastArgs);
        $this->_addMethod($identifier, $this->_lastMethod, new StubbedMethod($this->_lastArgs, $returnValue));
        $this->_listeningForStub = FALSE;
    }

    /**
     * @param bool $forStub
     */
    public function listen($forStub = FALSE)
    {
        $this->_listening = TRUE;
        $this->_listeningForStub = $forStub;
    }

    /**
     * @param string $originalMethod
     * @param array $args
     * @return NULL
     */
    private function _call($originalMethod, array $args)
    {
        $this->_lastMethod = $originalMethod;
        $identifier = $this->_getIdentifier($originalMethod, $args);

        if ($this->_listening) {
            $this->_lastArgs = $args;
            $this->_addMethod($identifier, $originalMethod, new MockedMethod($args));
            if ($this->_listeningForStub) {
                return $this->_owner;
            }
            return $this;
        }

        if (isset($this->_methods[$identifier])) {
            return $this->_methods[$identifier]->call($args);
        }

        return NULL;
    }

} 