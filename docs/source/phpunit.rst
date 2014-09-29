Mokka with PHPUnit
==================

Mokka comes with the MokkaTestCase class, which provides easy access to mocking functions
and adds support for PHPUnit

.. code-block:: php

    <?php
    class FooTest extends MokkaTestCase
    {
        public function testFoo()
        {
            $mock = $this->mock(SampleClass::class);
            $foo = new Foo($mock);
        }
    }

