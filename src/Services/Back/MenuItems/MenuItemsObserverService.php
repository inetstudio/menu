<?php

namespace InetStudio\Menu\Services\Back\MenuItems;

use InetStudio\Menu\Contracts\Models\MenuItemModelContract;
use InetStudio\Menu\Contracts\Repositories\MenuItemsRepositoryContract;
use InetStudio\Menu\Contracts\Services\Back\MenuItems\MenuItemsObserverServiceContract;

/**
 * Class MenuItemsObserverService.
 */
class MenuItemsObserverService implements MenuItemsObserverServiceContract
{
    /**
     * @var MenuItemsRepositoryContract
     */
    private $repository;

    /**
     * MenuItemsObserverService constructor.
     *
     * @param MenuItemsRepositoryContract $repository
     */
    public function __construct(MenuItemsRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Событие "объект создается".
     *
     * @param MenuItemModelContract $item
     */
    public function creating(MenuItemModelContract $item): void
    {
    }

    /**
     * Событие "объект создан".
     *
     * @param MenuItemModelContract $item
     */
    public function created(MenuItemModelContract $item): void
    {
    }

    /**
     * Событие "объект обновляется".
     *
     * @param MenuItemModelContract $item
     */
    public function updating(MenuItemModelContract $item): void
    {
    }

    /**
     * Событие "объект обновлен".
     *
     * @param MenuItemModelContract $item
     */
    public function updated(MenuItemModelContract $item): void
    {
    }

    /**
     * Событие "объект подписки удаляется".
     *
     * @param MenuItemModelContract $item
     */
    public function deleting(MenuItemModelContract $item): void
    {
    }

    /**
     * Событие "объект удален".
     *
     * @param MenuItemModelContract $item
     */
    public function deleted(MenuItemModelContract $item): void
    {
    }
}
