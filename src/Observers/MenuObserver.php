<?php

namespace InetStudio\Menu\Observers;

use InetStudio\Menu\Contracts\Models\MenuModelContract;
use InetStudio\Menu\Contracts\Observers\MenuObserverContract;

/**
 * Class MenuObserver.
 */
class MenuObserver implements MenuObserverContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    protected $services;

    /**
     * MenuObserver constructor.
     */
    public function __construct()
    {
        $this->services['menuObserver'] = app()->make('InetStudio\Menu\Contracts\Services\Back\Menus\MenusObserverServiceContract');
    }

    /**
     * Событие "объект создается".
     *
     * @param MenuModelContract $item
     */
    public function creating(MenuModelContract $item): void
    {
        $this->services['menuObserver']->creating($item);
    }

    /**
     * Событие "объект создан".
     *
     * @param MenuModelContract $item
     */
    public function created(MenuModelContract $item): void
    {
        $this->services['menuObserver']->created($item);
    }

    /**
     * Событие "объект обновляется".
     *
     * @param MenuModelContract $item
     */
    public function updating(MenuModelContract $item): void
    {
        $this->services['menuObserver']->updating($item);
    }

    /**
     * Событие "объект обновлен".
     *
     * @param MenuModelContract $item
     */
    public function updated(MenuModelContract $item): void
    {
        $this->services['menuObserver']->updated($item);
    }

    /**
     * Событие "объект подписки удаляется".
     *
     * @param MenuModelContract $item
     */
    public function deleting(MenuModelContract $item): void
    {
        $this->services['menuObserver']->deleting($item);
    }

    /**
     * Событие "объект удален".
     *
     * @param MenuModelContract $item
     */
    public function deleted(MenuModelContract $item): void
    {
        $this->services['menuObserver']->deleted($item);
    }
}
