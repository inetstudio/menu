<?php

namespace InetStudio\Menu\Transformers\Back;

use League\Fractal\TransformerAbstract;
use InetStudio\Menu\Contracts\Models\MenuModelContract;

/**
 * Class MenuTransformer.
 */
class MenuTransformer extends TransformerAbstract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param MenuModelContract $item
     *
     * @return array
     *
     * @throws \Throwable
     */
    public function transform(MenuModelContract $item): array
    {
        return [
            'name' => $item->getAttribute('name'),
            'alias' => $item->getAttribute('alias'),
            'created_at' => (string) $item->getAttribute('created_at'),
            'updated_at' => (string) $item->getAttribute('updated_at'),
            'actions' => view('admin.module.menu::back.partials.datatables.actions', [
                'id' => $item->getAttribute('id'),
            ])->render(),
        ];
    }
}
