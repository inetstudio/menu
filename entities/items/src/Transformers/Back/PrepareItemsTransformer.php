<?php

namespace InetStudio\MenusPackage\Items\Transformers\Back;

use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\MenusPackage\Items\Contracts\Transformers\Back\PrepareItemsTransformerContract;

/**
 * Class PrepareItemsTransformer.
 */
class PrepareItemsTransformer extends BaseTransformer implements PrepareItemsTransformerContract
{
    /**
     * @var array
     */
    protected array $defaultIncludes = [
        'children',
    ];

    /**
     * @var int
     */
    protected $menuId;

    /**
     * PrepareItemsTransformer constructor.
     *
     * @param  int  $menuId
     */
    public function __construct(int $menuId)
    {
        $this->menuId = $menuId;
    }

    /**
     * Трансформация данных для отображения дерева.
     *
     * @param array $item
     *
     * @return array
     */
    public function transform(array $item): array
    {
        return [
            'id' => is_string($item['id']) ? 0 : $item['id'],
            'menu_id' => $this->menuId,
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
}
