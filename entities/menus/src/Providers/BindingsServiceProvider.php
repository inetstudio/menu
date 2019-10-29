<?php

namespace InetStudio\MenusPackage\Menus\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class BindingsServiceProvider.
 */
class BindingsServiceProvider extends BaseServiceProvider implements DeferrableProvider
{
    /**
     * @var  array
     */
    public $bindings = [
        'InetStudio\MenusPackage\Menus\Contracts\Events\Back\ModifyItemEventContract' => 'InetStudio\MenusPackage\Menus\Events\Back\ModifyItemEvent',
        'InetStudio\MenusPackage\Menus\Contracts\Http\Controllers\Back\DataControllerContract' => 'InetStudio\MenusPackage\Menus\Http\Controllers\Back\DataController',
        'InetStudio\MenusPackage\Menus\Contracts\Http\Controllers\Back\ResourceControllerContract' => 'InetStudio\MenusPackage\Menus\Http\Controllers\Back\ResourceController',
        'InetStudio\MenusPackage\Menus\Contracts\Http\Requests\Back\SaveItemRequestContract' => 'InetStudio\MenusPackage\Menus\Http\Requests\Back\SaveItemRequest',
        'InetStudio\MenusPackage\Menus\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract' => 'InetStudio\MenusPackage\Menus\Http\Responses\Back\Data\GetIndexDataResponse',
        'InetStudio\MenusPackage\Menus\Contracts\Http\Responses\Back\Resource\CreateResponseContract' => 'InetStudio\MenusPackage\Menus\Http\Responses\Back\Resource\CreateResponse',
        'InetStudio\MenusPackage\Menus\Contracts\Http\Responses\Back\Resource\DestroyResponseContract' => 'InetStudio\MenusPackage\Menus\Http\Responses\Back\Resource\DestroyResponse',
        'InetStudio\MenusPackage\Menus\Contracts\Http\Responses\Back\Resource\EditResponseContract' => 'InetStudio\MenusPackage\Menus\Http\Responses\Back\Resource\EditResponse',
        'InetStudio\MenusPackage\Menus\Contracts\Http\Responses\Back\Resource\IndexResponseContract' => 'InetStudio\MenusPackage\Menus\Http\Responses\Back\Resource\IndexResponse',
        'InetStudio\MenusPackage\Menus\Contracts\Http\Responses\Back\Resource\SaveResponseContract' => 'InetStudio\MenusPackage\Menus\Http\Responses\Back\Resource\SaveResponse',
        'InetStudio\MenusPackage\Menus\Contracts\Http\Responses\Back\Resource\ShowResponseContract' => 'InetStudio\MenusPackage\Menus\Http\Responses\Back\Resource\ShowResponse',
        'InetStudio\MenusPackage\Menus\Contracts\Models\MenuModelContract' => 'InetStudio\MenusPackage\Menus\Models\MenuModel',
        'InetStudio\MenusPackage\Menus\Contracts\Services\Back\DataTables\IndexServiceContract' => 'InetStudio\MenusPackage\Menus\Services\Back\DataTables\IndexService',
        'InetStudio\MenusPackage\Menus\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\MenusPackage\Menus\Services\Back\ItemsService',
        'InetStudio\MenusPackage\Menus\Contracts\Services\Front\ItemsServiceContract' => 'InetStudio\MenusPackage\Menus\Services\Front\ItemsService',
        'InetStudio\MenusPackage\Menus\Contracts\Transformers\Back\Resource\IndexTransformerContract' => 'InetStudio\MenusPackage\Menus\Transformers\Back\Resource\IndexTransformer',
    ];

    /**
     * Получить сервисы от провайдера.
     *
     * @return  array
     */
    public function provides()
    {
        return array_keys($this->bindings);
    }
}
