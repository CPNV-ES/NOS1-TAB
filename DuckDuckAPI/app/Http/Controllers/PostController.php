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
            MATCH (:Profil {id: $id})-[:POSTED]->(post:Post)
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
    public function store(Request $request, string $id)
    {
        $post_id = Str::uuid()->toString();
        $description = $request->description;
        $created_at = now()->toISOString();
        $updated_at = $created_at;

        $image_url = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/posts');
            $filename = basename($path);
            $image_url = url("storage/posts/$filename");
        }

        $query = '
            MATCH (p:Profil {id: $id})
            CREATE (post:Post {
                id: $post_id,
                description: $description,
                image_url: $image_url,
                created_at: $created_at,
                updated_at: $updated_at
            })
            CREATE (p)-[:POSTED {created_at: $created_at}]->(post)
            RETURN post
        ';

        $params = compact('id', 'post_id', 'description', 'image_url', 'created_at', 'updated_at');

        $result = app('neo4j')->run($query, $params);

        return Post::fromNode($result->first()->get('post'))->toArray();
    }

    /**
     * GET /api/profils/{id}/posts/{post_id}
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
        $updated_at = now()->toISOString();

        $image_url = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/posts');
            $filename = basename($path);
            $image_url = url("storage/posts/$filename");
        }

        if ($image_url) {
            $query = '
                MATCH (:Profil {id: $id})-[:POSTED]->(post:Post {id: $post_id})
                SET post.description = $description,
                    post.image_url = $image_url,
                    post.updated_at = $updated_at
                RETURN post
            ';
            $params = compact('id', 'post_id', 'description', 'image_url', 'updated_at');
        } else {
            $query = '
                MATCH (:Profil {id: $id})-[:POSTED]->(post:Post {id: $post_id})
                SET post.description = $description,
                    post.updated_at = $updated_at
                RETURN post
            ';
            $params = compact('id', 'post_id', 'description', 'updated_at');
        }

        $result = app('neo4j')->run($query, $params);

        return Post::fromNode($result->first()->get('post'))->toArray();
    }

    /**
     * DELETE /api/profils/{id}/posts/{post_id}
     */
    public function destroy(string $id, string $post_id)
    {
        $result = app('neo4j')->run(
            'MATCH (:Profil {id: $id})-[:POSTED]->(post:Post {id: $post_id}) RETURN post',
            compact('id', 'post_id')
        );

        if ($result->isEmpty()) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $post = Post::fromNode($result->first()->get('post'));

        if (!empty($post->image_url)) {
            $filename = basename($post->image_url);
            $path = storage_path("app/public/posts/$filename");

            if (file_exists($path)) {
                unlink($path);
            }
        }

        app('neo4j')->run(
            'MATCH (:Profil {id: $id})-[:POSTED]->(post:Post {id: $post_id}) DETACH DELETE post',
            compact('id', 'post_id')
        );

        return response()->json(['deleted' => true]);
    }
}