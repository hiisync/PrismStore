<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * Model for working with navigation items.
 *
 * @property int $id The identifier of the navigation item.
 * @property array $name The name of the navigation item in different locales.
 * @property string $url The URL of the navigation item.
 * @property string $type The type of the navigation item.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Navigation whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Navigation extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that should be translated.
     */
    protected array $translatable = [
        'name',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'url',
        'type',
    ];
}
