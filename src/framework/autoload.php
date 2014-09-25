<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'mokka\\classbuilder' => '/builder/ClassBuilder.php',
                'mokka\\functionbuilder' => '/builder/FunctionBuilder.php',
                'mokka\\method\\invokation\\any' => '/method/invokation/Any.php',
                'mokka\\method\\invokation\\atleast' => '/method/invokation/AtLeast.php',
                'mokka\\method\\invokation\\exactly' => '/method/invokation/Exactly.php',
                'mokka\\method\\invokation\\invokationrule' => '/method/invokation/InvokationRule.php',
                'mokka\\method\\invokation\\never' => '/method/invokation/Never.php',
                'mokka\\method\\invokation\\once' => '/method/invokation/Once.php',
                'mokka\\method\\method' => '/method/Method.php',
                'mokka\\method\\mockedmethod' => '/method/MockedMethod.php',
                'mokka\\method\\stubbedmethod' => '/method/StubbedMethod.php',
                'mokka\\mock\\mock' => '/mock/Mock.php',
                'mokka\\mock\\mockinterface' => '/mock/MockInterface.php',
                'mokka\\mokka' => '/Mokka.php',
                'mokka\\phpunit\\mokkatestcase' => '/phpunit/PHPUnitMokkaTestCase.php',
                'mokka\\token' => '/Token.php',
                'mokka\\verificationexception' => '/VerificationException.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    }
);
// @codeCoverageIgnoreEnd
