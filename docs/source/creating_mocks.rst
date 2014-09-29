Creating Mocks
==============

Mocks are created with Mokka::mock() along with the name of the class that you want to mock.
Starting with PHP 5.5 you can use the 'class' keyword, which is highly recommended to allow
support for refactoring tools.

.. code-block:: php

    $mock = Mokka::mock(SampleClass::class);

If you are using PHP 5.4 (which is the minimum required for Mokka), you can pass the class name as a string.

.. code-block:: php

    $mock = Mokka::mock('SampleClass');

The huge drawback of this is that your IDE won't recognize this as a class name.
Your mocks will break if you rename 'SampleClass' to something else with a refactoring tool.

Using the Mock
==============

The created Mock implements all methods of the mocked class (plus a few internal methods needed for mocking and stubbing).
All methods will return NULL when you call them. See :doc:`mocking` and :doc:`stubbing` for information on how to mock and stub those methods.


