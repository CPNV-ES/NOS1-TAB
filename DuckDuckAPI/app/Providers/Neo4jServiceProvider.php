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
            $scheme = env('NEO4J_SCHEME', 'bolt');
            $host = env('NEO4J_HOST');
            $port = env('NEO4J_PORT');
            $user = env('NEO4J_USERNAME');
            $pass = env('NEO4J_PASSWORD');
            $database = env('NEO4J_DATABASE', 'neo4j');

            // DSN complet avec base
            $dsn = "{$scheme}://{$user}:{$pass}@{$host}:{$port}?database={$database}";

            return ClientBuilder::create()
                ->withDriver('bolt', $dsn)
                ->withDefaultDriver('bolt')
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
