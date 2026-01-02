<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
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

Route::apiResource('profils', ProfilController::class);

Route::get('/profils/{id}/friends', [FriendController::class, 'index']);
Route::post('/profils/{id}/friends/{friend_id}', [FriendController::class, 'store']);
Route::delete('/profils/{id}/friends/{friend_id}', [FriendController::class, 'destroy']);

Route::get('/profils/{id}/posts', [PostController::class, 'index']);
Route::post('/profils/{id}/posts', [PostController::class, 'store']);
Route::get('/profils/{id}/posts/{post_id}', [PostController::class, 'show']);
Route::put('/profils/{id}/posts/{post_id}', [PostController::class, 'update']);
Route::delete('/profils/{id}/posts/{post_id}', [PostController::class, 'destroy']);

Route::get('/posts/{id}/comments', [CommentController::class, 'index']);
Route::post('/posts/{id}/comments', [CommentController::class, 'store']);
Route::delete('/posts/{id}/comments/{comment_id}', [CommentController::class, 'destroy']);