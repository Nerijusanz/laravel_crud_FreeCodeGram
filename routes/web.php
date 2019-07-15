<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Mail\registerUserMail;

Route::get('/','PostsController@index');

Auth::routes();

Route::get('/email',function(){
    return new registerUserMail();
});

//Profile
Route::get('/profiles', 'ProfilesController@index');
Route::get('/profiles/{id}', 'ProfilesController@show');


//Follow
Route::post('/follow/{id}','FollowController@store'); //Vue FollowButton component axios call


//Posts
Route::get('/posts','PostsController@index');
Route::get('/posts/create','PostsController@create');
Route::post('/posts','PostsController@store');
Route::get('/posts/{id}','PostsController@show');
Route::get('/posts/{id}/edit','PostsController@edit');
Route::put('/posts/{id}','PostsController@update');
Route::delete('/posts/{id}','PostsController@destroy');

Route::get('/roles',function(){
    
    $user = \App\User::find(1);

    $roles = \App\Role::all();

    $user->roles()->sync($roles);
    //$user->roles()->sync([1,2,3]);
    //$user->roles()->syncWithoutDetaching([1,2,3]);
    //$user->roles()->attach($roles);
    //$user->roles()->detach([1,2]);
    

    return 'roles';

});