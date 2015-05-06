<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

$app->get('/', function() use ($app) {
    return $app->welcome();
});
$app->group(['prefix'=>'api/v1'],function() use ($app){

   // $app->group(['middleware' => 'token'],function() use ($app){

    $app->get('/voters', 'App\Http\Controllers\ApiController@index');
    $app->get('/voters/{registrationId}/contacts', 'App\Http\Controllers\ApiController@contacts');

    $app->post('/voters','App\Http\Controllers\ApiController@syncVoters');
    $app->post('/contacts','App\Http\Controllers\ApiController@syncContacts');
    $app->get('/activities', 'App\Http\Controllers\ApiController@activities');
    $app->get('/users', 'App\Http\Controllers\ApiController@users');



    });
//});