<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laudis\Neo4j\ClientBuilder;
use Laudis\Neo4j\Authentication\Authenticate;

class Neo4jServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('neo4j', function () {
            return ClientBuilder::create()
                ->withDriver(
                    'bolt',
                    env('NEO4J_URI', env('NEO4J_SCHEME') . '://' . env('NEO4J_HOST') . ':' . env('NEO4J_PORT')),
                    Authenticate::basic(env('NEO4J_USER'), env('NEO4J_PASSWORD'))
                )
                ->build();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
