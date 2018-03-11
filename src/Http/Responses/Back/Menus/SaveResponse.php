<?php

namespace InetStudio\Menu\Http\Responses\Back\Menus;

use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Menu\Contracts\Models\MenuModelContract;
use InetStudio\Menu\Contracts\Http\Responses\Back\Menus\SaveResponseContract;

/**
 * Class SaveResponse.
 */
class SaveResponse implements SaveResponseContract, Responsable
{
    /**
     * @var MenuModelContract
     */
    private $item;

    /**
     * SaveResponse constructor.
     *
     * @param MenuModelContract $item
     */
    public function __construct(MenuModelContract $item)
    {
        $this->item = $item;
    }

    /**
     * Возвращаем ответ при сохранении объекта.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return RedirectResponse
     */
    public function toResponse($request): RedirectResponse
    {
        return response()->redirectToRoute('back.menu.edit', [
            $this->item->fresh()->id,
        ]);
    }
}
