<?php

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

/** @var \Laravel\Lumen\Routing\Router $router */

/** old
 *
$router->get('/', 'HomeController@index');
$router->get('/v1/users/{id}','V1\UserController@getById');
$router->post('/v1/users/{id}','V1\UserController@updateById');
 */

// shorten url
$router->post('/shorten', 'V2\V2ShortenController@addShorten');
$router->get('/shorten/{shortcode}', 'V2\V2ShortenController@getByShortcode');
$router->get('/shorten/{shortcode}/stats', 'V2\V2ShortenController@getStatusByShortcode');