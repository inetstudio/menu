<?php

namespace InetStudio\Menu\Services\Front;

use League\Fractal\Manager;
use InetStudio\AdminPanel\Serializers\SimpleDataArraySerializer;
use InetStudio\Menu\Contracts\Services\Front\MenusServiceContract;

/**
 * Class MenusService.
 */
class MenusService implements MenusServiceContract
{
    private $menusRepository;
    private $menuItemsRepository;
    private $dataManager;

    /**
     * MenusService constructor.
     */
    public function __construct()
    {
        $this->menusRepository = app()->make('InetStudio\Menu\Contracts\Repositories\MenusRepositoryContract');
        $this->menuItemsRepository = app()->make('InetStudio\Menu\Contracts\Repositories\MenuItemsRepositoryContract');

        $this->dataManager = new Manager();
        $this->dataManager->setSerializer(new SimpleDataArraySerializer());
    }

    /**
     * Возвращаем меню.
     *
     * @param string $alias
     *
     * @return array
     */
    public function getMenuTree(string $alias): array
    {
        $menu = $this->menusRepository->getItemByAlias($alias);
        $tree = ($menu) ? $this->menuItemsRepository->getTree($menu->id) : [];

        $resource = (app()->make('InetStudio\Menu\Contracts\Transformers\Front\TreeTransformerContract'))
            ->transformCollection($tree);

        return $this->dataManager->createData($resource)->toArray();
    }
}
