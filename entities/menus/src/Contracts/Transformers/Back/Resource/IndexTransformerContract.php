<?php

namespace InetStudio\MenusPackage\Menus\Contracts\Transformers\Back\Resource;

use InetStudio\MenusPackage\Menus\Contracts\Models\MenuModelContract;

/**
 * Interface IndexTransformerContract.
 */
interface IndexTransformerContract
{
    /**
     * Подготовка данных для отображения в таблице.
     *
     * @param  MenuModelContract  $item
     *
     * @return array
     */
    public function transform(MenuModelContract $item): array;
}
