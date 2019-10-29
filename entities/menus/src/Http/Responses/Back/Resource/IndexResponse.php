<?php

namespace InetStudio\MenusPackage\Menus\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use InetStudio\MenusPackage\Menus\Contracts\Http\Responses\Back\Resource\IndexResponseContract;
use InetStudio\MenusPackage\Menus\Contracts\Services\Back\DataTables\IndexServiceContract as DataTableServiceContract;

/**
 * Class IndexResponse.
 */
class IndexResponse implements IndexResponseContract
{
    /**
     * @var array
     */
    protected $datatableService;

    /**
     * IndexResponse constructor.
     *
     * @param  DataTableServiceContract  $datatableService
     */
    public function __construct(DataTableServiceContract $datatableService)
    {
        $this->datatableService = $datatableService;
    }

    /**
     * Возвращаем ответ при открытии списка объектов.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response|null
     */
    public function toResponse($request)
    {
        $table = $this->datatableService->html();

        return response()->view('admin.module.menus-package.menus::back.pages.index', compact('table'));
    }
}
