<?php

return [
    /**
     * Define the breadcrumbs root node here. The icon supports raw HTML, so you are free choose any 
     * icon markup as long as your app knows how to render it. The icon can be removed by setting
     * it 'false'. The "You are here:" text can be disabled by setting if false too
     */
    'root' => [
        'label' => 'Home',
        'url' => env('APP_URL'),
        'icon' => false,
        'you_are_here' => false,
    ],

    /**
     * The template to use for rendering out breadcrumbs. If you want, you can even define your
     * own template. This template should be provided in your views directory under the path
     * resources/views/breadcrumbs/yourBladeTemplate.blade.php
     *
     * Supported values: 'bootstrap-4', 'bootstrap-3', 'bulma', 'foundation, 'your-template'
     */
    'template' => 'bootstrap-4',

    /**
     * The namespace from where to load breadcrumb mutators.
     */
    'mutators' => [
        'namespace' => 'App\\Breadcrumbs\\Mutators\\',
    ],

    /**
     * If you want to overide an injected route models' label, you can provide a mapping here which
     * maps models to classes which allows custom logic to generate the breadcrumb label.
     */
    'labels' => [
        App\Post::class => App\Breadcrumbs\Labels\PostBreadcrumbLabel::class,
    ],
];
