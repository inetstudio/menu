<?php

namespace InetStudio\Menu\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class MenuBindingsServiceProvider.
 */
class MenuBindingsServiceProvider extends ServiceProvider
{
    /**
    * @var  bool
    */
    protected $defer = true;

    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\Menu\Contracts\Events\Back\ModifyMenuEventContract' => 'InetStudio\Menu\Events\Back\ModifyMenuEvent',
        'InetStudio\Menu\Contracts\Http\Controllers\Back\MenusControllerContract' => 'InetStudio\Menu\Http\Controllers\Back\MenusController',
        'InetStudio\Menu\Contracts\Http\Controllers\Back\MenusDataControllerContract' => 'InetStudio\Menu\Http\Controllers\Back\MenusDataController',
        'InetStudio\Menu\Contracts\Http\Requests\Back\SaveMenuRequestContract' => 'InetStudio\Menu\Http\Requests\Back\SaveMenuRequest',
        'InetStudio\Menu\Contracts\Http\Responses\Back\Menus\DestroyResponseContract' => 'InetStudio\Menu\Http\Responses\Back\Menus\DestroyResponse',
        'InetStudio\Menu\Contracts\Http\Responses\Back\Menus\FormResponseContract' => 'InetStudio\Menu\Http\Responses\Back\Menus\FormResponse',
        'InetStudio\Menu\Contracts\Http\Responses\Back\Menus\IndexResponseContract' => 'InetStudio\Menu\Http\Responses\Back\Menus\IndexResponse',
        'InetStudio\Menu\Contracts\Http\Responses\Back\Menus\SaveResponseContract' => 'InetStudio\Menu\Http\Responses\Back\Menus\SaveResponse',
        'InetStudio\Menu\Contracts\Models\MenuItemModelContract' => 'InetStudio\Menu\Models\MenuItemModel',
        'InetStudio\Menu\Contracts\Models\MenuModelContract' => 'InetStudio\Menu\Models\MenuModel',
        'InetStudio\Menu\Contracts\Repositories\MenuItemsRepositoryContract' => 'InetStudio\Menu\Repositories\MenuItemsRepository',
        'InetStudio\Menu\Contracts\Repositories\MenusRepositoryContract' => 'InetStudio\Menu\Repositories\MenusRepository',
        'InetStudio\Menu\Contracts\Services\Back\MenuItems\MenuItemsServiceContract' => 'InetStudio\Menu\Services\Back\MenuItems\MenuItemsService',
        'InetStudio\Menu\Contracts\Services\Back\Menus\MenusDataTableServiceContract' => 'InetStudio\Menu\Services\Back\Menus\MenusDataTableService',
        'InetStudio\Menu\Contracts\Services\Back\Menus\MenusServiceContract' => 'InetStudio\Menu\Services\Back\Menus\MenusService',
        'InetStudio\Menu\Contracts\Services\Front\MenusServiceContract' => 'InetStudio\Menu\Services\Front\MenusService',
        'InetStudio\Menu\Contracts\Transformers\Back\MenuTransformerContract' => 'InetStudio\Menu\Transformers\Back\MenuTransformer',
        'InetStudio\Menu\Contracts\Transformers\Back\PrepareMenuItemsTransformerContract' => 'InetStudio\Menu\Transformers\Back\PrepareMenuItemsTransformer',
        'InetStudio\Menu\Contracts\Transformers\Back\TreeTransformerContract' => 'InetStudio\Menu\Transformers\Back\TreeTransformer',
        'InetStudio\Menu\Contracts\Transformers\Front\TreeTransformerContract' => 'InetStudio\Menu\Transformers\Front\TreeTransformer',
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
