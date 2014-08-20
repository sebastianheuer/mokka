<?php
namespace Mokka;

interface Method 
{
    /**
     * @param array $actualArgs
     */
    public function call(array $actualArgs);
} 