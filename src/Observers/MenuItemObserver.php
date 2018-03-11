<?php

namespace InetStudio\Menu\Observers;

use InetStudio\Menu\Contracts\Models\MenuItemModelContract;
use InetStudio\Menu\Contracts\Observers\MenuItemObserverContract;

/**
 * Class MenuItemObserver.
 */
class MenuItemObserver implements MenuItemObserverContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    protected $services;

    /**
     * MenuItemObserver constructor.
     */
    public function __construct()
    {
        $this->services['menuItemsObserver'] = app()->make('InetStudio\Menu\Contracts\Services\Back\MenuItems\MenuItemsObserverServiceContract');
    }

    /**
     * Событие "объект создается".
     *
     * @param MenuItemModelContract $item
     */
    public function creating(MenuItemModelContract $item): void
    {
        $this->services['menuItemsObserver']->creating($item);
    }

    /**
     * Событие "объект создан".
     *
     * @param MenuItemModelContract $item
     */
    public function created(MenuItemModelContract $item): void
    {
        $this->services['menuItemsObserver']->created($item);
    }

    /**
     * Событие "объект обновляется".
     *
     * @param MenuItemModelContract $item
     */
    public function updating(MenuItemModelContract $item): void
    {
        $this->services['menuItemsObserver']->updating($item);
    }

    /**
     * Событие "объект обновлен".
     *
     * @param MenuItemModelContract $item
     */
    public function updated(MenuItemModelContract $item): void
    {
        $this->services['menuItemsObserver']->updated($item);
    }

    /**
     * Событие "объект подписки удаляется".
     *
     * @param MenuItemModelContract $item
     */
    public function deleting(MenuItemModelContract $item): void
    {
        $this->services['menuItemsObserver']->deleting($item);
    }

    /**
     * Событие "объект удален".
     *
     * @param MenuItemModelContract $item
     */
    public function deleted(MenuItemModelContract $item): void
    {
        $this->services['menuItemsObserver']->deleted($item);
    }
}
