Stubbing
========

Stubbing a method lets you define a return value.
A stubbed method does not have an Invokation Rule (like mocked methods), so if a stubbed method is not called,
no exception is thrown.

.. code-block:: php

    <?php
    $mock = Mokka::mock(SampleClass::class);

    // getFoo() should return 'baz' when called with the argument 'bar'
    Mokka::when($mock)->getFoo('bar')->thenReturn('baz');

    echo $mock->getFoo(): // => NULL
    echo $mock->getFoo('bar'); // => 'baz'

You can also use the special AnythingArgument here:

.. code-block:: php

    <?php
    // getFoo() should always return 'baz'
    Mokka::when($mock)->getFoo(Mokka::anything())->thenReturn('baz');

    echo $mock->getFoo('foo'): // => 'baz'
    echo $mock->getFoo('bar'); // => 'baz'

If you want to verify that a method gets called and also want to set a return value,
you must add a mock and a stub:

.. code-block:: php

    <?php
    $mock = Mokka::mock(SampleClass::class);

    // getFoo() should return 'baz' when called with the argument 'bar'
    Mokka::when($mock)->getFoo('bar')->thenReturn('baz');
    // also make sure that getFoo() gets called once
    Mokka::verify($mock)->getFoo('bar');

    echo $mock->getFoo('bar'); // => 'baz'

