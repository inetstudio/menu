<?php

namespace InetStudio\Menu\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use InetStudio\Menu\Contracts\Models\MenuModelContract;

/**
 * Class MenuModel.
 */
class MenuModel extends Model implements MenuModelContract, Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

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
        'name', 'alias',
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
     * Сеттер атрибута name.
     *
     * @param $value
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strip_tags($value);
    }

    /**
     * Сеттер атрибута alias.
     *
     * @param $value
     */
    public function setAliasAttribute($value)
    {
        $this->attributes['alias'] = strip_tags($value);
    }

    /**
     * Отношение "один ко многим" с моделью пунктов меню.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(app()->make('InetStudio\Menu\Contracts\Models\MenuItemModelContract'), 'menu_id', 'id');
    }
}
