<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();  /* crea le rotte relative all'autenticazione, ovvero login/logout e register */

// Route::get('/home', 'HomeController@index')->name('home');  /* rotta raggiungibile da tutti */


/* rotta raggiungibile solo da /admin */
Route::middleware('auth')
->namespace('Admin') /* con questo diciamo dove devono puntare i vari Controllers */
->name('admin.')  /* base della rotta con dot notation da anteporre ai percorsi nel group */
->prefix('admin')
->group(function() { /* group() applica tutte le precedenti alle rotte definite dentro la sua function */
    Route::get("/", 'HomeController@index')->name('home'); /* indirizzo qui viene aggiunto a /admin */
    Route::get('/posts/{post:slug}', 'PostController@show' )->name('posts.show');  /* ha la precedenza sul successivo che è resource */
    Route::resource("/posts", 'PostController');
}); 

/* i controller resource non permettono di definire cose in modo personalizzato, come ad es. lo slug al posto dell'id */


Route::get('/posts/{post:slug}', function (Post $post) {
    return $post;
});


