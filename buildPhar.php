<?php
$srcDir = __DIR__ . '/src';
$buildDir = __DIR__ . '/build';

$phar = new Phar($buildDir . '/mokka.phar', NULL, 'mokka.phar');
$phar->buildFromDirectory($srcDir);
$phar->setStub($phar->createDefaultStub('/framework/autoload.php'));