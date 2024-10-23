<?php

use App\Middlewares\Route;

Route::get('/', function() {
    \App\Middlewares\JsonResponse::handle(['message' => 'Hello World!']);
});

Route::get('/api/users', 'App\Controllers\Api\UserApiController@index'); // Для получения всех пользователей
Route::get('/api/users/{id}', 'App\Controllers\Api\UserApiController@show'); // Для получения одного конкретного пользователя по ID
Route::post('/api/users', 'App\Controllers\Api\UserApiController@store'); // Для регистрации/создания пользователя
Route::patch('/api/users/{id}', 'App\Controllers\Api\UserApiController@update'); // Для обновления данных о пользователе
Route::delete('/api/users/{id}', 'App\Controllers\Api\UserApiController@destroy'); // Для удаления пользователя

// Роут для авторизации пользователя
Route::post('/api/auth/login', 'App\Controllers\Api\UserAuthController@authorization');

Route::match();