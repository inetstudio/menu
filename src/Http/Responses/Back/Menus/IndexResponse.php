<?php

namespace InetStudio\Menu\Http\Responses\Back\Menus;

use Illuminate\View\View;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Menu\Contracts\Http\Responses\Back\Menus\IndexResponseContract;

/**
 * Class IndexResponse.
 */
class IndexResponse implements IndexResponseContract, Responsable
{
    /**
     * @var array
     */
    private $data;

    /**
     * IndexResponse constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Возвращаем ответ при открытии списка объектов.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return View
     */
    public function toResponse($request): View
    {
        return view('admin.module.menu::back.pages.index', $this->data);
    }
}
