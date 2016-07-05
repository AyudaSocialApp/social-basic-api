<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where all API routes are defined.
|
*/



Route::resource('typeneedies', 'TypeneedyAPIController');

Route::get('typeneedies_e/familytype', 'TypeneedyAPIController@getFamilyType');


Route::resource('ideas', 'IdeasAPIController');

Route::get('ideas_e/showwithuser/{id}', 'IdeasAPIController@showWithUser');

Route::resource('typeidentifications', 'TypeidentificationAPIController');

Route::resource('typecontributors', 'TypecontributorAPIController');

Route::resource('typehelps', 'TypehelpAPIController');

Route::resource('needies', 'NeedyAPIController');

Route::resource('images', 'ImageAPIController');

Route::resource('contributors', 'ContributorAPIController');

Route::resource('helps', 'HelpAPIController');