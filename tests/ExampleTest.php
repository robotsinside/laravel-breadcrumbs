<?php

namespace RobotsInside\Breadcrumbs\Tests;

use Orchestra\Testbench\TestCase;
use RobotsInside\Breadcrumbs\BreadcrumbsServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [BreadcrumbsServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
