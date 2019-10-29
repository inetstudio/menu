<?php

namespace InetStudio\MenusPackage\Menus\Services\Back;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\MenusPackage\Menus\Contracts\Models\MenuModelContract;
use InetStudio\MenusPackage\Menus\Contracts\Services\Back\ItemsServiceContract;

/**
 * Class ItemsService.
 */
class ItemsService extends BaseService implements ItemsServiceContract
{
    /**
     * ItemsService constructor.
     *
     * @param  MenuModelContract  $model
     */
    public function __construct(MenuModelContract $model)
    {
        parent::__construct($model);
    }

    /**
     * Сохраняем модель.
     *
     * @param  array  $data
     * @param  int  $id
     *
     * @return MenuModelContract
     *
     * @throws BindingResolutionException
     */
    public function save(array $data, int $id): MenuModelContract
    {
        $action = ($id) ? 'отредактировано' : 'создано';

        $itemData = Arr::only($data, $this->model->getFillable());
        $item = $this->saveModel($itemData, $id);

        if (Arr::has($data, 'menu_data')) {
            $menuData = Arr::get($data, 'menu_data');
            app()->make('InetStudio\MenusPackage\Items\Contracts\Services\Back\ItemsServiceContract')
                ->attachToObject($menuData, $item);
        }

        event(
            app()->make(
                'InetStudio\MenusPackage\Menus\Contracts\Events\Back\ModifyItemEventContract',
                compact('item')
            )
        );

        Session::flash('success', 'Меню «'.$item['name'].'» успешно '.$action);

        return $item;
    }
}
