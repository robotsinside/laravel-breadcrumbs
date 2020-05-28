<?php

namespace RobotsInside\Breadcrumbs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class Segment
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The current segment
     *
     * @var string
     */
    protected $segment;

    /**
     * The overridden segment path.
     *
     * @var string
     */
    protected $path;

    public function __construct(Request $request, $segment)
    {
        $this->request = $request;

        $this->segment = $segment;
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
     * The request segments.
     *
     * @return array
     */
    protected function segments()
    {
        return $this->request->segments();
    }

    /**
     * The injected request model.
     *
     * @return Model|null
     */
    public function model()
    {    
        $model = collect($this->request->route()->parameters())->where('id', $this->segment)->first();

        return $model ? $model : false;
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
        if($this->path) {
            return $this->path;
        }
        
        return url(implode('/', $this->current()));
    }

    /**
     * Pluck the current segment.
     *
     * @return array
     */
    public function current()
    {
        return array_slice($this->segments(), 0, $this->position() + 1);
    }

    /**
     * Determine the position for the current segment
     *
     * @return int
     */
    public function position()
    {
        return array_search($this->segment, $this->segments());
    }

    /**
     * Override the path for the current segment.
     *
     * @param string $path
     * @return void
     */
    public function setPath($path)
    {
        $this->path = $path;
    }
}
