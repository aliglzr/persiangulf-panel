<?php

namespace App\Models;

use App\Core\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserData extends Model
{
    use HasFactory, Encryptable;

    protected $fillable = [
        'data_key' , 'data_value'
    ];

    protected array $encryptable = [
        'data_value',
    ];

    /**
     * Get `user` of this `data`
     * @return BelongsTo
     */
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'data_value' => 'array'
    ];
}
