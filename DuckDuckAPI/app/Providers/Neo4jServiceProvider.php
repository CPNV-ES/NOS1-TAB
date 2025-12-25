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

            $host   = env('NEO4J_HOST', '127.0.0.1');
            $port   = env('NEO4J_PORT', 7687);

            $uri = "bolt://{$host}:{$port}";

            return ClientBuilder::create()
                ->withDriver(
                    'default',
                    $uri,
                    Authenticate::basic(
                        env('NEO4J_USER'),
                        env('NEO4J_PASSWORD')
                    )
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
