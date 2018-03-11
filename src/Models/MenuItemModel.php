<?php

namespace InetStudio\Menu\Models;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use InetStudio\AdminPanel\Models\Traits\HasJSONColumns;
use InetStudio\Menu\Contracts\Models\MenuItemModelContract;

/**
 * Class MenuItemModel.
 */
class MenuItemModel extends Model implements MenuItemModelContract
{
    use NodeTrait;
    use HasJSONColumns;

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
        'menu_id', 'type', 'menuable_id', 'menuable_type', 'parent_id', 'additional_info',
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
     * Обратное отношение "один ко многим" с моделью меню.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(app()->make('InetStudio\Menu\Contracts\Models\MenuModelContract'), 'id', 'menu_id');
    }
}
