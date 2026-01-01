<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Profil;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $result = app('neo4j')->run('MATCH (p:Profil) RETURN p');

        return collect($result->toArray())->map(function ($row) {
            return Profil::fromNode($row['p'])->toArray();
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = Str::uuid()->toString();
        $name = $request->name;
        $image_id = $request->image_id;
        $hash = Hash::make($request->password);
        $created_at = now()->toISOString();
        $updated_at = now()->toISOString();

        $query = '
            CREATE (p:Profil {
                id: $id,
                name: $name,
                image_id: $image_id,
                hash: $hash,
                created_at: $created_at,
                updated_at: $updated_at
            })
            RETURN p
        ';

        $params = compact('id', 'name', 'image_id', 'hash', 'created_at', 'updated_at');

        $result = app('neo4j')->run($query, $params);

        return Profil::fromNode($result->first()->get('p'))->toArray();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = app('neo4j')->run(
            'MATCH (p:Profil {id: $id}) RETURN p',
            ['id' => $id]
        );

        return Profil::fromNode($result->first()->get('p'))->toArray();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $name = $request->name;
        $image_id = $request->image_id;
        $updated_at = now()->toISOString();

        $query = '
            MATCH (p:Profil {id: $id})
            SET p.name = $name,
                p.image_id = $image_id,
                p.updated_at = $updated_at
            RETURN p
        ';

        $params = compact('id', 'name', 'image_id', 'updated_at');

        $result = app('neo4j')->run($query, $params);

        return Profil::fromNode($result->first()->get('p'))->toArray();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        app('neo4j')->run(
            'MATCH (p:Profil {id: $id}) DETACH DELETE p',
            ['id' => $id]
        );

        return response()->json(['deleted' => true]);
    }
}
