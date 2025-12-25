<?php

namespace App\Services;

use Laudis\Neo4j\ClientBuilder;
use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\Contracts\ClientInterface;

class Neo4jService
{
    public ClientInterface $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->withDriver(
                'default',
                config('neo4j.uri'),
                Authenticate::basic(
                    config('neo4j.user'),
                    config('neo4j.password')
                )
            )
            ->build();
    }
}
