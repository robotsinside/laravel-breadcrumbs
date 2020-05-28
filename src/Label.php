<?php

namespace RobotsInside\Breadcrumbs;

abstract class Label
{
    /**
     * The segment model instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    public function setModel($model)
    {
        $this->model = $model;
    }

    abstract public function label();
}
