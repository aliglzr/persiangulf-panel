<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int user_id
 * @property string token
 * @property string data
 * @property string ip_address
 * @property bool is_current
 * @property string user_agent
 * @property string payload
 * @property string last_activity
 * Class Session
 * @package App\Models
 * @method static Session find(int $id)
 * @method static orderBy(string $key, string $type)
 * @method static Builder where(string $field, mixed $input)
 */
class Session extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * is_current attribute for Session model
     * @return bool
     */
    public function getIsCurrentAttribute(): bool {
        return $this->id == \Illuminate\Support\Facades\Session::getId();
    }
}
