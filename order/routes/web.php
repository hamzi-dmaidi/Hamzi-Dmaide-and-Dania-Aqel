<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) { // this appears when open order server
    return response()->json(['Message' =>'Order Server']);
});
$router->group(['prefix' => 'buy'] , function($router){ // to do buy put, buy/id 
	$router->get('{id}' , 'OrderController@buy'); // go to buybook function on ordercontroller
});