# Laravel Menus

## Usage Example

To create menus in your Laravel application, you should create a file at `app/Support/menus.php`. This file will be automatically loaded by the package's service provider.

### Basic Menu Creation

```php
<?php

use KyleMassacre\Menus\Facades\Menu;
use KyleMassacre\Menus\MenuBuilder;

// Create a menu
Menu::create('main-menu', function (MenuBuilder $menu) {
    // Add items to the menu
    $menu->add([
        'route' => 'home',
        'title' => 'Home',
        'icon' => 'fa fa-home fa-fw me-2',
    ]);
    
    // Add a menu item with a URL instead of a route
    $menu->add([
        'url' => '/about',
        'title' => 'About',
        'icon' => 'fa fa-info fa-fw me-2',
    ]);
    
    // Add a dropdown menu
    $menu->dropdown('User', function ($sub) {
        $sub->add([
            'route' => 'profile',
            'title' => 'Profile',
            'icon' => 'fa fa-user fa-fw me-2',
        ]);
        $sub->add([
            'route' => 'logout',
            'title' => 'Logout',
            'icon' => 'fa fa-sign-out fa-fw me-2',
        ]);
    });
});
```

### Rendering Menus

To render a menu in your blade templates:

```php
{!! Menu::render('main-menu') !!}
```

Or with a specific presenter:

```php
{!! Menu::render('main-menu', 'App\\Http\\Presenters\\MainMenuPresenter') !!}
```

### Important Notes

1. Ensure your routes are defined before creating menus that reference them
2. For route-based menu items, use `'route' => 'route.name'` or `'route' => ['route.name', ['param' => 'value']]` for routes with parameters
3. For URL-based menu items, use `'url' => '/path/to/page'`

# Laravel Menus

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kylemassacre/laravel-menus.svg?style=flat-square)](https://packagist.org/packages/kylemassacre/laravel-menus)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
![GitHub Actions Workflow Status](https://img.shields.io/github/actions/workflow/status/kylemassacre/laravel-menus/laravel.yml)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/kylemassacre/laravel-menus.svg?style=flat-square)](https://scrutinizer-ci.com/g/kylemassacre/laravel-menus/?branch=master)
![Scrutinizer quality (GitHub/Bitbucket) with branch](https://img.shields.io/scrutinizer/quality/g/kylemassacre/laravel-menus/master?style=flat-square)
[![Total Downloads](https://img.shields.io/packagist/dt/kylemassacre/laravel-menus.svg?style=flat-square)](https://packagist.org/packages/kylemassacre/laravel-menus)

`kylemassacre/laravel-menus` is a laravel package which created to manage menus. It has a feature called presenters which enables easy styling and custom structure of menu rendering.

This package is a re-published, re-organised and maintained version of [nwidart/laravel-menus](https://github.com/nWidart/laravel-menus), which isn't maintained anymore. This package is used in [AsgardCMS](https://asgardcms.com/).

With one big added bonus that the original package didn't have: **tests**.

## Documentation

You'll find installation instructions and full documentation on https://nwidart.com/laravel-menus/.

## Credits
- [Kyle Ellis](https://github.com/kylemassacre)
- [Nicolas Widart](https://github.com/nwidart)
- [gravitano](https://github.com/gravitano)
- [All Contributors](https://github.com/KyleMassacre/laravel-menus/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](https://github.com/KyleMassacre/laravel-menus/blob/master/LICENSE.md) for more information.
