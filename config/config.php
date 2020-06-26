<?php

return [
    /**
     * Define the breadcrumbs root node here. The icon supports raw HTML, so you are free choose any
     * icon markup as long as your app knows how to render it. The icon can be removed by setting
     * the style to 'label'. To display only the icon, use 'icon' otherwise use 'icon_label'.
     * 
     * Supported style: 'label', 'icon', 'icon_label'
     * Supported icon: false, '<tag></tag>'
     */
    'root' => [
        'label' => 'Home',
        'url' => env('APP_URL'),
        'style' => 'label',
        // 'icon' => '<tag></tag>',
    ],

    /**
     * The template used for rendering out breadcrumbs. If you want, you can even define your
     * own template. If you choose 'custom', you'll need to set the path where your custom
     * template's markup is defined. You can use the provided templates to get started.
     * 
     * Supported style values: 'bootstrap-4', 'bootstrap-3', 'bulma', 'foundation, 'custom'
     */
    'template' => [
        'style' => 'bootstrap-4',
        // 'path' => 'breadcrumbs.custom' // Will look in: 'views.breadcrumbs.custom'
    ],

    /**
     * The namespace from where to load breadcrumb mutators.
     */
    'mutators' => [
        'namespace' => 'App\\Breadcrumbs\\Mutators\\'
    ],

    /**
     * If you want to overide an injected route models' label, you can provide a mapping here which
     * maps models to classes which define the custom breadcrumb label logic. Each label class
     * receives the inject model and can be accessed at $this->model in your class file.
     */
    'labels' => [
        // App\Post::class => App\Breadcrumbs\Labels\PostBreadcrumbLabel::class,
    ],
];