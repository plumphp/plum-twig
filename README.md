<h1 align="center">
    <img src="http://cdn.florian.ec/plum-logo.svg" alt="Plum" width="300">
</h1>

> PlumTwig is a [Twig](http://twig.sensiolabs.org) converter for Plum. Plum is a data processing pipeline for PHP.

[![Latest Version](https://img.shields.io/packagist/v/plumphp/plum-twig.svg)](https://packagist.org/packages/plumphp/plum-twig)
[![Build Status](https://travis-ci.org/plumphp/plum-twig.svg)](https://travis-ci.org/plumphp/plum-twig)
[![Windows Build status](https://ci.appveyor.com/api/projects/status/7d6vkj6qdcnoyprj?svg=true)](https://ci.appveyor.com/project/florianeckerstorfer/plum-twig)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/plumphp/plum-twig/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/plumphp/plum-twig/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/plumphp/plum-twig/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/plumphp/plum-twig/?branch=master)
[![StyleCI](https://styleci.io/repos/32628269/shield)](https://styleci.io/repos/32628269)

Developed by [Florian Eckerstorfer](https://florian.ec) in Vienna, Europe.


Installation
------------

You can install PlumTwig using [Composer](http://getcomposer.org).

```shell
$ composer require plumphp/plum-twig
```


Usage
-----

Please refer to the [Plum documentation](https://github.com/plumphp/plum/blob/master/docs/index.md) for more
information about Plum in general.

### `TwigConverter`

In its simplest form `Plum\PlumTwig\TwigConverter` takes an item and returns a rendered template. The given item is
passed to Twigs `render()` method as context. The following code renders the `hello.html.twig` template and passes
`["name" => "Florian"]` as context to the template. The return value of `convert()` is the rendered template.

```php
use Plum\PlumTwig\TwigConverter;

$converter = new TwigConverter($twig, 'hello');
$converter->convert(['name' => 'Florian']);
```

By default `.html.twig` is appended on the given template name. You can change the file extension by calling
`setFileExtension()`:

```php
$converter->setFileExtension('.twig');
```

Sometimes different items should be rendered using different templates. If you pass a template property to the
constructor, the template name retrieved from the given item. Because `TwigConverter` uses
[Vale](https://github.com/cocur/vale) to retrieve the value this works even if the item is a complex and nested
structure.

```php
$converter = new TwigConverter($twig, 'default', ['template' => 'layout']);

// The template name.html.twig is used to render the item
$converter->convert(['name' => 'Florian', 'layout' => 'name']);
```

We have seen that by default `TwigConverter` takes an arbitrary item (e.g., an array or object) and converts it into a
string. In many cases the converter will be part of a bigger Plum workflow and you would like to keep the data in the
item. You can pass a target property to the constructor and the rendered template will be stored in the item using
Vale.

```php
$converter = new TwigConverter($twig, 'layout', ['target' => 'content']);

// The rendered template is added to the item with the key "content"
$converter->convert(['name' => 'Florian']); // -> ['name' => 'Florian', 'content' => '...']
```

Not every time the full item should be passed as context, but rather an element of the item. You can pass the
context property to tell `TwigConverter` which field in the item should be used as context.

```php
$converter = new TwigConverter($twig, 'layout', ['context' => 'data']);

// Only the ['name' => 'Florian'] is passed as context to Twig
$converter->convert([['data' => ['name' => 'Florian'], 'file' => 'person']);
```

Whether the whole item or just part of it is used as context, Twig only allows arrays to be passed as context. Thus,
`TwigConverter` checks if the context is an object and it will call its `toArray()` method (if it has one).


Change Log
----------

### Version 0.1 (17 May 2015)

- Initial release


Author
------

Plum and PlumTwig have been developed by [Florian Eckerstorfer](https://florian.ec)
([Twitter](https://twitter.com/Florian_)) in Vienna, Europe.

> Plum is a project of [Cocur](http://cocur.co). You can contact us on Twitter:
> [**@cocurco**](https://twitter.com/cocurco)


License
-------

The MIT license applies to plumphp/plum-twig. For the full copyright and license information,
please view the [LICENSE](https://github.com/plumphp/plum-twig/blob/master/LICENSE) file distributed with this
source code.
