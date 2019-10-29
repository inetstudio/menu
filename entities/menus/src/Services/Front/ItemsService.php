<?php

namespace InetStudio\MenusPackage\Menus\Services\Front;

use InetStudio\AdminPanel\Base\Services\BaseService;
use InetStudio\MenusPackage\Menus\Contracts\Models\MenuModelContract;
use InetStudio\MenusPackage\Menus\Contracts\Services\Front\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    public function __construct(MenuModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Возвращаем меню.
     *
     * @param string $alias
     * @param array $params
     *
     * @return array
     */
    public function getMenuTree(string $alias, array $params = []): array
    {
        $menu = $this->menusRepository->getItemByAlias($alias);
        $tree = ($menu) ? $this->menuItemsRepository->getTree($menu->id, $params) : [];

        $resource = (app()->make('InetStudio\MenusPackage\Menus\Contracts\Transformers\Front\TreeTransformerContract'))
            ->transformCollection($tree);

        return $this->dataManager->createData($resource)->toArray();
    }
}
