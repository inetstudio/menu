<?php

namespace InetStudio\Menu\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class MenuServiceProvider.
 */
class MenuServiceProvider extends ServiceProvider
{
    /**
     * Загрузка сервиса.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerConsoleCommands();
        $this->registerPublishes();
        $this->registerRoutes();
        $this->registerViews();
        $this->registerObservers();
    }

    /**
     * Регистрация привязки в контейнере.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerBindings();
    }

    /**
     * Регистрация команд.
     *
     * @return void
     */
    protected function registerConsoleCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                'InetStudio\Menu\Console\Commands\SetupCommand',
            ]);
        }
    }

    /**
     * Регистрация ресурсов.
     *
     * @return void
     */
    protected function registerPublishes(): void
    {
        $this->publishes([
            __DIR__.'/../../config/menu.php' => config_path('menu.php'),
        ], 'config');

        if ($this->app->runningInConsole()) {
            if (! class_exists('CreateMenuTables')) {
                $timestamp = date('Y_m_d_His', time());
                $this->publishes([
                    __DIR__.'/../../database/migrations/create_menu_tables.php.stub' => database_path('migrations/'.$timestamp.'_create_menu_tables.php'),
                ], 'migrations');
            }
        }
    }

    /**
     * Регистрация путей.
     *
     * @return void
     */
    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }

    /**
     * Регистрация представлений.
     *
     * @return void
     */
    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'admin.module.menu');
    }

    /**
     * Регистрация наблюдателей.
     *
     * @return void
     */
    public function registerObservers(): void
    {
        $this->app->make('InetStudio\Menu\Contracts\Models\MenuModelContract')::observe($this->app->make('InetStudio\Menu\Contracts\Observers\MenuObserverContract'));
        $this->app->make('InetStudio\Menu\Contracts\Models\MenuItemModelContract')::observe($this->app->make('InetStudio\Menu\Contracts\Observers\MenuItemObserverContract'));
    }

    /**
     * Регистрация привязок, алиасов и сторонних провайдеров сервисов.
     *
     * @return void
     */
    public function registerBindings(): void
    {
        // Controllers
        $this->app->bind('InetStudio\Menu\Contracts\Http\Controllers\Back\MenusControllerContract', 'InetStudio\Menu\Http\Controllers\Back\MenusController');
        $this->app->bind('InetStudio\Menu\Contracts\Http\Controllers\Back\MenusDataControllerContract', 'InetStudio\Menu\Http\Controllers\Back\MenusDataController');

        // Events
        $this->app->bind('InetStudio\Menu\Contracts\Events\Back\ModifyMenuEventContract', 'InetStudio\Menu\Events\Back\ModifyMenuEvent');

        // Models
        $this->app->bind('InetStudio\Menu\Contracts\Models\MenuModelContract', 'InetStudio\Menu\Models\MenuModel');
        $this->app->bind('InetStudio\Menu\Contracts\Models\MenuItemModelContract', 'InetStudio\Menu\Models\MenuItemModel');

        // Observers
        $this->app->bind('InetStudio\Menu\Contracts\Observers\MenuObserverContract', 'InetStudio\Menu\Observers\MenuObserver');
        $this->app->bind('InetStudio\Menu\Contracts\Observers\MenuItemObserverContract', 'InetStudio\Menu\Observers\MenuItemObserver');

        // Repositories
        $this->app->bind('InetStudio\Menu\Contracts\Repositories\MenusRepositoryContract', 'InetStudio\Menu\Repositories\MenusRepository');
        $this->app->bind('InetStudio\Menu\Contracts\Repositories\MenuItemsRepositoryContract', 'InetStudio\Menu\Repositories\MenuItemsRepository');

        // Requests
        $this->app->bind('InetStudio\Menu\Contracts\Http\Requests\Back\SaveMenuRequestContract', 'InetStudio\Menu\Http\Requests\Back\SaveMenuRequest');

        // Responses
        $this->app->bind('InetStudio\Menu\Contracts\Http\Responses\Back\Menus\DestroyResponseContract', 'InetStudio\Menu\Http\Responses\Back\Menus\DestroyResponse');
        $this->app->bind('InetStudio\Menu\Contracts\Http\Responses\Back\Menus\FormResponseContract', 'InetStudio\Menu\Http\Responses\Back\Menus\FormResponse');
        $this->app->bind('InetStudio\Menu\Contracts\Http\Responses\Back\Menus\IndexResponseContract', 'InetStudio\Menu\Http\Responses\Back\Menus\IndexResponse');
        $this->app->bind('InetStudio\Menu\Contracts\Http\Responses\Back\Menus\SaveResponseContract', 'InetStudio\Menu\Http\Responses\Back\Menus\SaveResponse');

        // Services
        $this->app->bind('InetStudio\Menu\Contracts\Services\Back\Menus\MenusDataTableServiceContract', 'InetStudio\Menu\Services\Back\Menus\MenusDataTableService');
        $this->app->bind('InetStudio\Menu\Contracts\Services\Back\MenuItems\MenuItemsServiceContract', 'InetStudio\Menu\Services\Back\MenuItems\MenuItemsService');
        $this->app->bind('InetStudio\Menu\Contracts\Services\Back\Menus\MenusObserverServiceContract', 'InetStudio\Menu\Services\Back\Menus\MenusObserverService');
        $this->app->bind('InetStudio\Menu\Contracts\Services\Back\MenuItems\MenuItemsObserverServiceContract', 'InetStudio\Menu\Services\Back\MenuItems\MenuItemsObserverService');
        $this->app->bind('InetStudio\Menu\Contracts\Services\Back\Menus\MenusServiceContract', 'InetStudio\Menu\Services\Back\Menus\MenusService');
        $this->app->bind('InetStudio\Menu\Contracts\Services\Front\MenusServiceContract', 'InetStudio\Menu\Services\Front\MenusService');

        // Transformers
        $this->app->bind('InetStudio\Menu\Contracts\Transformers\Back\MenuTransformerContract', 'InetStudio\Menu\Transformers\Back\MenuTransformer');
        $this->app->bind('InetStudio\Menu\Contracts\Transformers\Back\PrepareMenuItemsTransformerContract', 'InetStudio\Menu\Transformers\Back\PrepareMenuItemsTransformer');
        $this->app->bind('InetStudio\Menu\Contracts\Transformers\Back\TreeTransformerContract', 'InetStudio\Menu\Transformers\Back\TreeTransformer');
        $this->app->bind('InetStudio\Menu\Contracts\Transformers\Front\TreeTransformerContract', 'InetStudio\Menu\Transformers\Front\TreeTransformer');
    }
}
