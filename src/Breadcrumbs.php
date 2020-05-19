<?php

namespace RobotsInside\Breadcrumbs;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Breadcrumbs
{
    protected $request;
    
    protected $segments;

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
     * Generate the breadcrumbs.
     *
     * @return array
     */
    public function generate($config)
    {
        if (isset($config['custom'])) {
            $class = __NAMESPACE__ . '\\Segments\\' . ucfirst(Str::camel($config['custom']));
            $this->segments = (new $class($this->segmentCollection(), $config))->getSegments();
        } else {
            $this->setSegments();
        }

        return $this->segments->toArray();
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
    private function segmentCollection()
    {
        return collect($this->request->segments())->map(function ($segment) {
            return new Segment($this->request, $segment);
        });
    }
}
