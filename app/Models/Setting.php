<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

/**
 * Model for working with settings.
 *
 * @property int $id The identifier of the setting.
 * @property string $name The name of the setting.
 * @property string $key The key of the setting.
 * @property array $value The value of the setting.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Setting extends Model
{
    use HasFactory, HasTranslations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'key',
        'value',
    ];

    /**
     * The attributes that should be translated.
     */
    protected array $translatable = [
        'name',
    ];

    /**
     * Get the setting by key.
     *
     * @param  string  $key The key of the setting.
     * @return \App\Models\Setting|null
     */
    public function get($key)
    {
        return $this->where('key', $key)->first();
    }

    /**
     * Set the value for the setting with the given key.
     *
     * @param  string  $key The key of the setting.
     * @param  mixed  $value The new value for the setting.
     * @return bool Whether the value was successfully set.
     */
    public function set($key, $value)
    {
        $setting = $this->where('key', $key)->first();
        if ($setting) {
            $setting->value = $value;
            $setting->save();

            return true;
        }

        return false;
    }

    /**
     * Check if a setting exists with the given key.
     *
     * @param  string  $key The key of the setting.
     * @return bool Whether a setting exists with the given key.
     */
    public function has($key)
    {
        return $this->where('key', $key)->exists();
    }
}
