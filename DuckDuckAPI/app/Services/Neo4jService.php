<?php

namespace App\Services;

use Laudis\Neo4j\ClientBuilder;

class Neo4jService
{
    public $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->withDriver(
                'default',
                config('neo4j.uri'),
                \Laudis\Neo4j\Authentication\Authenticate::basic(
                    config('neo4j.user'),
                    config('neo4j.password')
                )
            )
            ->build();
    }
}
