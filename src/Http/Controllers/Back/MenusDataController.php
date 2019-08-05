<?php

namespace InetStudio\Menu\Http\Controllers\Back;

use InetStudio\AdminPanel\Base\Http\Controllers\Controller;
use InetStudio\Menu\Contracts\Http\Controllers\Back\MenusDataControllerContract;

/**
 * Class MenusDataController.
 */
class MenusDataController extends Controller implements MenusDataControllerContract
{
    /**
     * Используемые сервисы.
     *
     * @var array
     */
    private $services;

    /**
     * MenusDataController constructor.
     */
    public function __construct()
    {
        $this->services['dataTables'] = app()->make('InetStudio\Menu\Contracts\Services\Back\Menus\MenusDataTableServiceContract');
    }

    /**
     * Получаем данные для отображения в таблице.
     *
     * @return mixed
     */
    public function data()
    {
        return $this->services['dataTables']->ajax();
    }
}
