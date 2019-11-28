<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/projects', 'Api\ProjectsController@index');

Route::middleware('auth:api')->get('/projects/{id}', 'Api\ProjectsController@show');
Route::middleware('auth:api')->get('/todolists/{id}', 'Api\TodolistsController@show');

Route::middleware('auth:api')->post('/projects', 'Api\ProjectsController@store');
Route::middleware('auth:api')->post('/todolists', 'Api\TodolistsController@store');
Route::middleware('auth:api')->post('/lists', 'Api\ListsController@store');
Route::middleware('auth:api')->post('/tasks', 'Api\TasksController@store');

Route::middleware('auth:api')->get('/teams', 'Api\TeamsController@index');
Route::middleware('auth:api')->post('/teams', 'Api\TeamsController@store');

Route::middleware('auth:api')->put('/projects/{id}', 'Api\ProjectsController@update');
Route::middleware('auth:api')->put('/todolists/{id}', 'Api\TodolistsController@update');

Route::middleware('auth:api')->delete('/projects/{id}', 'Api\ProjectsController@destroy');

Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');
