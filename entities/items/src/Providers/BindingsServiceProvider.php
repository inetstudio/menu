<?php

namespace InetStudio\MenusPackage\Items\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

/**
 * Class BindingsServiceProvider.
 */
class BindingsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
    * @var  array
    */
    public $bindings = [
        'InetStudio\MenusPackage\Items\Contracts\Models\ItemModelContract' => 'InetStudio\MenusPackage\Items\Models\ItemModel',
        'InetStudio\MenusPackage\Items\Contracts\Services\Back\ItemsServiceContract' => 'InetStudio\MenusPackage\Items\Services\Back\ItemsService',
        'InetStudio\MenusPackage\Items\Contracts\Transformers\Back\PrepareItemsTransformerContract' => 'InetStudio\MenusPackage\Items\Transformers\Back\PrepareItemsTransformer',
        'InetStudio\MenusPackage\Items\Contracts\Transformers\Back\TreeTransformerContract' => 'InetStudio\MenusPackage\Items\Transformers\Back\TreeTransformer',
        'InetStudio\MenusPackage\Items\Contracts\Transformers\Front\TreeTransformerContract' => 'InetStudio\MenusPackage\Items\Transformers\Front\TreeTransformer',
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
