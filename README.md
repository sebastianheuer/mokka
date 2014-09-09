#Mokka PHP Mocking Framework

The goal of Mokka is to provide a lightweight framework for creating mocks and stubs. It's syntax is heavily inspired by the [Mockito Framework](https://code.google.com/p/mockito/).

##Prerequisites

Mokka needs PHP 5.4.0+. PHP 5.5.0+ is recommended.

##Installing with composer

Simply add belanur/mokka to the ```composer.json``` of your project. Since there are no stable versions yet, you'll have to use "dev-master":

```json
{
  "require-dev": {
    "belanur/mokka": "dev-master"
  }
}
```

##Building a Phar

Note: Make sure to have ```phar.readonly = Off``` in your php.ini. Otherwise building Phars is not possible.

You can run ```php buildPhar.php``` to build a Phar package. It will be put in /build/mokka.phar. You can then include it in your projects:

```php
<?php
require __DIR__ . '/mokka.phar';
```

##Usage

After adding Mokka to your project, you can start creating Mocks right away:

```php
<?php
// Create a mock of any class or interface
$foo = Mokka::mock(\Acme\Foo::class);         // requires PHP 5.5
$bar = Mokka::mock(\Acme\BarInterface::class);

// If you are on PHP 5.4, just use the class name (and consider upgrading your PHP version)
$foo = Mokka::mock('\Acme\Foo');

// By default, all methods of the mocked class will return NULL
$foo->getBar(); // => NULL

```
You can stub methods with when() and thenReturn()
```php
<?php
Mokka::when($mock)->getBar('baz')->thenReturn('foobar');

// This will still return NULL, because the stub is set for the argument 'baz' only
$foo->getBar('foo'); // => NULL

$foo->getBar('baz'); // => 'foobar'
```

You can verify if and how often a method was called with verify().
```php
<?php
// The mock will throw a VerificationException if this method was not called once
Mokka::verify($foo)->getBar();
// The mock will throw a VerificationException if this method was not called three times
Mokka::verify($foo, 3)->getBar(); //
// The mock will throw a VerificationException if this method was called
Mokka::verify($foo, Mokka::never())->getBar();
// The mock will throw a VerificationException if this method was not called at least two times
Mokka::verify($foo, Mokka::atLeast(2))->getBar(); 
```

## Using Mokka in PHPUnit

Since Mokka's methods can be called statically (e.g. `Mokka::mock(\Acme\Foo::class)`), you can just start using Mokka in PHPUnit:

```<?php
class FooTest extends PHPUnit_Framework_TestCase
{
  public function testFoo()
  {
    $mockedBar = Mokka::mock(\Acme\Bar::class);
    $foo = new \Acme\Foo($mockedBar);
  }
}
```

However Mokka also comes with the `MokkaTestCase` class, which acts as a proxy:

```<?php
class FooTest extends MokkaTestCase
{
  public function testFoo()
  {
    $mockedBar = $this->mock(\Acme\Bar::class);
    $foo = new \Acme\Foo($mockedBar);
  }
}
```

## Code Completion in IntelliJ / PHPStorm

The [DynamicReturnTypeValue Plugin](http://plugins.jetbrains.com/plugin/7251) provides improved code completion support for methods like `Mokka::mock()` or `Mokka::verify()`. A `dynamicReturnTypeMeta.json` file is included.
