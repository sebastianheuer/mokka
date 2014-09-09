<?php
namespace Mokka\Mock;

use Mokka\Method\Invokation\Exactly;
use Mokka\Method\Invokation\ExpectedInvokationCount;
use Mokka\Method\Invokation\Once;
use Mokka\Method\Method;
use Mokka\Method\MockedMethod;
use Mokka\Method\StubbedMethod;

trait Mock
{
    /**
     * @var Method[]
     */
    private $_methods = array();

    /**
     * @var StubbedMethod[]
     */
    private $_stubs = array();

    /**
     * @var bool
     */
    private $_listeningForVerification = FALSE;

    /**
     * @var int
     */
    private $_expectedInvokationCount = 1;

    /**
     * @var bool
     */
    private $_listeningForStub = FALSE;

    /**
     * @var string|NULL
     */
    private $_lastMethod;

    /**
     * @var array
     */
    private $_lastArgs = array();

    /**
     * @param string $identifier
     * @param string $name
     * @param Method $method
     */
    private function _addMockedMethod($identifier, $name, Method $method)
    {
        $this->_methods[$identifier] = $method;
        $this->_lastMethod = $name;
        $this->_listeningForVerification = FALSE;
    }

    /**
     * @param string $identifier
     * @param Method $method
     */
    private function _addStubbedMethod($identifier, Method $method)
    {
        $this->_stubs[$identifier] = $method;
        $this->_lastMethod = NULL;
        $this->_listeningForStub = FALSE;
    }

    /**
     * @param string $methodName
     * @param array $args
     * @return string
     */
    private function _getIdentifier($methodName, array $args)
    {
        return md5($methodName . json_encode($args));
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
        $this->_addStubbedMethod($identifier, new StubbedMethod($this->_lastArgs, $returnValue));
    }

    /**
     *
     */
    public function listenForStub()
    {
        $this->_listeningForStub = TRUE;
    }

    /**
     * @param int|NULL|ExpectedInvokationCount $expectedInvokationCount
     * @throws \InvalidArgumentException
     */
    public function listenForVerification($expectedInvokationCount = NULL)
    {
        if (NULL === $expectedInvokationCount) {
            $expectedInvokationCount = new Once();
        } elseif (is_int($expectedInvokationCount)) {
            $expectedInvokationCount = new Exactly($expectedInvokationCount);
        } elseif (!$expectedInvokationCount instanceof ExpectedInvokationCount) {
            throw new \InvalidArgumentException(
                'expected invokation count must be either NULL, an integer or implement ExpectedInvocationCount interface'
            );
        }
        $this->_listeningForVerification = TRUE;
        $this->_expectedInvokationCount = $expectedInvokationCount;
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
            if ($this->_listeningForVerification) {
                $this->_addMockedMethod(
                    $identifier, $originalMethod, new MockedMethod($args, $this->_expectedInvokationCount)
                );
            }
            return $this;
        }

        if (isset($this->_methods[$identifier])) {
            $this->_methods[$identifier]->call($args);
        }
        if (isset($this->_stubs[$identifier])) {
            return $this->_stubs[$identifier]->call($args);
        }

        return NULL;
    }

} 