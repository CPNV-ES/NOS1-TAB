<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Profil;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * GET /api/profils/{id}/posts
     */
    public function index(string $id)
    {
        $query = '
            MATCH (profil:Profil {id: $id})-[:POSTED]->(post:Post)
            RETURN post, profil
        ';

        $result = app('neo4j')->run($query, ['id' => $id]);

        return collect($result->toArray())->map(function ($row) {
            $profil = Profil::fromNode($row['profil']);
            return Post::fromNode($row['post'], $profil)->toArray();
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
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = Str::uuid() . '.' . $extension;

            Storage::disk('public')->putFileAs('posts', $request->file('image'), $filename);

            $baseUrl = $request->getScheme() . '://' . $request->getHost();
            if ($request->getPort() && !in_array($request->getPort(), [80, 443])) {
                $baseUrl .= ':' . $request->getPort();
            }
            $image_url = $baseUrl . '/storage/posts/' . $filename;
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
            RETURN post, p AS profil
        ';

        $params = compact('id', 'post_id', 'description', 'image_url', 'created_at', 'updated_at');

        $result = app('neo4j')->run($query, $params);

        $profil = Profil::fromNode($result->first()->get('profil'));

        return Post::fromNode($result->first()->get('post'), $profil)->toArray();
    }

    /**
     * GET /api/profils/{id}/posts/{post_id}
     */
    public function show(string $id, string $post_id)
    {
        $query = '
            MATCH (profil:Profil {id: $id})-[:POSTED]->(post:Post {id: $post_id})
            RETURN post, profil
        ';

        $result = app('neo4j')->run($query, compact('id', 'post_id'));

        $profil = Profil::fromNode($result->first()->get('profil'));

        return Post::fromNode($result->first()->get('post'), $profil)->toArray();
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
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = Str::uuid() . '.' . $extension;

            Storage::disk('public')->putFileAs('posts', $request->file('image'), $filename);

            $baseUrl = $request->getScheme() . '://' . $request->getHost();
            if ($request->getPort() && !in_array($request->getPort(), [80, 443])) {
                $baseUrl .= ':' . $request->getPort();
            }
            $image_url = $baseUrl . '/storage/posts/' . $filename;
        }

        if ($image_url) {
            $query = '
                MATCH (profil:Profil {id: $id})-[:POSTED]->(post:Post {id: $post_id})
                SET post.description = $description,
                    post.image_url = $image_url,
                    post.updated_at = $updated_at
                RETURN post, profil
            ';
            $params = compact('id', 'post_id', 'description', 'image_url', 'updated_at');
        } else {
            $query = '
                MATCH (profil:Profil {id: $id})-[:POSTED]->(post:Post {id: $post_id})
                SET post.description = $description,
                    post.updated_at = $updated_at
                RETURN post, profil
            ';
            $params = compact('id', 'post_id', 'description', 'updated_at');
        }

        $result = app('neo4j')->run($query, $params);

        $profil = Profil::fromNode($result->first()->get('profil'));

        return Post::fromNode($result->first()->get('post'), $profil)->toArray();
    }

    /**
     * DELETE /api/profils/{id}/posts/{post_id}
     */
    public function destroy(string $id, string $post_id)
    {
        $result = app('neo4j')->run(
            'MATCH (profil:Profil {id: $id})-[:POSTED]->(post:Post {id: $post_id})
             RETURN post, profil',
            compact('id', 'post_id')
        );

        if ($result->isEmpty()) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $profil = Profil::fromNode($result->first()->get('profil'));
        $post = Post::fromNode($result->first()->get('post'), $profil);

        if (!empty($post->image_url)) {
            $filename = basename($post->image_url);

            Storage::disk('public')->delete('posts/' . $filename);
        }

        app('neo4j')->run(
            'MATCH (:Profil {id: $id})-[:POSTED]->(post:Post {id: $post_id})
             DETACH DELETE post',
            compact('id', 'post_id')
        );

        return response()->json(['deleted' => true]);
    }
}
