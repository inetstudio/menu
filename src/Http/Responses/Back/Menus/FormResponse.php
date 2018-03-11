<?php

namespace InetStudio\Menu\Http\Responses\Back\Menus;

use Illuminate\View\View;
use Illuminate\Contracts\Support\Responsable;
use InetStudio\Menu\Contracts\Http\Responses\Back\Menus\FormResponseContract;

/**
 * Class FormResponse.
 */
class FormResponse implements FormResponseContract, Responsable
{
    /**
     * @var array
     */
    private $data;

    /**
     * FormResponse constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Возвращаем ответ при открытии формы объекта.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return View
     */
    public function toResponse($request): View
    {
        return view('admin.module.menu::back.pages.form', $this->data);
    }
}
