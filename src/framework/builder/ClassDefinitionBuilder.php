<?php
namespace Mokka;

class ClassDefinitionBuilder
{
    /**
     * @var FunctionDefinitionBuilder
     */
    private $functionBuilder;

    /**
     * @var ClassTemplateLoader
     */
    private $classTemplateLoader;

    /**
     * @param FunctionDefinitionBuilder $functionBuilder
     * @param ClassTemplateLoader $templateLoader
     */
    public function __construct(FunctionDefinitionBuilder $functionBuilder, ClassTemplateLoader $templateLoader)
    {
        $this->functionBuilder = $functionBuilder;
        $this->classTemplateLoader = $templateLoader;
    }

    /**
     * @param string $mockClassname
     * @param string $classname
     * @return string
     */
    public function build($mockClassname, $classname)
    {
        $reflection = new \ReflectionClass($classname);
        $classDefinition = $this->classTemplateLoader->loadTemplateForClass($reflection);
        $classDefinition = str_replace('%className%', $mockClassname, $classDefinition);
        $classDefinition = str_replace('%mockedClass%', $classname, $classDefinition);

        $functions = array();
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->isFinal() || $method->isStatic()) {
                continue;
            }
            $functions[] = $this->functionBuilder->build($method);
        }
        $classDefinition = str_replace('%functions%', implode("\n", $functions), $classDefinition);

        return $classDefinition;
    }


} 
