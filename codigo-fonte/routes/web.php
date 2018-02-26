<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/* ------------------- ROTAS AUTOMATIZADAS ------------------- */

/**
 * Controla as rotas automaticamente
 * @example Route::resource('{controller name}/{action}/{key}', '{controller name}Controller@{action}');
 * Seta variaveis no session para o ACTION, CONTROLLER e KEY
 */
Route::group(['middleware' => 'auth'], function () {
    RouteBuilder::buildSmartUrl();
});

/* ------------------- ROTAS ALTERNATIVAS -------------------- */
Route::any('/login', 'LoginController@loginUser');