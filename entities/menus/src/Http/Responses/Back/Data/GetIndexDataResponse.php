<?php

namespace InetStudio\MenusPackage\Menus\Http\Responses\Back\Data;

use Illuminate\Http\Request;
use InetStudio\MenusPackage\Menus\Contracts\Services\Back\DataTables\IndexServiceContract;
use InetStudio\MenusPackage\Menus\Contracts\Http\Responses\Back\Data\GetIndexDataResponseContract;

/**
 * Class GetIndexDataResponse.
 */
class GetIndexDataResponse implements GetIndexDataResponseContract
{
    /**
     * @var IndexServiceContract
     */
    protected $dataService;

    /**
     * GetIndexDataResponse constructor.
     *
     * @param  IndexServiceContract  $dataService
     */
    public function __construct(IndexServiceContract $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * Возвращаем ответ при запросе данных.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        return $this->dataService->ajax();
    }
}
