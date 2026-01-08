<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * GET /api/posts/{id}/comments
     */
    public function index(string $id)
    {
        $query = '
            MATCH (u:Profil)-[c:COMMENT]->(p:Post {id: $id})
            RETURN u.id AS from_id, c
            ORDER BY c.created_at ASC
        ';

        $result = app('neo4j')->run($query, ['id' => $id]);

        return collect($result->toArray())->map(function ($row) {
            return Comment::fromRelationship($row['c'], $row['from_id'])->toArray();
        });
    }

    /**
     * POST /api/posts/{id}/comments
     */
    public function store(Request $request, string $id)
    {
        $comment_id = Str::uuid()->toString();
        $from_id = $request->from_id;
        $text = $request->text;
        $created_at = now()->toISOString();
        $updated_at = $created_at;

        $query = '
            MATCH (u:Profil {id: $from_id}), (p:Post {id: $id})
            CREATE (u)-[c:COMMENT {
                id: $comment_id,
                text: $text,
                created_at: $created_at,
                updated_at: $updated_at
            }]->(p)
            RETURN u.id AS from_id, c
        ';

        $params = compact('comment_id', 'from_id', 'id', 'text', 'created_at', 'updated_at');

        $result = app('neo4j')->run($query, $params);

        $row = $result->first();

        return Comment::fromRelationship($row->get('c'), $row->get('from_id'))->toArray();
    }

    /**
     * DELETE /api/posts/{id}/comments/{comment_id}
     */
    public function destroy(string $id, string $comment_id)
    {
        $query = '
            MATCH (:Post {id: $id})<-[c:COMMENT {id: $comment_id}]-(:Profil)
            DELETE c
        ';

        app('neo4j')->run($query, compact('id', 'comment_id'));

        return response()->json(['deleted' => true]);
    }
}