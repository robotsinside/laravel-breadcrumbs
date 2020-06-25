<?php

namespace RobotsInside\Breadcrumbs;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class Segment
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The collection of URL segments.
     *
     * @var Collection
     */
    protected $urlSegments;

    /**
     * The collection of URI segments.
     *
     * @var Collection
     */
    protected $uriSegments;

    /**
     * The collection of URL => URI segments.
     *
     * @var Collection
     */
    protected $mergedSegments;

    /**
     * The current segment
     *
     * @var string
     */
    protected $segment;

    /**
     * The current url.
     *
     * @var string
     */
    protected $url;

    /**
     * The route's model binding.
     *
     * @var Model
     */
    protected $model;

    public function __construct($segment, $url = null)
    {
        $this->request = request();

        $this->url = $url;

        $this->segment = $segment;

        $this->init();
    }

    /**
     * Initialise the required data.
     *
     * @return void
     */
    private function init()
    {
        $this->urlSegments = collect($this->request->segments());

        $this->uriSegments = collect(explode('/', $this->request->route()->uri()));

        $this->mergedSegments = $this->urlSegments->mapWithkeys(function ($item, $key) {
            return [$item => $this->uriSegments->toArray()[$key]];
        });

        $this->setRouteModel();
    }

    /**
     * Locate and set the route model.
     *
     * @return void
     */
    private function setRouteModel()
    {
        $uriSegment = $this->mergedSegments->get($this->segment);

        if(Str::containsAll($uriSegment, ['{', '}'])) {
            // it's model
            $this->model = $this->request->route(str_replace(['{', '}'], '', $uriSegment));
        }        
    }

    /**
     * The current segment.
     *
     * @return string
     */
    public function segment()
    {
        return $this->segment;
    }

    /**
     * The request URL segments.
     *
     * @return array
     */
    protected function segments()
    {
        return $this->urlSegments->toArray();
    }

    /**
     * The injected request model.
     *
     * @return Model|null
     */
    public function model()
    {    
        return $this->model;
    }

    /**
     * The title-cased segment.
     *
     * @return string
     */
    public function segmentTitleCase()
    {
        return str_replace('-', ' ', Str::title($this->segment()));
    }

    /**
     * The label for the current segment. If no custom class is provided, default to model title|name attribute.
     *
     * @return void
     */
    public function label()
    {
        if($this->labelClassExists()) {
            return $this->labelInstance()->label();
        }

        return $this->model() ? $this->model()->title ?? $this->model()->name : $this->segmentTitleCase();
    }

    /**
     * Determine if a custom label class exists.
     *
     * @return boolean
     */
    private function labelClassExists()
    {
        return $this->model() && Config::has('breadcrumbs.labels.'.get_class($this->model()));
    }

    /**
     * Get the custom breadcrumb label class.
     *
     * @return \RobotsInside\Breadcrumbs\Label
     */
    private function labelInstance()
    {
        $class = Config::get('breadcrumbs.labels.'.get_class($this->model()));

        $instance = new $class;

        $instance->setModel($this->model());

        return $instance;
    }

    /**
     * The URL for the current segment;
     *
     * @return string
     */
    public function url()
    {
        return $this->url ? $this->url : url($this->current()->implode('/'));
    }

    /**
     * Pluck the current segment.
     *
     * @return Collection
     */
    public function current()
    {
        return $this->urlSegments->take($this->position());
    }

    /**
     * Determine the position for the current segment adjusted for taking.
     *
     * @return int
     */
    public function position()
    {
        return $this->urlSegments->search($this->segment) + 1;
    }

    /**
     * Override the path for the current segment.
     *
     * @param string $url
     * @return void
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }
}
