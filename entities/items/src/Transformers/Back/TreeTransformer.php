<?php

namespace InetStudio\MenusPackage\Items\Transformers\Back;

use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\MenusPackage\Items\Contracts\Models\ItemModelContract;
use InetStudio\MenusPackage\Items\Contracts\Transformers\Back\TreeTransformerContract;

/**
 * Class TreeTransformer.
 */
class TreeTransformer extends BaseTransformer implements TreeTransformerContract
{
    /**
     * @var array
     */
    protected array $defaultIncludes = [
        'items',
    ];

    /**
     * Трансформация данных для отображения дерева.
     *
     * @param ItemModelContract $item
     *
     * @return array
     */
    public function transform(ItemModelContract $item): array
    {
        $data = $item['additional_info'];
        $data['item'] = [
            'id' => $item['menuable_id'],
            'type' => $item['menuable_type'],
        ];

        return compact('data');
    }

    /**
     * Включаем дочерние объекты в трансформацию.
     *
     * @param ItemModelContract $item
     *
     * @return FractalCollection
     */
    public function includeItems(ItemModelContract $item)
    {
        return new FractalCollection($item['children'], $this);
    }
}
