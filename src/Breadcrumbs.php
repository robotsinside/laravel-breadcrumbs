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
        if(config()->has('breadcrumbs.view_path') && config('breadcrumbs.view_path') !== '') {
            return config('breadcrumbs.view_path');
        }

        return sprintf('vendor.breadcrumbs.%s', config('breadcrumbs.template'));
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
        $this->segments->splice(0, 0, [new Segment(config('breadcrumbs.root.label'), config('breadcrumbs.root.url'))]);
    }
}
