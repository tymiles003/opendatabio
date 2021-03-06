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
| REMEMBER: always place the more specific rules BEFORE resources
*/

# Landing page
Route::get('/', 'WelcomeController@index');
# Setting the locale:
Route::get('welcome/{locale}', 'WelcomeController@setAppLocale');

# Default auth routes
Auth::routes();
# Users can update their own data
Route::get('/selfedit', 'Auth\SelfEditController@selfedit')->name('selfedit');
Route::put('/selfupdate', 'Auth\SelfEditController@selfupdate')->name('selfupdate');

# Home controller (for logged in users?)
Route::get('/home', 'HomeController@index')->name('home');
# Resources:
Route::get('persons/getdata', 'PersonController@getdata');
Route::resource('persons', 'PersonController');
Route::resource('userjobs', 'UserJobsController', ['only' => ['index', 'show', 'destroy']]);
Route::post('userjobs/{userjob}/retry', 'UserJobsController@retry');
Route::post('userjobs/{userjob}/cancel', 'UserJobsController@cancel');
Route::get('references/getdata', 'BibReferenceController@getdata');
Route::resource('references', 'BibReferenceController');
Route::post('herbaria/checkih', 'HerbariumController@checkih')->name('checkih');
Route::resource('herbaria', 'HerbariumController', ['only' => ['index', 'show', 'store', 'destroy']]);
Route::resource('locations', 'LocationController');
Route::post('taxons/checkapis', 'TaxonController@checkapis')->name('checkapis');
Route::resource('taxons', 'TaxonController');
Route::resource('projects', 'ProjectController');
Route::resource('plants', 'PlantController');
# Users can be resources for the admin
Route::resource('users', 'UserController', ['only' => ['index', 'show', 'edit', 'update', 'destroy']]);

