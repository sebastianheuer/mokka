Mocking
=======

Mocking a method lets you verify that a method was called with the given arguments.

.. code-block:: php

    <?php
    $mock = Mokka::mock(SampleClass::class);

    // Verify sure that the method getBar() gets called once
    Mokka::verify($mock)->getBar();

You can use optional Invokation Rules with Mokka::verify():

.. code-block:: php

    <?php
    // Verify sure that the method getBar() is never called
    Mokka::verify($mock, Mokka::never())->getBar();

    // Make sure getBar() gets called at least twice
    Mokka::verify($mock, Mokka::atLeast(2)->getBar();

    // Make sure getBar() gets called exactly three times
    Mokka::verify($mock, Mokka::exactly(3)->getBar();

You can add multiple mocks for a single method with different arguments

.. code-block:: php

    <?php
    // Make sure getBar() gets called once with the argument 'foo' and once with argument 'bar'
    Mokka::verify($mock)->getBar('foo');
    Mokka::verify($mock)->getBar('bar');

There is also a special AnythingArgument, so you don't have to verify every single argument if it is not relevant for your test.

.. code-block:: php

    <?php
    // Make sure getBar() gets called with the second argument 'foo'. The first argument can be anything.
    Mokka::verify($mock)->getBar(Mokka::anything(), 'foo');
