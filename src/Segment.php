<?php

namespace RobotsInside\Breadcrumbs;

use Illuminate\Http\Request;
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

    public function request()
    {
        return $this->request;
    }

    public function segment()
    {
        return $this->segment;
    }

    public function name()
    {
        return str_replace('-', ' ', Str::title($this->segment()));
    }

    protected function segments()
    {
        return $this->request->segments();
    }

    public function model()
    {
        return collect($this->request->route()->parameters())->where('slug', $this->segment)->first();
    }

    public function label()
    {
        return $this->model() ? $this->model()->breadcrumbTitle() : $this->name();
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
