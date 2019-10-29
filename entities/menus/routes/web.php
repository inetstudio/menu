<?php

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'namespace' => 'InetStudio\MenusPackage\Menus\Contracts\Http\Controllers\Back',
        'middleware' => ['web', 'back.auth'],
        'prefix' => 'back/menus-package',
    ],
    function () {
        Route::any('menus/data', 'DataControllerContract@getIndexData')->name('back.menus-package.menus.data.index');

        Route::resource(
            'menus',
            'ResourceControllerContract',
            [
                'as' => 'back.menus-package'
            ]
        );
    }
);
