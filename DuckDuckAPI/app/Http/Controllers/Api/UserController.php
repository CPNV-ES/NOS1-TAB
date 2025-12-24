<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Neo4jService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $neo4j;

    public function __construct(Neo4jService $neo4j)
    {
        $this->neo4j = $neo4j->client;
    }

    public function index()
    {
        $result = $this->neo4j->run(
            'MATCH (u:User) RETURN u'
        );

        $users = [];

        foreach ($result as $record) {
            $users[] = $record->get('u')->getProperties();
        }

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $this->neo4j->run(
            'CREATE (u:User {name: $name, email: $email})',
            [
                'name' => $request->name,
                'email' => $request->email,
            ]
        );

        return response()->json(['message' => 'Utilisateur créé'], 201);
    }
}
