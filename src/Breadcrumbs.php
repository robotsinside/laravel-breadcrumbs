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
     * The customizer class
     *
     * @var CustomSegments
     */
    protected $customizer;

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
     * Customize the breadcrumbs.
     *
     * @return array
     */
    public function customize($customizer = null)
    {
        $this->customizer = $this->instance($customizer);

        $this->customizer->setSegments($this->segments());

        $this->customizer->customize();

        $this->segments = $this->customizer->getSegments();

        return $this;
    }

    /**
     * Render the breadcrumbs.
     *
     * @return void
     */
    public function render()
    {
        if($this->customizer) {
            return $this->segments->toArray();
        }
        
        $this->setSegments();

        return $this->segments->toArray();
    }

    /**
     * Instanciate the customizer.
     *
     * @param string $className
     * @return void
     */
    private function instance($className)
    {
        $class = config('breadcrumbs.segments.namespace') . $className;

        return new $class;
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

    /**
     * The entire set of segments;
     *
     * @return Collection
     */
    private function segments()
    {
        return collect($this->request->segments())->map(function ($segment) {
            return new Segment($this->request, $segment);
        });
    }
}
