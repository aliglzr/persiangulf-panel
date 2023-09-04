<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property int id
 * @property string option_key
 * @property string option_value
 * @method static Collection where(string $key, string $value)
 * @method static Option updateOrCreate(string[] $unique, string[] $attributes)
 */


class Option extends Model
{
    use HasFactory,LogsActivity;

    protected $fillable = [
        'option_key', 'option_value'
    ];

    /**
     * Retrieves `option` from `options` table
     * @param string $key
     * @param bool $self
     * @return mixed
     */
    public static function get(string $key, bool $self = false): mixed {
        $option = Option::where('option_key', $key)->first();
        if($self) {
            return $option;
        }
        return $option?->option_value;
    }

    /**
     * Updates or create option from `option` table
     * @param string $key
     * @param string|null $value
     * @return Model
     */
    public static function set(string $key, string $value = null): Model {
        return Option::updateOrCreate([
            'option_key' => $key
        ], [
            'option_value' => $value
        ]);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('options')->logOnlyDirty()->logAll();
    }


}
