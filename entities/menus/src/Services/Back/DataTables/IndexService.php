<?php

namespace InetStudio\MenusPackage\Menus\Services\Back\DataTables;

use Exception;
use Throwable;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Services\DataTable;
use InetStudio\MenusPackage\Menus\Contracts\Models\MenuModelContract;
use InetStudio\MenusPackage\Menus\Contracts\Services\Back\DataTables\IndexServiceContract;
use InetStudio\MenusPackage\Menus\Contracts\Transformers\Back\Resource\IndexTransformerContract;

/**
 * Class IndexService.
 */
class IndexService extends DataTable implements IndexServiceContract
{
    /**
     * @var MenuModelContract
     */
    public $model;

    /**
     * @var IndexTransformerContract
     */
    public $transformer;

    /**
     * @var Builder
     */
    public $table;

    /**
     * IndexService constructor.
     *
     * @param  MenuModelContract  $model
     * @param  IndexTransformerContract  $transformer
     * @param  Builder  $table
     */
    public function __construct(
        MenuModelContract $model,
        IndexTransformerContract $transformer,
        Builder $table
    ) {
        $this->model = $model;
        $this->transformer = $transformer;
        $this->table = $table;
    }

    /**
     * Получение данных таблицы.
     *
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function ajax(): JsonResponse
    {
        return DataTables::of($this->query())
            ->setTransformer($this->transformer)
            ->rawColumns(['actions'])
            ->make();
    }

    /**
     * Получаем запрос для получения данных.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = $this->model->buildQuery(
            [
                'columns' => ['created_at', 'updated_at'],
            ]
        );

        return $query;
    }

    /**
     * Генерация таблицы.
     *
     * @return Builder
     *
     * @throws Throwable
     */
    public function html(): Builder
    {
        return $this->table
            ->columns($this->getColumns())
            ->ajax($this->getAjaxOptions())
            ->parameters($this->getParameters());
    }

    /**
     * Получаем колонки.
     *
     * @return array
     *
     * @throws \Throwable
     */
    protected function getColumns(): array
    {
        return [
            ['data' => 'name', 'name' => 'name', 'title' => 'Название'],
            ['data' => 'alias', 'name' => 'alias', 'title' => 'Алиас'],
            ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Дата создания'],
            ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Дата обновления'],
            [
                'data' => 'actions',
                'name' => 'actions',
                'title' => 'Действия',
                'orderable' => false,
                'searchable' => false
            ],
        ];
    }

    /**
     * Свойства ajax datatables.
     *
     * @return array
     */
    protected function getAjaxOptions(): array
    {
        return [
            'url' => route('back.menus-package.menus.data.index'),
            'type' => 'POST',
        ];
    }

    /**
     * Свойства datatables.
     *
     * @return array
     */
    protected function getParameters(): array
    {
        $translation = trans('admin::datatables');

        return [
            'order' => [2, 'desc'],
            'paging' => true,
            'pagingType' => 'full_numbers',
            'searching' => true,
            'info' => false,
            'searchDelay' => 350,
            'language' => $translation,
        ];
    }
}
