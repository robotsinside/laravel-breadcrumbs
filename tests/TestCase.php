<?php

namespace RobotsInside\Breadcrumbs\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use RobotsInside\Breadcrumbs\BreadcrumbsServiceProvider;
use Orchestra\Testbench\TestCase as BaseTest;

class TestCase extends BaseTest
{
    public function setUp() :void
    {
        parent::setUp();

        Model::unguard();
    }

    protected function getPackageProviders($app)
    {
        return [BreadcrumbsServiceProvider::class];
    }

    public function tearDown() :void
    {
        Schema::drop('authors');
        Schema::drop('posts');
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app->config->set('view.paths', [__DIR__ . '/resources/views']);
        $app->config->set('breadcrumbs.view', 'breadcrumbs');
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testbench');

        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $this->runMigrations();
    }

    private function runMigrations()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('title');
            $table->timestamps();
        });

        Schema::create('authors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('name');
            $table->timestamps();
        });
    }
}

