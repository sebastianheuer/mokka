<?php
namespace Mokka\Tests;

use Mokka\Mock;
use Mokka\MockInterface;

/**
 * Stub that uses the Mock trait
 * Behaves like the dynamically created mock classes
 * Used for testing Mock
 */
class MockStub implements MockInterface
{
    use Mock;

    public function doFoo()
    {
        return $this->_call('doFoo', func_get_args());
    }
} 