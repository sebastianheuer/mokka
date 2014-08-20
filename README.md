#Mokka PHP Mocking Framework

The goal of Mokka is to provide a lightweight framework for creating mocks and stubs. It is heavily inspired by the Mockito Framework.

##Usage

```php
<?php 
// include autloading and create a new Mokka instance
require_once __DIR__ . '/src/framework/autoload.php';
$mokka = new Mokka();

// now you can create a mock of any class
$foo = $mokka->mock(Foo::class); // the class constant is available since PHP 5.5
$foo = $mokka->mock('Foo');      // use this in PHP 5.4

// by default, all methods of the mocked class return NULL
var_dump($foo->getBar()); // => NULL

// you can stub methods with when() and thenReturn()
$mokka->when($mock)->getBar('baz')->thenReturn('foobar');

// this will still return NULL, because the stub is set for the argument 'baz' only
var_dump($foo->getBar('foo')); // => NULL

echo $foo->getBar('baz'); // => foobar
?>
```
