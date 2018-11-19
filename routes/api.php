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

Route::group(["middleware" => "api"], function () {
    Route::post("/login", "AuthController@login");
    Route::post("/signup", "AuthController@createUser");
});

Route::group(["middleware" => "auth"], function () {
    Route::get("/me", "AuthController@me");
    Route::get("/logout", "AuthController@logout");
    Route::get("/init", "DataController@init");
    Route::get("/read/{id}", "DataController@read");
    Route::post("/create", "DataController@create");
    Route::patch("/update", "DataController@update");
    Route::delete("/delete/{id}", "DataController@delete");
    
});