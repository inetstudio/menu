<?php

namespace InetStudio\Menu\Repositories;

use InetStudio\AdminPanel\Repositories\BaseRepository;
use InetStudio\Menu\Contracts\Models\MenuModelContract;
use InetStudio\Menu\Contracts\Repositories\MenusRepositoryContract;

/**
 * Class MenusRepository.
 */
class MenusRepository extends BaseRepository implements MenusRepositoryContract
{
    /**
     * MenusRepository constructor.
     *
     * @param MenuModelContract $model
     */
    public function __construct(MenuModelContract $model)
    {
        $this->model = $model;

        $this->defaultColumns = ['id', 'name', 'alias'];
        $this->relations = [];
    }

    /**
     * Возвращаем объект по alias.
     *
     * @param string $alias
     * @param array $params
     *
     * @return mixed
     */
    public function getItemByAlias(string $alias, array $params = [])
    {
        $builder = $this->getItemsQuery($params)
            ->where('alias', $alias);

        $item = $builder->first();

        return $item;
    }
}
