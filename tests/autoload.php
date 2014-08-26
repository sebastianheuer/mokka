<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'mokka\\tests\\classstub' => '/unit/framework/ClassStub.php',
                'mokka\\tests\\integration\\fixtures\\foo' => '/integration/mock/fixtures/Foo.php',
                'mokka\\tests\\integration\\fixtures\\sampleclass' => '/integration/mock/fixtures/SampleClass.php',
                'mokka\\tests\\integration\\mocktest' => '/integration/mock/MockTest.php',
                'mokka\\tests\\integration\\mocktestcase' => '/integration/mock/MockTestCase.php',
                'mokka\\tests\\mockedmethodtest' => '/unit/framework/method/MockedMethodTest.php',
                'mokka\\tests\\mockstub' => '/unit/framework/mock/MockStub.php',
                'mokka\\tests\\mocktest' => '/unit/framework/mock/MockTest.php',
                'mokka\\tests\\mokkatest' => '/unit/framework/MokkaTest.php',
                'mokka\\tests\\stubbedmethodtest' => '/unit/framework/method/StubbedMethodTest.php',
                'mokka\\tests\\tokentest' => '/unit/framework/TokenTest.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    }
);
// @codeCoverageIgnoreEnd
