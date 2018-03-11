<?php

namespace InetStudio\Menu\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use InetStudio\Menu\Contracts\Models\MenuItemModelContract;
use InetStudio\Menu\Contracts\Repositories\MenuItemsRepositoryContract;

/**
 * Class MenuItemsRepository.
 */
class MenuItemsRepository implements MenuItemsRepositoryContract
{
    /**
     * @var MenuItemModelContract
     */
    private $model;

    /**
     * MenuItemsRepository constructor.
     *
     * @param MenuItemModelContract $model
     */
    public function __construct(MenuItemModelContract $model)
    {
        $this->model = $model;
    }

    /**
     * Возвращаем объект по id, либо создаем новый.
     *
     * @param $id
     *
     * @return MenuItemModelContract
     */
    public function getItemByID($id): MenuItemModelContract
    {
        return $this->model::find($id) ?? new $this->model;
    }

    /**
     * Возвращаем объекты по списку id.
     *
     * @param $ids
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getItemsByIDs($ids, bool $returnBuilder = false)
    {
        $builder = $this->getItemsQuery()->whereIn('id', (array) $ids);

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
    }

    /**
     * Сохраняем объект.
     *
     * @param array $data
     * @param $id
     *
     * @return MenuItemModelContract
     */
    public function save(array $data, $id): MenuItemModelContract
    {
        $item = $this->getItemByID($id);

        $item->fill($data);
        $item->save();

        return $item;
    }

    /**
     * Удаляем объект.
     *
     * @param $id
     *
     * @return bool
     */
    public function destroy($id): ?bool
    {
        return $this->getItemByID($id)->delete();
    }

    /**
     * Удаляем объекты из меню за исключением переданных.
     *
     * @param $menuID
     * @param $itemsIDs
     *
     * @return bool
     */
    public function destroyFromMenuExcept($menuID, $itemsIDs)
    {
        return $this->model::where('menu_id', $menuID)->whereNotIn('id', $itemsIDs)->delete();
    }

    /**
     * Ищем объекты.
     *
     * @param string $field
     * @param $value
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function searchItemsByField(string $field, string $value, bool $returnBuilder = false)
    {
        $builder = $this->getItemsQuery()->where($field, 'LIKE', '%'.$value.'%');

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
    }

    /**
     * Получаем все объекты.
     *
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getAllItems(bool $returnBuilder = false)
    {
        $builder = $this->getItemsQuery(['created_at', 'updated_at'], [])->orderBy('created_at', 'desc');

        if ($returnBuilder) {
            return $builder;
        }

        return $builder->get();
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
     * @param $menuId
     *
     * @return Collection
     */
    public function getTree($menuId): Collection
    {
        return $this->model::where('menu_id', $menuId)->defaultOrder()->get()->toTree();
    }

    /**
     * Возвращаем запрос на получение объектов.
     *
     * @param array $extColumns
     * @param array $with
     *
     * @return Builder
     */
    protected function getItemsQuery($extColumns = [], $with = []): Builder
    {
        $defaultColumns = ['id', 'name', 'alias'];

        $relations = [];

        return $this->model::select(array_merge($defaultColumns, $extColumns))
            ->with(array_intersect_key($relations, array_flip($with)));
    }
}
