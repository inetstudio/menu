<?php

namespace InetStudio\Menu\Repositories;

use Illuminate\Support\Collection;
use InetStudio\AdminPanel\Repositories\BaseRepository;
use InetStudio\Menu\Contracts\Models\MenuItemModelContract;
use InetStudio\Menu\Contracts\Repositories\MenuItemsRepositoryContract;

/**
 * Class MenuItemsRepository.
 */
class MenuItemsRepository extends BaseRepository implements MenuItemsRepositoryContract
{
    /**
     * MenuItemsRepository constructor.
     *
     * @param MenuItemModelContract $model
     */
    public function __construct(MenuItemModelContract $model)
    {
        $this->model = $model;

        $this->defaultColumns = ['id', 'menu_id', 'additional_info', '_lft', '_rgt', 'parent_id'];
        $this->relations = [];
    }

    /**
     * Удаляем объекты из меню за исключением переданных.
     *
     * @param int $menuID
     * @param array $itemsIDs
     * @param array $params
     *
     * @return bool
     */
    public function destroyFromMenuExcept(int $menuID, array $itemsIDs, array $params)
    {
        return $this->getItemsQuery($params)
            ->where('menu_id', $menuID)
            ->whereNotIn('id', $itemsIDs)
            ->delete();
    }

    /**
     * Добавляем объект в дерево.
     *
     * @param $id
     * @param int $parentID
     *
     * @return MenuItemModelContract
     */
    public function addToTree($id, $parentID): MenuItemModelContract
    {
        $item = $this->getItemByID($id);
        $parent = $this->getItemByID($parentID);

        if (! $parent->id) {
            $item->saveAsRoot();
        } else {
            $item->appendToNode($parent)->save();
        }

        return $item;
    }

    /**
     * Перестраиваем дерево объектов.
     *
     * @param array $data
     *
     * @return int
     */
    public function rebuildTree(array $data): int
    {
        return $this->model::defaultOrder()->rebuildTree($data);
    }

    /**
     * Получаем дерево объектов.
     *
     * @param int $menuId
     * @param array $params
     *
     * @return Collection
     */
    public function getTree(int $menuId, array $params = []): Collection
    {
        $builder = $this->getItemsQuery($params)
            ->where('menu_id', $menuId)
            ->defaultOrder();

        $items = $builder->get()->toTree();

        return $items;
    }
}
