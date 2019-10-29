<?php

namespace InetStudio\MenusPackage\Menus\Transformers\Back\Resource;

use Throwable;
use InetStudio\AdminPanel\Base\Transformers\BaseTransformer;
use InetStudio\MenusPackage\Menus\Contracts\Models\MenuModelContract;
use InetStudio\MenusPackage\Menus\Contracts\Transformers\Back\Resource\IndexTransformerContract;

/**
 * Class IndexTransformer.
 */
class IndexTransformer extends BaseTransformer implements IndexTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param  MenuModelContract  $item
     *
     * @return array
     *
     * @throws Throwable
     */
    public function transform(MenuModelContract $item): array
    {
        return [
            'name' => $item['name'],
            'alias' => $item['alias'],
            'created_at' => (string) $item['created_at'],
            'updated_at' => (string) $item['updated_at'],
            'actions' => view(
                'admin.module.menus-package.menus::back.partials.datatables.actions',
                [
                    'id' => $item['id'],
                ]
            )->render(),
        ];
    }
}
