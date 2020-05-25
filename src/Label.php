<?php

namespace RobotsInside\Breadcrumbs;

use Illuminate\Database\Eloquent\Model;

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
