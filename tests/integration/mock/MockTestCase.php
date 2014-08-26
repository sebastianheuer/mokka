<?php
namespace Mokka\Tests\Integration;

class MockTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @param \ReflectionMethod $method
     * @param string $parameterName
     */
    public function assertParameterIsArray(\ReflectionMethod $method, $parameterName)
    {
        $this->assertTrue($this->_getParameter($method, $parameterName)->isArray());
    }

    /**
     * @param \ReflectionMethod $method
     * @param string $parameterName
     * @param string $type
     */
    public function assertParameterHasType(\ReflectionMethod $method, $parameterName, $type)
    {
        $this->assertEquals($type, $this->_getParameter($method, $parameterName)->getClass()->getName());
    }

    /**
     * @param \ReflectionMethod $method
     * @param string $parameterName
     * @return \ReflectionParameter
     */
    private function _getParameter(\ReflectionMethod $method, $parameterName)
    {
        foreach ($method->getParameters() as $parameter) {
            if ($parameter->getName() == $parameterName) {
                return $parameter;
            }
        }
        $this->fail(sprintf('Parameter %s in Method %s not found', $parameterName, $method->getName()));
    }
} 