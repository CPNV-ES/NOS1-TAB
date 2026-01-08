<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friend;
use App\Models\Profil;

class FriendController extends Controller
{
    /**
     * GET /api/profils/{id}/friends
     */
    public function index(string $id)
    {
        $query = '
            MATCH (p:Profil {id: $id})-[:FRIEND]->(f:Profil)
            RETURN f
        ';

        $result = app('neo4j')->run($query, ['id' => $id]);

        return collect($result->toArray())->map(function ($row) {
            return Profil::fromNode($row['f'])->toArray();
        });
    }

    /**
     * POST /api/profils/{id}/friends/{friend_id}
     */
    public function store(string $id, string $friend_id)
    {
        $created_at = now()->toISOString();

        $query = '
            MATCH (a:Profil {id: $id}), (b:Profil {id: $friend_id})
            CREATE (a)-[:FRIEND {created_at: $created_at}]->(b)
            RETURN b
        ';

        $params = compact('id', 'friend_id', 'created_at');

        $result = app('neo4j')->run($query, $params);

        return Profil::fromNode($result->first()->get('b'))->toArray();
    }

    /**
     * DELETE /api/profils/{id}/friends/{friend_id}
     */
    public function destroy(string $id, string $friend_id)
    {
        $query = '
            MATCH (a:Profil {id: $id})-[f:FRIEND]->(b:Profil {id: $friend_id})
            DELETE f
        ';

        app('neo4j')->run($query, compact('id', 'friend_id'));

        return response()->json(['deleted' => true]);
    }
}
