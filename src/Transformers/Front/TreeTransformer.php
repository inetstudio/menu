<?php

namespace InetStudio\Menu\Transformers\Front;

use League\Fractal\TransformerAbstract;
use InetStudio\Menu\Contracts\Models\MenuItemModelContract;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\Menu\Contracts\Transformers\Back\TreeTransformerContract;

/**
 * Class TreeTransformer.
 */
class TreeTransformer extends TransformerAbstract implements TreeTransformerContract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'items',
    ];

    /**
     * Подготовка данных для отображения дерева.
     *
     * @param MenuItemModelContract $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(MenuItemModelContract $item): array
    {
        $info = $item->getAttribute('additional_info');

        return [
            'menuItem' => array_get($info, 'menuItem'),
            'item' => array_get($info, 'item'),
        ];
    }

    /**
     * Включаем дочерние объекты в трасформацию.
     *
     * @param MenuItemModelContract $item
     *
     * @return FractalCollection
     */
    public function includeItems(MenuItemModelContract $item)
    {
        return new FractalCollection($item->getAttribute('children'), $this);
    }

    /**
     * Обработка коллекции объектов.
     *
     * @param $items
     *
     * @return FractalCollection
     */
    public function transformCollection($items): FractalCollection
    {
        return new FractalCollection($items, $this);
    }
}