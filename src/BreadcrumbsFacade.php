<?php

namespace RobotsInside\Breadcrumbs;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RobotsInside\Breadcrumbs\Skeleton\SkeletonClass
 */
class BreadcrumbsFacade extends Facade
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
