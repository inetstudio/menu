<?php

Route::group([
    'namespace' => 'InetStudio\Menu\Contracts\Http\Controllers\Back',
    'middleware' => ['web', 'back.auth'],
    'prefix' => 'back',
], function () {
    Route::any('menu/data', 'MenusDataControllerContract@data')->name('back.menu.data.index');
    Route::post('menu/move', 'MenusUtilityControllerContract@move')->name('back.menu.move');
    Route::resource('menu', 'MenusControllerContract', ['except' => [
        'show',
    ], 'as' => 'back']);
});
