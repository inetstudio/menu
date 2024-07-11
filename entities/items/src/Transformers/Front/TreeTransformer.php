<?php

namespace InetStudio\MenusPackage\Items\Transformers\Front;

use Illuminate\Support\Arr;
use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use League\Fractal\Resource\Collection as FractalCollection;
use InetStudio\MenusPackage\Items\Contracts\Models\ItemModelContract;
use InetStudio\MenusPackage\Items\Contracts\Transformers\Front\TreeTransformerContract;

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
     * Трансформация данных.
     *
     * @param ItemModelContract $item
     *
     * @return array
     */
    public function transform(ItemModelContract $item): array
    {
        $info = $item['additional_info'];

        return [
            'menuItem' => array_merge(Arr::get($info, 'menuItem'), ['css' => Arr::get($info, 'fields.cssClass')]),
            'item' => Arr::get($info, 'item'),
        ];
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
        return new FractalCollection($item->getAttribute('children'), $this);
    }
}
