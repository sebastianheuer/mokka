<?php
namespace Mokka;

class ClassTemplateLoader
{
    /**
     * @var string
     */
    private $templateDir = '';

    /**
     * @param string $templateDir
     */
    public function __construct($templateDir)
    {
        $this->templateDir = rtrim($templateDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    /**
     * @param \ReflectionClass $class
     * @return string
     * @throws IoException
     */
    public function loadTemplateForClass(\ReflectionClass $class)
    {
        if ($class->isInterface()) {
            return $this->loadFile($this->templateDir . 'Interface.php.template');
        }
        return $this->loadFile($this->templateDir . 'Class.php.template');
    }

    /**
     * @param string $filename
     * @return string
     * @throws IoException
     */
    private function loadFile($filename)
    {
        $content = file_get_contents($filename);
        if (FALSE === $content) {
            throw new IoException(sprintf('Could not load %s', $filename));
        }
        return $content;
    }
}