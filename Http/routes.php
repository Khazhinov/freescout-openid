<?php

Route::group(['middleware' => 'web',
    'prefix' => \Helper::getSubdirectory(),
    'namespace' => 'Modules\OpenID\Http\Controllers'], function()
{
    Route::get('/openid_callback', 'OpenIDController@index')->name('openid_callback');
});
