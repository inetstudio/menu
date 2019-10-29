<?php

namespace InetStudio\MenusPackage\Items\Services\Back;

use Illuminate\Support\Arr;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\MenusPackage\Items\Contracts\Models\ItemModelContract;
use InetStudio\MenusPackage\Menus\Contracts\Models\MenuModelContract;
use InetStudio\MenusPackage\Items\Contracts\Services\Back\ItemsServiceContract;
use InetStudio\AdminPanel\Base\Contracts\Serializers\SimpleDataArraySerializerContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    protected $dataManager;

    /**
     * ItemsService constructor.
     *
     * @param  ItemModelContract  $model
     * @param  SimpleDataArraySerializerContract  $serializer
     */
    public function __construct(
        ItemModelContract $model,
        SimpleDataArraySerializerContract $serializer
    ) {
        parent::__construct($model);

        $this->dataManager = new Manager();
        $this->dataManager->setSerializer($serializer);
    }

    /**
     * Сохраняем пункт меню.
     *
     * @param $menuItemData
     * @param $parentId
     *
     * @return array
     */
    protected function save(&$menuItemData, $parentId): array
    {
        $itemsIds = [];

        $menuItemData['additional_info']['menuItem']['parent_id'] = $parentId;
        $menuItemData['parent_id'] = $parentId;

        $data = $menuItemData;
        Arr::forget($data, ['id', 'children', 'additional_info.action', 'additional_info.item']);

        $menuItem = $this->saveModel($data, $menuItemData['id']);

        $menuItemData['id'] = $menuItem['id'];
        $menuItemData['additional_info']['menuItem']['id'] = $menuItem['id'];
        $data['additional_info']['menuItem']['id'] = $menuItem['id'];

        $this->saveModel($data, $menuItem['id']);

        $menuItem = $this->addToTree($menuItem['id'], (int) $parentId);

        $itemsIds[] = $menuItem['id'];

        foreach ($menuItemData['children'] as &$child) {
            $itemsIds = array_merge($itemsIds, $this->save($child, $menuItem['id']));
        }

        return $itemsIds;
    }

    /**
     * Получаем дерево объектов.
     *
     * @param  int  $menuId
     * @param  array  $params
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function getTree(int $menuId, array $params = []): array
    {
        $tree = $this->model->buildQuery($params)
            ->where('menu_id', $menuId)
            ->defaultOrder()
            ->get()
            ->toTree();

        $resource = (app()->make('InetStudio\MenusPackage\Items\Contracts\Transformers\Back\TreeTransformerContract'))
            ->transformCollection($tree);

        return $this->dataManager->createData($resource)->toArray();
    }

    /**
     * Перестраиваем дерево объектов.
     *
     * @param  array  $data
     *
     * @return int
     */
    public function rebuildTree(array $data): int
    {
        $result = $this->model->defaultOrder()->rebuildTree($data);

        return $result;
    }

    /**
     * Добавляем объект в дерево.
     *
     * @param  $id
     * @param  int  $parentId
     *
     * @return ItemModelContract
     */
    public function addToTree($id, $parentId): ItemModelContract
    {
        $item = $this->getItemById($id);
        $parent = $this->getItemById($parentId);

        if (! $parent->id) {
            $item->saveAsRoot();
        } else {
            $item->appendToNode($parent)->save();
        }

        return $item;
    }

    /**
     * Присваиваем пункты меню к меню.
     *
     * @param  $items
     * @param  MenuModelContract  $menu
     */
    public function attachToObject($items, MenuModelContract $menu)
    {
        if ($items instanceof Request) {
            $items = collect(json_decode($items->get('menu_data'), true));
        } elseif (is_string($items)) {
            $items = collect(json_decode($items, true));
        } else {
            $items = collect((array) $items);
        }

        $resource = (
            app()->makeWith(
                'InetStudio\MenusPackage\Items\Contracts\Transformers\Back\PrepareItemsTransformerContract',
                [
                    'menuId' => $menu['id'],
                ]
            )
        )->transformCollection($items);

        $items = $this->dataManager->createData($resource)->toArray();

        $itemsIds = [];
        foreach ($items as &$menuItemData) {
            $itemsIds = array_merge($itemsIds, $this->save($menuItemData, null));
        }

        $this->destroyExcept($menu['id'], $itemsIds, []);
        $this->rebuildTree($items);
    }

    /**
     * Удаляем объекты из меню за исключением переданных.
     *
     * @param  int  $menuId
     * @param  array  $itemsIds
     * @param  array  $params
     *
     * @return bool
     */
    public function destroyExcept(int $menuId, array $itemsIds, array $params = [])
    {
        return $this->model->buildQuery($params)
            ->where('menu_id', $menuId)
            ->whereNotIn('id', $itemsIds)
            ->delete();
    }
}
