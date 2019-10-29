<?php

namespace InetStudio\MenusPackage\Menus\Models;

use OwenIt\Auditing\Auditable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Contracts\Container\BindingResolutionException;
use InetStudio\MenusPackage\Menus\Contracts\Models\MenuModelContract;
use InetStudio\AdminPanel\Base\Models\Traits\Scopes\BuildQueryScopeTrait;

/**
 * Class MenuModel.
 */
class MenuModel extends Model implements MenuModelContract
{
    use Auditable;
    use SoftDeletes;
    use BuildQueryScopeTrait;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'menus';

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'alias',
    ];

    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Should the timestamps be audited?
     *
     * @var bool
     */
    protected $auditTimestamps = true;

    /**
     * Загрузка модели.
     */
    protected static function boot()
    {
        parent::boot();

        self::$buildQueryScopeDefaults['columns'] = [
            'id',
            'name',
            'alias',
        ];

        self::$buildQueryScopeDefaults['relations'] = [
            'items' => function (HasMany $itemsQuery) {
                $itemsQuery->select(['id', 'menu_id', 'type', 'menuable_id', 'menuable_type', 'parent_id', 'additional_info']);
            },
        ];
    }

    /**
     * Сеттер атрибута name.
     *
     * @param $value
     */
    public function setNameAttribute($value): void
    {
        $this->attributes['name'] = trim(strip_tags($value));
    }

    /**
     * Сеттер атрибута alias.
     *
     * @param $value
     */
    public function setAliasAttribute($value): void
    {
        $this->attributes['alias'] = trim(strip_tags($value));
    }

    /**
     * Отношение "один ко многим" с моделью пунктов меню.
     *
     * @return HasMany
     *
     * @throws BindingResolutionException
     */
    public function items(): HasMany
    {
        $itemModel = app()->make('InetStudio\MenusPackage\Items\Contracts\Models\ItemModelContract');

        return $this->hasMany(
            get_class($itemModel),
            'menu_id'
        );
    }
}
