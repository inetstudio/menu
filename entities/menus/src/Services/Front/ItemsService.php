<?php

namespace InetStudio\MenusPackage\Menus\Services\Front;

use League\Fractal\Manager;
use InetStudio\AdminPanel\Base\Services\BaseService;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\MenusPackage\Menus\Contracts\Models\MenuModelContract;
use InetStudio\MenusPackage\Menus\Contracts\Services\Front\ItemsServiceContract;

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
     * Возвращаем меню.
     *
     * @param  string  $alias
     * @param  array  $params
     *
     * @return array
     *
     * @throws BindingResolutionException
     */
    public function getMenuTree(string $alias, array $params = []): array
    {
        $itemsService = app()->make('InetStudio\MenusPackage\Items\Contracts\Services\Back\ItemsServiceContract');

        $menu = $this->model->buildQuery($params)->where('alias', $alias)->first();

        $tree = ($menu)
            ? $itemsService->getModel()->where('menu_id', $menu['id'])
                ->defaultOrder()
                ->get()
                ->toTree()
            : [];

        $resource = (app()->make('InetStudio\MenusPackage\Items\Contracts\Transformers\Front\TreeTransformerContract'))
            ->transformCollection($tree);

        $dataManager = new Manager();
        $dataManager->setSerializer(app()->make('InetStudio\AdminPanel\Base\Contracts\Serializers\SimpleDataArraySerializerContract'));

        return $dataManager->createData($resource)->toArray();
    }
}
