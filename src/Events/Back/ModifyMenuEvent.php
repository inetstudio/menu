<?php

namespace InetStudio\Menu\Events\Back;

use Illuminate\Queue\SerializesModels;
use InetStudio\Menu\Contracts\Events\Back\ModifyMenuEventContract;

/**
 * Class ModifyMenuEvent.
 */
class ModifyMenuEvent implements ModifyMenuEventContract
{
    use SerializesModels;

    public $object;

    /**
     * Create a new event instance.
     *
     * ModifyMenuEvent constructor.
     *
     * @param $object
     */
    public function __construct($object)
    {
        $this->object = $object;
    }
}
