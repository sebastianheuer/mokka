<?php
namespace Mokka\Method;

interface Method 
{
    /**
     * @param array $actualArgs
     */
    public function call(array $actualArgs);
} 