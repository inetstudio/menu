<?php

namespace InetStudio\MenusPackage\Items\Models;

use OwenIt\Auditing\Auditable;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InetStudio\AdminPanel\Models\Traits\HasJSONColumns;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\MenusPackage\Items\Contracts\Models\ItemModelContract;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;

/**
 * Class ItemModel.
 */
class ItemModel extends Model implements ItemModelContract
{
    use Auditable;
    use NodeTrait;
    use HasJSONColumns;
    use BuildQueryScopeTrait;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'menus_items';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'menu_id',
        'type',
        'menuable_id',
        'menuable_type',
        'parent_id',
        'additional_info',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы к базовым типам.
     *
     * @var array
     */
    protected $casts = [
        'additional_info' => 'array',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Загрузка модели.
     */
    protected static function boot()
    {
        parent::boot();

        self::$buildQueryScopeDefaults['columns'] = [
            'id',
            'menu_id',
            'additional_info',
            '_lft',
            '_rgt',
            'parent_id',
        ];

        self::$buildQueryScopeDefaults['relations'] = [
            'menu' => function ($menuQuery) {
                $menuQuery->select([
                    'id',
                    'name',
                    'alias',
                ]);
            },
        ];
    }

    /**
     * Обратное отношение "один ко многим" с моделью меню.
     *
     * @return BelongsTo
     *
     * @throws BindingResolutionException
     */
    public function menu(): BelongsTo
    {
        $menuModel = app()->make('InetStudio\MenusPackage\Menus\Contracts\Models\MenuModelContract');

        return $this->belongsTo(
            get_class($menuModel),
            'id',
            'menu_id'
        );
    }
}
