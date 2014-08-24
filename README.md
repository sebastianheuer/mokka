#Mokka PHP Mocking Framework

The goal of Mokka is to provide a lightweight framework for creating mocks and stubs. It's syntax is heavily inspired by the [Mockito Framework](https://code.google.com/p/mockito/).

##Installing with composer

Simply add belanur/mokka to the ```composer.json``` of your project. Since there are no stable versions yet, you'll have to use "dev-master":

```json
{
  require-dev: {
    "belanur/mokka": "dev-master"
  }
}
```

##Prerequisites

Mokka needs PHP 5.4.0+. PHP 5.5.0+ is recommended.

##Building a Phar

Note: Make sure to have ```phar.readonly = Off``` in your php.ini. Otherwise building Phars is not possible. 

You can run ```php buildPhar.php``` to build a Phar package. It will be put in /build/mokka.phar. You can then include it in your projects:

```php
<?php
require __DIR__ . '/mokka.phar';
$mokka = new Mokka\Mokka();
```

##Usage

```php
<?php 
// include the Phar package and create a new Mokka instance
require __DIR__ . '/mokka.phar';
$mokka = new Mokka\Mokka();

// now you can create a mock of any class
$foo = $mokka->mock(\Acme\Foo::class); // the class constant is available since PHP 5.5
$foo = $mokka->mock('\Acme\Foo');      // use this in PHP 5.4

// by default, all methods of the mocked class return NULL
var_dump($foo->getBar()); // => NULL

// you can stub methods with when() and thenReturn()
$mokka->when($mock)->getBar('baz')->thenReturn('foobar');

// this will still return NULL, because the stub is set for the argument 'baz' only
var_dump($foo->getBar('foo')); // => NULL

echo $foo->getBar('baz'); // => foobar
```
