<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Services\Neo4jService;

Route::get('/test-neo4j', function (Neo4jService $neo4j) {
    try {
        $result = $neo4j->client->run('RETURN "Neo4j OK" AS message');
        return response()->json([
            'message' => $result->first()->get('message')
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }
});

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);