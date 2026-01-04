<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Profil;

class ProfilController extends Controller
{
    public function index()
    {
        $result = app('neo4j')->run('MATCH (p:Profil) RETURN p');

        return collect($result->toArray())->map(function ($row) {
            return Profil::fromNode($row['p'])->toArray();
        });
    }

    public function store(Request $request)
    {
        $id = Str::uuid()->toString();
        $name = $request->name;
        $hash = Hash::make($request->password);
        $created_at = now()->toISOString();
        $updated_at = now()->toISOString();

        $image_url = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/profils');
            $filename = basename($path);
            $image_url = url("storage/profils/$filename");
        }

        $query = '
            CREATE (p:Profil {
                id: $id,
                name: $name,
                image_url: $image_url,
                hash: $hash,
                created_at: $created_at,
                updated_at: $updated_at
            })
            RETURN p
        ';

        $params = compact('id', 'name', 'image_url', 'hash', 'created_at', 'updated_at');

        $result = app('neo4j')->run($query, $params);

        return Profil::fromNode($result->first()->get('p'))->toArray();
    }


    public function show(string $id)
    {
        $result = app('neo4j')->run(
            'MATCH (p:Profil {id: $id}) RETURN p',
            ['id' => $id]
        );

        return Profil::fromNode($result->first()->get('p'))->toArray();
    }

    public function update(Request $request, string $id)
    {
        $name = $request->name;
        $updated_at = now()->toISOString();

        $image_url = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/profils');
            $filename = basename($path);
            $image_url = url("storage/profils/$filename");
        }

        if ($image_url) {
            $query = '
                MATCH (p:Profil {id: $id})
                SET p.name = $name,
                    p.image_url = $image_url,
                    p.updated_at = $updated_at
                RETURN p
            ';
            $params = compact('id', 'name', 'image_url', 'updated_at');
        } else {
            $query = '
                MATCH (p:Profil {id: $id})
                SET p.name = $name,
                    p.updated_at = $updated_at
                RETURN p
            ';
            $params = compact('id', 'name', 'updated_at');
        }

        $result = app('neo4j')->run($query, $params);

        return Profil::fromNode($result->first()->get('p'))->toArray();
    }


    public function destroy(string $id)
    {
        $result = app('neo4j')->run(
            'MATCH (p:Profil {id: $id}) RETURN p',
            ['id' => $id]
        );

        if ($result->isEmpty()) {
            return response()->json(['error' => 'Profil not found'], 404);
        }

        $profil = Profil::fromNode($result->first()->get('p'));

        if (!empty($profil->image_url)) {
            $filename = basename($profil->image_url);

            $path = storage_path("app/public/profils/$filename");

            if (file_exists($path)) {
                unlink($path);
            }
        }

        app('neo4j')->run(
            'MATCH (p:Profil {id: $id}) DETACH DELETE p',
            ['id' => $id]
        );

        return response()->json(['deleted' => true]);
    }
}