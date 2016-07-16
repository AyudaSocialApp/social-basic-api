<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where all API routes are defined.
|
*/


Route::post('login', 'SesionAPIController@store');

Route::get('logout', 'SesionAPIController@destroy');

Route::post('register/{rol}', 'UserAPIController@register');


Route::resource('typeneedies', 'TypeneedyAPIController');

Route::get('typeneedies_e/familytype', 'TypeneedyAPIController@getFamilyType');


Route::resource('ideas', 'IdeasAPIController');

Route::get('ideas_e/showwithuser/{id}', 'IdeasAPIController@showWithUser');

Route::resource('typeidentifications', 'TypeidentificationAPIController');

Route::resource('typecontributors', 'TypecontributorAPIController');

Route::resource('typehelps', 'TypehelpAPIController');

Route::resource('needies', 'NeedyAPIController');





Route::resource('contributors', 'ContributorAPIController');

Route::resource('helps', 'HelpAPIController');





Route::group(['middleware' => ['before' => 'jwt.auth']], function () {

  Route::resource('images', 'ImageAPIController');
  Route::resource('examples', 'ExampleAPIController');

});

