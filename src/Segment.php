<?php

namespace RobotsInside\Breadcrumbs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class Segment
{
    protected $request;

    protected $segment;

    protected $path;

    public function __construct(Request $request, $segment)
    {
        $this->request = $request;

        $this->segment = $segment;
    }

    public function segment()
    {
        return $this->segment;
    }

    /**
     * The natural name of the segment
     *
     * @return void
     */
    public function name()
    {
        return str_replace('-', ' ', Str::title($this->segment()));
    }

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
        return collect($this->request->route($this->segment))->first();
    }

    public function label()
    {
        if($this->labelClassExists()) {
            return $this->labelInstance()->label();
        }

        return $this->model() ? '$this->model()->title' : $this->name();
    }

    private function labelClassExists()
    {
        return $this->model() && Config::has('breadcrumbs.labels.'.get_class($this->request->route($this->segment)));
    }

    private function labelInstance()
    {
        $class = Config::get('breadcrumbs.labels.'.get_class($this->request->route($this->segment)));

        $instance = new $class;

        $instance->setModel($this->request->route($this->segment));

        return $instance;
    }

    public function url()
    {
        if($this->path) {
            return $this->path;
        }
        
        return url(implode('/', $this->current()));
    }

    public function current()
    {
        return array_slice($this->segments(), 0, $this->position() + 1);
    }

    public function position()
    {
        return array_search($this->segment, $this->segments());
    }

    public function setPath($path)
    {
        $this->path = $path;
    }
}
