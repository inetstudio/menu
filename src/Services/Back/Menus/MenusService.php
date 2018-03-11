<?php

namespace InetStudio\Menu\Services\Back\Menus;

use Illuminate\Support\Facades\Session;
use InetStudio\Menu\Contracts\Models\MenuModelContract;
use InetStudio\Menu\Contracts\Repositories\MenusRepositoryContract;
use InetStudio\Menu\Contracts\Services\Back\Menus\MenusServiceContract;
use InetStudio\Menu\Contracts\Http\Requests\Back\SaveMenuRequestContract;

/**
 * Class MenusService.
 */
class MenusService implements MenusServiceContract
{
    /**
     * @var MenusRepositoryContract
     */
    private $repository;

    /**
     * MenusService constructor.
     *
     * @param MenusRepositoryContract $repository
     */
    public function __construct(MenusRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Получаем объект модели.
     *
     * @param int $id
     *
     * @return MenuModelContract
     */
    public function getMenuObject(int $id = 0)
    {
        return $this->repository->getItemByID($id);
    }

    /**
     * Получаем объекты по списку id.
     *
     * @param array|int $ids
     * @param bool $returnBuilder
     *
     * @return mixed
     */
    public function getMenusByIDs($ids, bool $returnBuilder = false)
    {
        return $this->repository->getItemsByIDs($ids, $returnBuilder);
    }

    /**
     * Сохраняем модель.
     *
     * @param SaveMenuRequestContract $request
     * @param int $id
     *
     * @return MenuModelContract
     */
    public function save(SaveMenuRequestContract $request, int $id): MenuModelContract
    {
        $action = ($id) ? 'отредактировано' : 'создано';
        $item = $this->repository->save($request, $id);

        if ($request->filled('menu_data')) {
            app()->make('InetStudio\Menu\Contracts\Services\Back\MenuItems\MenuItemsServiceContract')
                ->attachMenuItems($request, $item);
        }

        event(app()->makeWith('InetStudio\Menu\Contracts\Events\Back\ModifyMenuEventContract', [
            'object' => $item,
        ]));

        Session::flash('success', 'Меню «'.$item->getAttribute('name').'» успешно '.$action);

        return $item;
    }

    /**
     * Удаляем модель.
     *
     * @param $id
     *
     * @return bool
     */
    public function destroy(int $id): ?bool
    {
        return $this->repository->destroy($id);
    }
}
