<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

/**
 * Controla as actions na sessão para manipular os menus ativos automaticamente
 * 
 */
RouteBuilder::buildSmartUrl();

/* -@- Middleware de autenticação -@- */
Route::group(['middleware' => 'auth'], function () {
    
    /* @DEFAULT-CONTROLLER */
    Route::any('/',              'DefaultController@index');
    Route::any('/default/index', 'DefaultController@index');
    Route::any('/index',         'DefaultController@index');
    
    /* @LOGIN-CONTROLLER */
    Route::any('/login/logout', 'LoginController@logout');
    Route::any('/logout',       'LoginController@logout');
    
    /* @PARAMETROS-CONTROLLER */
    Route::get('/parametros/configurar',   'ParametrosController@configurar');
    Route::get('/parametros/alterarValor', 'ParametrosController@alterarValor');
    
    /* @PERMISSOES-CONTROLLER */
    Route::group(['prefix' => 'permissoes'], function () {
        Route::get('/salvarPermissoes', 'PermissoesController@salvarPermissoes');
    });
    
    /* @USERS-CONTROLLER */
    Route::group(['prefix' => 'users'], function () {
        Route::get('/index',            'UsersController@index');
        Route::get('/form/{id?}',       'UsersController@form');
        Route::get('/consultar',        'UsersController@consultar');
        Route::get('/show/{id}',        'UsersController@show');
        Route::get('/destroy/{id}',     'UsersController@destroy');
        Route::post('/save',            'UsersController@save');
        Route::post('/alterarPerfil',   'UsersController@alterarPerfil');
        Route::any('/trocarSenha/{id}', 'UsersController@trocarSenha');
        Route::any('/recuperarSenha',   'UsersController@recuperarSenha');
    });
    
    /* @PERFIS-CONTROLLER */
    Route::group(['prefix' => 'perfis'], function () {
        Route::get('/index',            'PerfisController@index');
        Route::get('/form/{id?}',       'PerfisController@form');
        Route::get('/consultar',        'PerfisController@consultar');
        Route::get('/show/{id}',        'PerfisController@show');
        Route::get('/destroy/{id}',     'PerfisController@destroy');
        Route::post('/save',            'PerfisController@save');
        Route::get('/listarPermissoes', 'PerfisController@listarPermissoes');
    });
});

/* @LOGIN-CONTROLLER */
Route::any('/login', 'LoginController@loginUser');
Route::any('/users/recuperarSenha', 'UsersController@recuperarSenha');

/* @MANUAL */
Route::get('/manual', function () { return view('manual.index'); });