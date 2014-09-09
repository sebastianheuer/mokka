<?php
namespace Mokka;

use Mokka\Mock\Mock;
use Mokka\Mock\MockInterface;

class Mokka
{
    /**
     *
     * Mock an object
     * @param string $classname
     * @return \Mokka\Mock\MockInterface
     */
    public static function mock($classname)
    {
        $mockClassname = self::_getMockClassname($classname);
        $classDefinition = self::_getClass($mockClassname, $classname);
        /* TODO this is probably the most evil line of code I have ever written.
           Maybe there is a nicer way to dynamically create a class */
        eval($classDefinition);
        /** @var MockInterface $mock */
        $mock = new $mockClassname();
        return $mock;
    }

    /**
     * @param string $originalClassname
     * @return string
     */
    private static function _getMockClassname($originalClassname)
    {
        $originalClassname = str_replace('\\', '_', $originalClassname);
        return sprintf('Mokka_Mocked_%s_%s', $originalClassname, (string)new Token());
    }

    /**
     * @param MockInterface $mock
     * @return MockInterface
     */
    public static function when(MockInterface $mock)
    {
        $mock->listenForStub();
        return $mock;
    }

    /**
     * @param string $mockClassname
     * @param string $classname
     * @return string
     */
    private static function _getClass($mockClassname, $classname)
    {
        $reflection = new \ReflectionClass($classname);
        if ($reflection->isInterface()) {
            $classDefinition = file_get_contents(__DIR__ . '/template/Interface.php.template');
        } else {
            $classDefinition = file_get_contents(__DIR__ . '/template/Class.php.template');
        }
        $classDefinition = str_replace('%className%', $mockClassname, $classDefinition);
        $classDefinition = str_replace('%mockedClass%', $classname, $classDefinition);

        $functions = array();
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            // TODO eval can't handle methods with the names echo and eval
            if ($method->getName() == 'echo' || $method->getName() == 'eval') {
                continue;
            }
            $functions[] = self::_getFunction($method);
        }
        $classDefinition = str_replace('%functions%', implode("\n", $functions), $classDefinition);
        return $classDefinition;
    }

    /**
     * @param \ReflectionMethod $method
     * @return mixed|string
     */
    private static function _getFunction(\ReflectionMethod $method)
    {
        $functionDefinition = file_get_contents(__DIR__ . '/template/Function.php.template');
        $functionDefinition = str_replace('%name%', $method->getName(), $functionDefinition);
        $arguments = '';
        // TODO I guess this won't cut it
        if (substr($method->getName(), 0, 2) !== '__') {
            foreach ($method->getParameters() as $parameter) {

                $type = '';
                if ($parameter->getClass() !== NULL) {
                    $type = $parameter->getClass()->getName();
                } elseif ($parameter->isArray()) {
                    $type = 'array';
                }

                $default = '';
                if ($parameter->isDefaultValueAvailable()) {
                    if (NULL === $parameter->getDefaultValue()) {
                        $default = '= NULL';
                    } else {
                        $default = sprintf("='%s'", $parameter->getDefaultValue());
                    }
                }

                $arguments .= sprintf('%s %s %s ,', $type, '$' . $parameter->getName(), $default);
            }
            $arguments = rtrim($arguments, ',');
        }
        $functionDefinition = str_replace('%arguments%', $arguments, $functionDefinition);
        return $functionDefinition;
    }

    /**
     * @param MockInterface $mock
     * @param int $expectedInvokationCount
     * @return MockInterface
     */
    public static function verify(MockInterface $mock, $expectedInvokationCount = 1)
    {
        $mock->listenForVerification($expectedInvokationCount);
        return $mock;
    }

    /**
     *
     */
    public static function never()
    {
        return 0;
    }

} 