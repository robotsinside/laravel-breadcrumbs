# Laravel Breadcrumbs

[![Latest Version on Packagist](https://img.shields.io/packagist/v/robotsinside/laravel-breadcrumbs.svg?style=flat-square)](https://packagist.org/packages/robotsinside/laravel-breadcrumbs)
[![Total Downloads](https://img.shields.io/packagist/dt/robotsinside/breadcrumbs.svg?style=flat-square)](https://packagist.org/packages/robotsinside/breadcrumbs)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

A simple breadcrumbs implementation for Laravel 7+ with flexible class based segment customisation.

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

For example (using the Bootstrap 4 template) if you url is `http://example.test/about-us/team` the output will be:

```sh
+-----------+-------------------------------+-----------------------+---------------------------------------------------------------+
| Method    | URI                           | Name                  | Action                                                        |
+-----------+-------------------------------+-----------------------+---------------------------------------------------------------+
| GET|HEAD  | about-us/team                 | about.team            | Closure                                                       |                                    
```

```html
<div class="container">
    <nav aria-label="You are here:" role="navigation">
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="http://example.test">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="http://example.test/about-us">About us</a>
            </li>
            <li class="breadcrumb-item">
                Team
            </li>
        </ul>
    </nav>
</div>
```

The following example includes an injected model.

```sh
+-----------+-------------------------------+-----------------------+---------------------------------------------------------------+
| Method    | URI                           | Name                  | Action                                                        |
+-----------+-------------------------------+-----------------------+---------------------------------------------------------------+
| GET|HEAD  | posts/{post}                  | posts.show            | App\App\Posts\Controllers\PostController@show                 |
```

By default the package will look for the `title` and `name` properties on the `Post` model. If this does not suit your use-case, you can define a `BreadcrumbLabel` class as shown below. This class contains a `model` property which is resolved via the route model binding.

```php
<?php

namespace App\Breadcrumbs\Labels;

use RobotsInside\Breadcrumbs\Label;

class PostBreadcrumbLabel extends Label
{
    public function label()
    {
        return $this->model->whatever;
    }    
}
```

Don't forget to register your label classes as explained in [Breadcrumb labels](#breadcrumbLabels).

## Configuration

The config file should be pretty self explanatory.

### Templates

You have the option of choosing a pre-defined template, or creating your own. The provided options are:

- Bootstrap 3 (bootstrap-3)
- Bootstrap 4 (bootstrap-4)
- Bulma (bulma)
- Foundation (foundation)

If you want to provide your own breadcrumbs template, provide the name of your Blade template in the template option:

```php
'template' => [
    'style' => 'custom',
    'path' => 'breadcrumbs.custom' // Will look in: 'views.breadcrumbs.custom'
],
```

This will look for `resources/views/breadcrumbs/my-template.blade.php`.

### Breadcrumb mutators

If you want to define any breadcrumb mutator classes, you need to provide the namespace where the `Mutator` classes are located. By default this is set to `App\\Breadcrumbs\\Mutators\\`, but you can change it to suit your project requirements.

### <a name="breadcrumbLabels"></a> Breadcrumb labels

By default, the package will look for `name` and `title` properties on injected route models. This is really just a convenience since many of my own models contain those properties. But you're not limited to these, you can easily provide custom logic to define your model labels.

You will need to provide a mapping for your `Model` => `BreadcrumbLabel` classes in `config/breadcrumbs.php`. See reasons why I chose this setup in "Package removal".

```php
'labels' => [
    App\Post::class => App\Breadcrumbs\Labels\PostBreadcrumbLabel::class,
],
```

### Removing nodes

Let's say you have an admin area in your app, in that case you probably want to remove the `admin` segment from your breadcrumbs.

You can achieve this by defining a mutator and calling the `remove` method in the `mutate` method. The `remove` method expect an array, so you can remove multiple nodes if needed.

```php
<?php

namespace App\Breadcrumbs\Mutators;

use RobotsInside\Breadcrumbs\Mutator;

class AdminMutator extends Mutator
{
	public function mutate()
	{
		$this->remove(['admin']);
	}
}
```

```blade
{{ Breadcrumbs::mutate('AdminMutator')->render() }}
```

If the URL is `http://example.test/admin/posts/my-post`, breadcrumbs will render:

```html
<nav aria-label="You are here:" role="navigation">
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="http://example.test">
                Home
            </a>
        </li>
        <li class="breadcrumb-item">
            My Post
        </li>
    </ul>
</nav>
```

### Adding nodes

If for some reason you need to add one or more nodes, you can do that too.

You can achieve this by defining a mutator and calling the `add` method in the `mutate` method, for example:

```php
<?php

namespace App\Breadcrumbs\Mutators;

use RobotsInside\Breadcrumbs\Mutator;

class AddPostIndexMutator extends Mutator
{
	public function mutate()
	{
		$this->add('All Posts', 'my-post', route('posts.index'));
	}
}
```

```blade
{{ Breadcrumbs::mutate('AddPostIndexMutator')->render() }}
```

If the URL is `http://example.test/my-post`, breadcrumbs will render:

```html
<nav aria-label="You are here:" role="navigation">
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="http://example.test">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a href="http://example.test/posts">All Posts</a>
        </li>
        <li class="breadcrumb-item">
            My Post
        </li>
    </ul>
</nav>
 ```

## Package removal

To remove the package: 

1. Remove the facade in `config/app.php`
2. Delete the `path/to/Breadcrumbs` directory from your application
3. Delete all `{{ Breadcrumbs::render }}` statements in your views
4. Delete `config/breadcrumbs.php`
5. Run `composer remove robotsinside/laravel-breadcrumbs`

When I developed this package I was faced with a decision on how to let users customise their breadcrumbs. Initally I though I would provide a `BreadcrumbsInteface` that would need to be implemented on `Model` classes, but later decided against it since that would mean implementing methods on all of your models that have breadcrumb labels. 

Instead, I opted for a config array mapping since that would be easier to remove at a later date if you decide to remove this package from your project at a later date.

## Todo

1. Write tests
2. Finish README

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