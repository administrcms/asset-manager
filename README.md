# Assets manager

[![Build Status](https://travis-ci.org/administrcms/asset-manager.svg?branch=master)](https://travis-ci.org/administrcms/asset-manager)
[![Code Climate](https://codeclimate.com/github/administrcms/asset-manager/badges/gpa.svg)](https://codeclimate.com/github/administrcms/asset-manager)
[![Test Coverage](https://codeclimate.com/github/administrcms/asset-manager/badges/coverage.svg)](https://codeclimate.com/github/administrcms/asset-manager/coverage)

# Installation

Using [Composer](https://getcomposer.org/):

```
composer require administrcms/asset-manager
```

Add the service provider:

```php
\Administr\Assets\AssetsServiceProvider::class,
```

The Facade:

```php
'Asset'    => \Administr\Assets\AssetsFacade::class,
```

# Usage

## Base usage

The asset manager works with the Laravel framework. It provides a Facade for easier usage.

You can specify your asset groups by either the `add` method or using the magical method.

```php
Asset::add('test.css', 'css');
// is the same as
Asset::addCss('test.css');
```

You can retrieve a group either by the `get` method or the magical equivelent.

```php
Asset::get('css');
// is the same as
Asset::getCss();
```

You can also specify a priority for your asset. For example when using the jQuery library, you need to include it before any other library that depends on it.

```php
// The sort is from highest to lowest priority. The default priority is 0.
Asset::addJs('jquery.js', 100);
Asset::add('jquery.js', 'js', 100);
```

## Shortcuts

You can define a shortcut, which is a class that defines multiple assets at once. If you are using a js library that needs to include js and css code, you can make it easier.

```php
// Create a class that implements the Shortcut contract
class WysiwygShortcut implements Administr\Assets\Contracts\Shortcut {
    public function execute()
    {
        Asset::addJs('tinymce.js');
        Asset::addCss('tinymce.css');
        Asset::addCss('tinymce.theme.css');
    }
}

// Register it with the Asset Manager
Asset::shortcut('wysiwyg', WysiwygShortcut::class);

// And then call it like a method of the Manager
Asset::wysiwyg();
```

It is up to you to decide where to register the shortcuts. A good place would be in a ServiceProvider in you Laravel app.

