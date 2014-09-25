<?php
namespace Mokka;

class FunctionBuilder 
{
    public function build(\ReflectionMethod $method)
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

                $arguments .= sprintf('%s $%s %s ,', $type, $parameter->getName(), $default);
            }
            $arguments = rtrim($arguments, ',');
        }
        $functionDefinition = str_replace('%arguments%', $arguments, $functionDefinition);
        return $functionDefinition;
    }
} 
