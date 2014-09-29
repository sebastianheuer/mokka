Stubbing
========

Stubbing a method lets you define a return value.

.. code-block:: php

    <?php
    $mock = Mokka::mock(SampleClass::class);

    // getFoo() should return 'baz' when called with the argument 'bar'
    Mokka::when($mock)->getFoo('bar')->thenReturn('baz');

    echo $mock->getFoo(): // => NULL
    echo $mock->getFoo('bar'); // => 'baz'

You can also use the special AnythingArgument here

.. code-block:: php

    <?php
    // getFoo() should always return 'baz'
    Mokka::when($mock)->getFoo(Mokka::anything())->thenReturn('baz');

    echo $mock->getFoo('foo'): // => 'baz'
    echo $mock->getFoo('bar'); // => 'baz'
