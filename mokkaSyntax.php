<?php

namespace Mokka;
use Mokka\Mock\MockInterface;
use Mokka\Tests\Integration\Fixtures\SampleClass;

/** @var MockInterface|SampleClass $mock */
$mock = Mokka::mock(SampleClass::class);

###
Mokka::when($mock)->getFoo()->thenReturn('foo');
/*
 * - no code completion after when()
 * + similar to Mockito's syntax
 */
###

###
$mock->when()->getFoo()->thenReturn('foo');
/*
 * + when() can return $this, might enable code completion
 * - not Mockito-style
 */
###

###
Mokka::when($mock->getFoo())->thenReturn('foo');
/**
 * + Mockito syntax
 * - basically not possible with PHP
 */
###


