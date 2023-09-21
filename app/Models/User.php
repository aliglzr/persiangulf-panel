<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Core\Traits\HasData;
use App\Core\Traits\HasStep;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property integer $id
 * @property string $password
 * @method  static Builder where(string $string, string $username)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasData, HasStep, CanResetPassword;

    protected static $recordEvents = ['updated', 'created'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'username',
        'email',
        'active',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return string
     * Retrieves full name of the user
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function data(): HasMany
    {
        return $this->hasMany(UserData::class);
    }

    /**
     * return user sessions
     * @return HasMany
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }
    /**
     * Retrieves a unique avatar for Admin
     * @return string
     */
    public function getAvatarUrl(): string
    {
        $backgroundColor = theme()->getCurrentMode() == 'dark' ? '#1a1a27' : '#ffffff';
        $style = new \Jdenticon\IdenticonStyle(array(
            'backgroundColor' => $backgroundColor,
        ));
        $icon = new \Jdenticon\Identicon(array(
            'value' => $this->username,
            'size' => 100,
            'style' => $style
        ));
        return $icon->getImageDataUri();
    }

}
