<?php

namespace RobotsInside\Breadcrumbs;

use Illuminate\Http\Request;

class Breadcrumbs
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The collection of breadcrumb segments.
     *
     * @var Collection
     */
    protected $segments;

    /**
     * The mutator class.
     *
     * @var \RobotsInside\Breadcrumbs\Mutator
     */
    protected $mutator;

    /**
     * Breadcrumbs constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Mutate the breadcrumbs.
     *
     * @param string $mutator
     * @return array
     */
    public function mutate($mutator)
    {
        $this->mutator = $this->instance($mutator);

        $this->setSegments();

        $this->mutator->setSegments($this->segments);

        $this->mutator->mutate();

        $this->segments = $this->mutator->getSegments();

        return $this;
    }

    /**
     * Render the breadcrumbs. If a mutator exists, render the mutated segments.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        if($this->mutator) {
            return view($this->viewPath())->with(['segments' => $this->segments->toArray()]);
        }
        
        $this->setSegments();

        return view($this->viewPath())->with(['segments' => $this->segments->toArray()]);
    }

    /**
     * The path to the breadcrumb markup template.
     *
     * @return string
     */
    private function viewPath()
    {
        if(config()->has('breadcrumbs.template.style') && config('breadcrumbs.template.style') == 'custom') {
            return config('breadcrumbs.template.path');
        }

        return sprintf('vendor.breadcrumbs.%s', config('breadcrumbs.template.style'));
    }

    /**
     * Instanciate the mutator.
     *
     * @param string $className
     * @return void
     */
    private function instance($className)
    {
        $mutator = config('breadcrumbs.mutators.namespace') . $className;

        return new $mutator;
    }

    /**
     * Set the URL segments;
     *
     * @return void
     */
    protected function setSegments()
    {
        $this->segments = collect($this->request->segments())->map(function ($segment) {
            return new Segment($segment);
        });

        $this->setRootNode();
    }

    /**
     * The breadcrumbs root node.
     *
     * @return void
     */
    private function setRootNode()
    {
        $root = new Segment($this->rootLabel(), config('breadcrumbs.root.url'));
        $root->setRoot();

        $this->segments->splice(0, 0, [$root]);
    }

    /**
     * The root node label option.
     *
     * @return void
     */
    private function rootLabel()
    {
        if(config('breadcrumbs.root.style') == 'label') {
            return config('breadcrumbs.root.label');
        } elseif(config('breadcrumbs.root.style') == 'icon') {
            return config('breadcrumbs.root.icon');
        } elseif(config('breadcrumbs.root.style') == 'icon_label') {
            return sprintf('%s %s', config('breadcrumbs.root.icon'), config('breadcrumbs.root.label'));
        }
    }
}
