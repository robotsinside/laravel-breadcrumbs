<?php

return [
    /**
     * The template to use for rendering out breadcrumbs. If you want, you can even define your
     * own template. This template should be provided in your views directory under the path
     * resources/views/breadcrumbs/yourBladeTemplate.blade.php
     *
     * Supported values: 'bootstrap-4', 'bootstrap-3', 'bulma', 'foundation, 'custom'
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
