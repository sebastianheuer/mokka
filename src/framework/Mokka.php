<?php
namespace Mokka;

class Mokka
{
    /**
     * @var Mock
     */
    private $_lastMock;

    /**
     *
     * Mock an object
     * @param string $classname
     * @return Mock
     */
    public function mock($classname)
    {
        $mockClassname = $this->_getMockClassname($classname);
        $classDefinition = $this->_getClass($mockClassname, $classname);
        /* TODO this is probably the most evil line of code I have ever written.
           Maybe there is a nicer way to dynamically create a class */
        eval($classDefinition);
        /** @var MockInterface $mock */
        $mock = new $mockClassname();
        $mock->setOwner($this);
        return $mock;
    }

    /**
     * @param $originalClassname
     * @return string
     */
    private function _getMockClassname($originalClassname)
    {
        $originalClassname = str_replace('\\', '_', $originalClassname);
        return sprintf('Mokka_Mocked_%s_%s', $originalClassname, (string)new Token());
    }

    public function when(MockInterface $mock)
    {
        $mock->listen(TRUE);
        $this->_lastMock = $mock;
        return $mock;
    }

    /*
     *
     */
    public function thenReturn($return)
    {
        $this->_lastMock->addStub($return);
    }

    /**
     * @param string $mockClassname
     * @param string $classname
     * @return string
     */
    private function _getClass($mockClassname, $classname)
    {
        $classDefinition = file_get_contents(__DIR__ . '/template/Class.php.template');
        $classDefinition = str_replace('%className%', $mockClassname, $classDefinition);
        $classDefinition = str_replace('%mockedClass%', $classname, $classDefinition);
        $reflection = new \ReflectionClass($classname);
        $functions = array();
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            // TODO eval can't handle methods with the names echo and eval
            if ($method->getName() == 'echo' || $method->getName() == 'eval') {
                continue;
            }
            $functions[] = $this->_getFunction($method);
        }
        $classDefinition = str_replace('%functions%', implode("\n", $functions), $classDefinition);
        return $classDefinition;
    }

    /**
     * @param \ReflectionMethod $method
     * @return mixed|string
     */
    private function _getFunction(\ReflectionMethod $method)
    {
        $functionDefinition = file_get_contents(__DIR__ . '/template/Function.php.template');
        $functionDefinition = str_replace('%name%', $method->getName(), $functionDefinition);
        return $functionDefinition;
    }

    /**
     * @param MockInterface $mock
     * @return MockInterface
     */
    public function verify(MockInterface $mock)
    {
        $mock->listen();
        return $mock;
    }

} 