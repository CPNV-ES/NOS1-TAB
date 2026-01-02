<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Post;


class PostController extends Controller
{
    /**
     * GET /api/profils/{id}/posts
     */
    public function index(string $id)
    {
        $query = '
            MATCH (p:Profil {id: $id})-[:POSTED]->(post:Post)
            RETURN post
        ';

        $result = app('neo4j')->run($query, ['id' => $id]);

        return collect($result->toArray())->map(function ($row) {
            return Post::fromNode($row['post'])->toArray();
        });
    }

    /**
     * POST /api/profils/{id}/posts
     */
    public function store(Request $request,  string $id)
    {
        $post_id = Str::uuid()->toString();
        $description = $request->description;
        $image_id = $request->image_id;
        $created_at = now()->toISOString();
        $updated_at = $created_at;

        $query = '
            MATCH (p:Profil {id: $id})
            CREATE (post:Post {
                id: $post_id,
                description: $description,
                image_id: $image_id,
                created_at: $created_at,
                updated_at: $updated_at
            })
            CREATE (p)-[:POSTED {created_at: $created_at}]->(post)
            RETURN post
        ';

        $params = compact('id', 'post_id', 'description', 'image_id', 'created_at', 'updated_at');

        $result = app('neo4j')->run($query, $params);

        return Post::fromNode($result->first()->get('post'))->toArray();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, string $post_id)
    {
        $query = '
            MATCH (:Profil {id: $id})-[:POSTED]->(post:Post {id: $post_id})
            RETURN post
        ';

        $result = app('neo4j')->run($query, compact('id', 'post_id'));

        return Post::fromNode($result->first()->get('post'))->toArray();
    }

    /**
     * PUT /api/profils/{id}/posts/{post_id}
     */
    public function update(Request $request, string $id, string $post_id)
    {
        $description = $request->description;
        $image_id = $request->image_id;
        $updated_at = now()->toISOString();

        $query = '
            MATCH (:Profil {id: $id})-[:POSTED]->(post:Post {id: $post_id})
            SET post.description = $description,
                post.image_id = $image_id,
                post.updated_at = $updated_at
            RETURN post
        ';

        $params = compact('id', 'post_id', 'description', 'image_id', 'updated_at');

        $result = app('neo4j')->run($query, $params);

        return Post::fromNode($result->first()->get('post'))->toArray();
    }

    /**
     * DELETE /api/profils/{id}/posts/{post_id}
     */
    public function destroy(string $id, string $post_id)
    {
        $query = '
            MATCH (:Profil {id: $id})-[:POSTED]->(post:Post {id: $post_id})
            DETACH DELETE post
        ';

        app('neo4j')->run($query, compact('id', 'post_id'));

        return response()->json(['deleted' => true]);
    }
}
