<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'mokka\\tests\\mockedmethodtest' => '/framework/method/MockedMethodTest.php',
                'mokka\\tests\\mockstub' => '/framework/mock/MockStub.php',
                'mokka\\tests\\mocktest' => '/framework/mock/MockTest.php',
                'mokka\\tests\\stubbedmethodtest' => '/framework/method/StubbedMethodTest.php',
                'mokka\\tests\\tokentest' => '/framework/TokenTest.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    }
);
// @codeCoverageIgnoreEnd