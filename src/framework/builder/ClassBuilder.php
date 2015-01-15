<?php
namespace Mokka;

class ClassBuilder 
{
    /**
     * @var FunctionBuilder
     */
    private $_functionBuilder;

    /**
     * @param FunctionBuilder $functionBuilder
     */
    public function __construct(FunctionBuilder $functionBuilder)
    {
        $this->_functionBuilder = $functionBuilder;
    }

    /**
     * @param string $mockClassname
     * @param string $classname
     * @return mixed|string
     */
    public function build($mockClassname, $classname)
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
            if ($method->isFinal() || $method->isStatic()) {
                continue;
            }
            $functions[] = $this->_functionBuilder->build($method);
        }
        $classDefinition = str_replace('%functions%', implode("\n", $functions), $classDefinition);
        return $classDefinition;
    }

} 
