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
     * @var CustomSegments
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
     * @return array
     */
    public function mutate($mutator = null)
    {
        $this->mutator = $this->instance($mutator);

        $this->mutator->setSegments($this->segments);

        $this->mutator->mutate();

        $this->segments = $this->mutator->getSegments();

        return $this;
    }

    /**
     * Render the breadcrumbs. IF a mutator exists, the segments will be overridden.
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
            return new Segment($this->request, $segment);
        });
    }
}
