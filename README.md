# Laravel Breadcrumbs

[![Latest Version on Packagist](https://img.shields.io/packagist/v/robotsinside/laravel-breadcrumbs.svg?style=flat-square)](https://packagist.org/packages/robotsinside/laravel-breadcrumbs)
[![Quality Score](https://img.shields.io/scrutinizer/g/robotsinside/breadcrumbs.svg?style=flat-square)](https://scrutinizer-ci.com/g/robotsinside/breadcrumbs)
[![Total Downloads](https://img.shields.io/packagist/dt/robotsinside/breadcrumbs.svg?style=flat-square)](https://packagist.org/packages/robotsinside/breadcrumbs)

A simple breadcrumbs implementation for Laravel facilitated by class based segment customisation.

## Installation

1. Run `composer require robotsinside/laravel-breadcrumbs`.

2. Optionally register the service provider in `config/app.php`

```php
/*
* Package Service Providers...
*/
\RobotsInside\Breadcrumbs\BreadcrumbsServiceProvider::class,
```

Auto-discovery is enabled, so this step can be skipped.

3. Register the facade for use in your views in `config/app.php`

```php
    'aliases' => [
        ...
        'Breadcrumbs' => \RobotsInside\Breadcrumbs\Facades\Breadcrumbs::class,
    ],
```

4. Publish the config file `php artisan vendor:publish --provider="RobotsInside\Breadcrumbs\BreadcrumbsServiceProvider" --tag="config"`
5. Publish the view files `php artisan vendor:publish --provider="RobotsInside\Breadcrumbs\BreadcrumbsServiceProvider" --tag="views"`

## Usage

Once installed you can start rendering breadcrumbs immediately.

```php
<div class="container">
    {{ Breadcrumbs::render() }}
</div>
```

For example (usign Bootstrap 4) if you url is `http://example.com/about-us/team` the output will be :

```html
<div class="container">
    <nav aria-label="You are here:" role="navigation">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="http://example.com">Home</a></li>
            <li class="breadcrumb-item"><a href="http://example.com/about-us">About us</a></li>
            <li class="breadcrumb-item"><a href="http://example.com/about-us/team">Team</li>
        </ul>
    </nav>
</div>
```

## Configuration

``` php
// Usage description here
```

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email robertfrancken@gmail.com instead of using the issue tracker.

## Credits

- [Rob Francken](https://github.com/robotsinside)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).