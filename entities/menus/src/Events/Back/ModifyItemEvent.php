<?php

namespace InetStudio\MenusPackage\Menus\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\MenusPackage\Menus\Contracts\Models\MenuModelContract;
use InetStudio\MenusPackage\Menus\Contracts\Events\Back\ModifyItemEventContract;

/**
 * Class ModifyItemEvent.
 */
class ModifyItemEvent implements ModifyItemEventContract
{
    use SerializesModels;

    /**
     * @var MenuModelContract
     */
    public $item;

    /**
     * ModifyItemEvent constructor.
     *
     * @param  MenuModelContract  $item
     */
    public function __construct(MenuModelContract $item)
    {
        $this->item = $item;
    }
}
