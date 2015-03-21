<img src="https://florian.ec/img/plum/logo.png" alt="Plum">
====

> PlumTwig is a Twig converter for Plum. Plum is a data processing pipeline for PHP.

[![Build Status](https://travis-ci.org/plumphp/plum-twig.svg)](https://travis-ci.org/plumphp/plum-twig)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/plumphp/plum-twig/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/plumphp/plum-twig/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/plumphp/plum-twig/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/plumphp/plum-twig/?branch=master)

Developed by [Florian Eckerstorfer](https://florian.ec) in Vienna, Europe.


Installation
------------

You can install PlumTwig using [Composer](http://getcomposer.org).

```shell
$ composer require plumphp/plum-twig
```


Usage
-----

### TwigConverter

In its simplest form `TwigConverter` takes an item and returns a rendered template. The given item is passed to
Twigs `render()` method as context. The following code renders the `hello.html.twig` template and passes 
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

Sometimes different items should be rendered using different templates. If you pass a `$templateProperty` to the
constructor, the template name retrieved from the given item. Because `TwigConverter` uses
[Vale](https://github.com/cocur/vale) to retrieve the value this works even if the item is a complex and nested
structure.

```php
$converter = new TwigConverter($twig, 'default', 'layout');

// The template name.html.twig is used to render the item
$converter->convert(['name' => 'Florian', 'layout' => 'name']);
```

We have seen that by default `TwigConverter` takes an arbitrary item (e.g., an array or object) and converts it into a
string. In many cases the converter will be part of a bigger Plum workflow and you would like to keep the data in the
item. You can pass a `$targetProperty` to the constructor and the rendered template will be stored in the item using
Vale.

```php
$converter = new TwigConverter($twig, 'layout', null, 'content');

// The rendered template is added to the item with the key "content"
$converter->convert(['name' => 'Florian'); // -> ['name' => 'Florian', 'content' => '...']
```


Change Log
----------

*No version released yet.*


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
