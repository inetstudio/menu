<?php

namespace InetStudio\Menu\Services\Back\MenuItems;

use Illuminate\Support\Arr;
use League\Fractal\Manager;
use InetStudio\Menu\Contracts\Models\MenuModelContract;
use InetStudio\Menu\Contracts\Models\MenuItemModelContract;
use InetStudio\AdminPanel\Serializers\SimpleDataArraySerializer;
use InetStudio\Menu\Contracts\Http\Requests\Back\SaveMenuRequestContract;
use InetStudio\Menu\Contracts\Services\Back\MenuItems\MenuItemsServiceContract;

/**
 * Class MenuItemsService.
 */
class MenuItemsService implements MenuItemsServiceContract
{
    /**
     * @var
     */
    protected $repository;

    protected $dataManager;

    /**
     * MenuItemsService constructor.
     */
    public function __construct()
    {
        $this->repository = app()->make('InetStudio\Menu\Contracts\Repositories\MenuItemsRepositoryContract');

        $this->dataManager = new Manager();
        $this->dataManager->setSerializer(new SimpleDataArraySerializer());
    }

    /**
     * Получаем объект модели.
     *
     * @param int $id
     *
     * @return MenuItemModelContract
     */
    public function getMenuItemObject(int $id = 0)
    {
        return $this->repository->getItemByID($id);
    }

    /**
     * Получаем объекты по списку id.
     *
     * @param array|int $ids
     * @param array $params
     *
     * @return mixed
     */
    public function getMenuItemsByIDs($ids, array $params = [])
    {
        return $this->repository->getItemsByIDs($ids, $params);
    }

    /**
     * Аттачим пункты меню к меню.
     *
     * @param SaveMenuRequestContract $request
     * @param MenuModelContract $menu
     */
    public function attachMenuItems(SaveMenuRequestContract $request, MenuModelContract $menu)
    {
        $data = collect(json_decode($request->get('menu_data'), true));

        $resource = (app()->makeWith('InetStudio\Menu\Contracts\Transformers\Back\PrepareMenuItemsTransformerContract', [
            'menuID' => $menu->id,
        ]))->transformCollection($data);

        $items = $this->dataManager->createData($resource)->toArray();

        $itemsIDs = [];
        foreach ($items as &$menuItemData) {
            $itemsIDs = array_merge($itemsIDs, $this->save($menuItemData, null));
        }

        $this->repository->destroyFromMenuExcept($menu->id, $itemsIDs, []);
        $this->repository->rebuildTree($items);
    }

    /**
     * Сохраняем пункт меню.
     *
     * @param $menuItemData
     * @param $parentID
     *
     * @return array
     */
    protected function save(&$menuItemData, $parentID): array
    {
        $itemsIDs = [];

        $menuItemData['additional_info']['menuItem']['parent_id'] = $parentID;
        $menuItemData['parent_id'] = $parentID;

        $data = $menuItemData;
        Arr::forget($data, ['id', 'children', 'additional_info.action', 'additional_info.item']);

        $menuItem = $this->repository->save($data, $menuItemData['id']);

        $menuItemData['id'] = $menuItem->id;
        $menuItemData['additional_info']['menuItem']['id'] = $menuItem->id;
        $data['additional_info']['menuItem']['id'] = $menuItem->id;

        $this->repository->save($data, $menuItem->id);

        $menuItem = $this->repository->addToTree($menuItem->id, (int) $parentID);

        $itemsIDs[] = $menuItem->id;

        foreach ($menuItemData['children'] as &$child) {
            $itemsIDs = array_merge($itemsIDs, $this->save($child, $menuItem->id));
        }

        return $itemsIDs;
    }

    /**
     * Удаляем модель.
     *
     * @param int $id
     *
     * @return bool
     */
    public function destroy(int $id): ?bool
    {
        return $this->repository->destroy($id);
    }

    /**
     * Получаем дерево объектов.
     *
     * @param int $menuId
     * @param array $params
     *
     * @return array
     */
    public function getTree(int $menuId, array $params = []): array
    {
        $tree = $this->repository->getTree($menuId, $params);

        $resource = (app()->make('InetStudio\Menu\Contracts\Transformers\Back\TreeTransformerContract'))
            ->transformCollection($tree);

        return $this->dataManager->createData($resource)->toArray();
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
        $result = $this->repository->rebuildTree($data);

        event(app()->makeWith('InetStudio\Menu\Contracts\Events\Back\ModifyMenuEventContract', []));

        return $result;
    }
}
