<?php

namespace RobotsInside\Breadcrumbs\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RobotsInside\Breadcrumbs\Skeleton\SkeletonClass
 */
class Breadcrumbs extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'breadcrumbs';
    }
}
