<?php

namespace InetStudio\MenusPackage\Menus\Http\Responses\Back\Resource;

use Illuminate\Http\Request;
use InetStudio\MenusPackage\Menus\Contracts\Http\Responses\Back\Resource\EditResponseContract;
use InetStudio\MenusPackage\Items\Contracts\Services\Back\ItemsServiceContract as ItemsServiceContract;
use InetStudio\MenusPackage\Menus\Contracts\Services\Back\ItemsServiceContract as MenusServiceContract;

/**
 * Class EditResponse.
 */
class EditResponse implements EditResponseContract
{
    /**
     * @var MenusServiceContract
     */
    protected $resourceService;

    /**
     * @var ItemsServiceContract
     */
    protected $itemsService;

    /**
     * EditResponse constructor.
     *
     * @param  MenusServiceContract  $resourceService
     * @param  ItemsServiceContract  $itemsService
     */
    public function __construct(MenusServiceContract $resourceService, ItemsServiceContract $itemsService)
    {
        $this->resourceService = $resourceService;
        $this->itemsService = $itemsService;
    }

    /**
     * Возвращаем ответ при редактировании объекта.
     *
     * @param  Request  $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response|null
     */
    public function toResponse($request)
    {
        $id = $request->route('menu', 0);

        $item = $this->resourceService->getItemById($id);
        $tree = $this->itemsService->getTree($id);

        return response()->view('admin.module.menus-package.menus::back.pages.form', compact('item', 'tree'));
    }
}
