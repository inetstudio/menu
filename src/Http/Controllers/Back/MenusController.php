<?php

namespace InetStudio\Menu\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use InetStudio\Menu\Contracts\Http\Requests\Back\SaveMenuRequestContract;
use InetStudio\Menu\Contracts\Http\Controllers\Back\MenusControllerContract;
use InetStudio\Menu\Contracts\Http\Responses\Back\Menus\FormResponseContract;
use InetStudio\Menu\Contracts\Http\Responses\Back\Menus\SaveResponseContract;
use InetStudio\Menu\Contracts\Http\Responses\Back\Menus\IndexResponseContract;
use InetStudio\Menu\Contracts\Http\Responses\Back\Menus\DestroyResponseContract;

/**
 * Class MenusController.
 */
class MenusController extends Controller implements MenusControllerContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    private $services;

    /**
     * MenusController constructor.
     */
    public function __construct()
    {
        $this->services['menu'] = app()->make('InetStudio\Menu\Contracts\Services\Back\Menus\MenusServiceContract');
        $this->services['menuItems'] = app()->make('InetStudio\Menu\Contracts\Services\Back\MenuItems\MenuItemsServiceContract');
        $this->services['dataTables'] = app()->make('InetStudio\Menu\Contracts\Services\Back\Menus\MenusDataTableServiceContract');
    }

    /**
     * Список объектов.
     *
     * @return IndexResponseContract
     *
     * @throws \Exception
     */
    public function index(): IndexResponseContract
    {
        $table = $this->services['dataTables']->html();

        return app()->makeWith('InetStudio\Menu\Contracts\Http\Responses\Back\Menus\IndexResponseContract', [
            'data' => compact('table'),
        ]);
    }

    /**
     * Добавление объекта.
     *
     * @return FormResponseContract
     */
    public function create(): FormResponseContract
    {
        $item = $this->services['menu']->getMenuObject();

        return app()->makeWith('InetStudio\Menu\Contracts\Http\Responses\Back\Menus\FormResponseContract', [
            'data' => compact('item'),
        ]);
    }

    /**
     * Создание объекта.
     *
     * @param SaveMenuRequestContract $request
     *
     * @return SaveResponseContract
     */
    public function store(SaveMenuRequestContract $request): SaveResponseContract
    {
        return $this->save($request);
    }

    /**
     * Редактирование объекта.
     *
     * @param int $id
     *
     * @return FormResponseContract
     */
    public function edit(int $id = 0): FormResponseContract
    {
        $item = $this->services['menu']->getMenuObject($id);
        $tree = $this->services['menuItems']->getTree($id);

        return app()->makeWith('InetStudio\Menu\Contracts\Http\Responses\Back\Menus\FormResponseContract', [
            'data' => compact('item', 'tree'),
        ]);
    }

    /**
     * Обновление объекта.
     *
     * @param SaveMenuRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    public function update(SaveMenuRequestContract $request, int $id = 0): SaveResponseContract
    {
        return $this->save($request, $id);
    }

    /**
     * Сохранение меню.
     *
     * @param SaveMenuRequestContract $request
     * @param int $id
     *
     * @return SaveResponseContract
     */
    protected function save(SaveMenuRequestContract $request, int $id = 0): SaveResponseContract
    {
        $item = $this->services['menu']->save($request, $id);

        return app()->makeWith('InetStudio\Menu\Contracts\Http\Responses\Back\Menus\SaveResponseContract', [
            'item' => $item,
        ]);
    }

    /**
     * Удаление объекта.
     *
     * @param int $id
     *
     * @return DestroyResponseContract
     */
    public function destroy(int $id = 0): DestroyResponseContract
    {
        $result = $this->services['menu']->destroy($id);

        return app()->makeWith('InetStudio\Menu\Contracts\Http\Responses\Back\Menus\DestroyResponseContract', [
            'result' => ($result === null) ? false : $result,
        ]);
    }
}
