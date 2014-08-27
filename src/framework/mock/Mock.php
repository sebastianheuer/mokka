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
    private $_listeningForVerification = FALSE;

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
     * @param string $identifier
     * @param string $name
     * @param \Mokka\Method\Method $method
     */
    private function _addMethod($identifier, $name, Method $method)
    {
        $this->_methods[$identifier] = $method;
        $this->_listeningForVerification = FALSE;
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
     * @throws \BadMethodCallException
     */
    public function thenReturn($returnValue)
    {
        if (!$this->_listeningForStub) {
            throw new \BadMethodCallException('Mock is not listening for a stubbed return value.');
        }
        $identifier = $this->_getIdentifier($this->_lastMethod, $this->_lastArgs);
        $this->_addMethod($identifier, $this->_lastMethod, new StubbedMethod($this->_lastArgs, $returnValue));
        $this->_listeningForStub = FALSE;
    }

    /**
     *
     */
    public function listenForStub()
    {
        $this->_listeningForStub = TRUE;
    }

    /**
     *
     */
    public function listenForVerification()
    {
        $this->_listeningForVerification = TRUE;
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

        if ($this->_listeningForVerification || $this->_listeningForStub) {
            $this->_lastArgs = $args;

            // TODO there should be a separate class for this kind of method
            $methodMustBeCalled = FALSE;
            if ($this->_listeningForVerification) {
                $methodMustBeCalled = TRUE;
            }
            $method = new MockedMethod($args, $methodMustBeCalled);
            $this->_addMethod($identifier, $originalMethod, $method);
            return $this;
        }

        if (isset($this->_methods[$identifier])) {
            return $this->_methods[$identifier]->call($args);
        }

        return NULL;
    }

} 