<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where all API routes are defined.
|
*/

Route::get('token', 'App\Http\Controllers\Auth\AuthController@token');

Route::post('login', 'SesionAPIController@store');

Route::get('logout', 'SesionAPIController@destroy');

Route::post('register/{rol}', 'UserAPIController@register');

Route::post('edit_register/{rol}', 'UserAPIController@editRegister');

Route::get('validate_user/{user}', 'UserAPIController@validateRepeatUser');

Route::resource('typeneedies', 'TypeneedyAPIController');

Route::get('typeneedies_e/familytype', 'TypeneedyAPIController@getFamilyType');


Route::resource('typeidentifications', 'TypeidentificationAPIController');

Route::resource('typecontributors', 'TypecontributorAPIController');

Route::resource('typehelps', 'TypehelpAPIController');

Route::resource('needies', 'NeedyAPIController'); // algunas tienen restricción.

Route::resource('contributors', 'ContributorAPIController'); // algunas tienen restricción.


Route::group(['middleware' => ['before' => 'jwt.auth']], function () {

  Route::resource('images', 'ImageAPIController');
  Route::resource('examples', 'ExampleAPIController');
  Route::resource('helps', 'HelpAPIController'); 
  Route::resource('ideas', 'IdeasAPIController');
  Route::get('ideas_e/showwithuser/{id}', 'IdeasAPIController@showWithUser');

});

