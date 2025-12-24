<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::get('/test-neo4j', function () {
    $client = app('neo4j');

    $result = $client->run('RETURN "Neo4j OK" AS message');

    return response()->json([
        'message' => $result->first()->get('message')
    ]);
});

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);