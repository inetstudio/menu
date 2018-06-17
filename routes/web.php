<?php

Route::group([
    'namespace' => 'InetStudio\Menu\Contracts\Http\Controllers\Back',
    'middleware' => ['web', 'back.auth'],
    'prefix' => 'back',
], function () {
    Route::any('menu/data', 'MenusDataControllerContract@data')->name('back.menu.data.index');
    Route::resource('menu', 'MenusControllerContract', ['except' => [
        'show',
    ], 'as' => 'back']);
});
