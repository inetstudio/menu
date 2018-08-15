<?php

namespace InetStudio\Menu\Transformers\Back;

use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\Menu\Contracts\Transformers\Back\PrepareMenuItemsTransformerContract;

/**
 * Class PrepareMenuItemsTransformer.
 */
class PrepareMenuItemsTransformer extends TransformerAbstract implements PrepareMenuItemsTransformerContract
{
    /**
     * @var array
     */
    protected $defaultIncludes = [
        'children',
    ];

    protected $menuID;

    public function __construct($menuID)
    {
        $this->menuID = $menuID;
    }

    /**
     * Подготовка данных для отображения дерева.
     *
     * @param array $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(array $item): array
    {
        return [
            'id' => $item['id'],
            'menu_id' => $this->menuID,
            'type' => $item['modal']['fields']['type'],
            'menuable_id' => $item['modal']['item']['id'],
            'menuable_type' => $item['modal']['item']['type'],
            'parent_id' => (isset($item['modal']['menuItem']['parent_id'])) ? $item['modal']['menuItem']['parent_id'] : 0,
            'additional_info' => $item['modal'],
        ];
    }

    /**
     * Включаем дочерние объекты в трансформацию.
     *
     * @param array $item
     *
     * @return FractalCollection
     */
    public function includeChildren(array $item)
    {
        return new FractalCollection((isset($item['children'])) ? $item['children'] : [], $this);
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
