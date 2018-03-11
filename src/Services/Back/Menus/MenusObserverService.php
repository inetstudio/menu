<?php

namespace InetStudio\Menu\Services\Back\Menus;

use InetStudio\Menu\Contracts\Models\MenuModelContract;
use InetStudio\Menu\Contracts\Repositories\MenusRepositoryContract;
use InetStudio\Menu\Contracts\Services\Back\Menus\MenusObserverServiceContract;

/**
 * Class MenusObserverService.
 */
class MenusObserverService implements MenusObserverServiceContract
{
    /**
     * @var MenusRepositoryContract
     */
    private $repository;

    /**
     * MenusObserverService constructor.
     *
     * @param MenusRepositoryContract $repository
     */
    public function __construct(MenusRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Событие "объект создается".
     *
     * @param MenuModelContract $item
     */
    public function creating(MenuModelContract $item): void
    {
    }

    /**
     * Событие "объект создан".
     *
     * @param MenuModelContract $item
     */
    public function created(MenuModelContract $item): void
    {
    }

    /**
     * Событие "объект обновляется".
     *
     * @param MenuModelContract $item
     */
    public function updating(MenuModelContract $item): void
    {
    }

    /**
     * Событие "объект обновлен".
     *
     * @param MenuModelContract $item
     */
    public function updated(MenuModelContract $item): void
    {
    }

    /**
     * Событие "объект подписки удаляется".
     *
     * @param MenuModelContract $item
     */
    public function deleting(MenuModelContract $item): void
    {
    }

    /**
     * Событие "объект удален".
     *
     * @param MenuModelContract $item
     */
    public function deleted(MenuModelContract $item): void
    {
    }
}
