<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Core\Extensions\V2ray\Models\Inbound;
use App\Core\Extensions\V2ray\Models\Response;
use App\Core\Theme;
use App\Core\Traits\HasData;
use App\Core\Traits\HasStep;
use App\Events\BalanceUpdated;
use App\Mail\ResetPassword;
use App\Notifications\UsersNotifications\PasswordResetNotification;
use App\Notifications\UsersNotifications\VerifyEmailNotification;
use Carbon\Carbon;
use Coderflex\LaravelTicket\Concerns\HasTickets;
use Coderflex\LaravelTicket\Contracts\CanUseTickets;
use DateTime;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\HasApiTokens;
use phpDocumentor\Reflection\Types\Static_;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int id
 * @property string tid
 * @property string first_name
 * @property string last_name
 * @property string username
 * @property string full_name
 * @property string email
 * @property float balance
 * @property string password
 * @property string google2fa_secret
 * @property string google_id
 * @property int plan_id
 * @property int reference_id
 * @property int|null invited_by
 * @property string|null invite_code
 * @property int layer_id
 * @property boolean active
 * @property boolean from_bot
 * @property DateTime email_verified_at
 * @property DateTime created_at
 * @property DateTime plan_starts_at
 * @property DateTime plan_expires_at
 * @property DateTime updated_at
 * @property string $uuid
 * @property Layer $layer
 * @property PlanUser $planUser
 * @property User $introducer
 * @property User $inviter
 * @property \Illuminate\Database\Eloquent\Collection $invited
 * Class User
 * @package App\Models
 * @method static User find(int $id)
 * @method static orderBy(string $key, string $type)
 * @method static create(array $data)
 * @method static Builder where(string $string, mixed $value)
 */
class User extends Authenticatable implements MustVerifyEmail, CanUseTickets
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, LogsActivity, HasData, HasStep, CausesActivity,HasTickets,CanResetPassword;

    protected static $recordEvents = ['updated','created'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'tid',
        'uuid',
        'first_name',
        'last_name',
        'username',
        'email',
        'balance',
        'reference_id',
        'plan_id',
        'active',
        'plan_starts_at',
        'plan_expires_at',
        'password',
        'layer_id',
        'email_verified_at',
        'invite_code',
        'invited_by',
        'from_bot',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'plan_starts_at' => 'datetime',
        'plan_expires_at' => 'datetime',
    ];

    /**
     * check whether the user had enabled 2fa or not
     * @return bool
     */
    public function has2faEnabled(): bool
    {
        return !!$this->getData('2fa_enabled');
    }

    /**
     * @param string $column
     * @param int $amount
     * @param array $extra
     * @return bool|int
     */
    public function increment($column, $amount = 1, array $extra = []): bool|int
    {
        $result = parent::increment($column, $amount, $extra);
        if($column == 'balance') BalanceUpdated::dispatch($this);
        return $result;
    }

    /**
     * @param string $column
     * @param int $amount
     * @param array $extra
     * @return bool|int
     */
    protected function decrement($column, $amount = 1, array $extra = []): bool|int
    {
        $result = parent::decrement($column, $amount, $extra);
        if($column == 'balance') BalanceUpdated::dispatch($this);
        return $result;
    }


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

    public function introducer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reference_id');
    }

    public function introduced(): HasMany
    {
        return $this->hasMany(User::class, 'reference_id','id');
    }

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(Plan::class)
            ->withPivot([
                'discount_id','discount_price','price_after_discount',
                'id','remaining_user_count','active','invoice_id','plan_traffic',
                'plan_title','plan_users_count','plan_duration','plan_price','plan_sell_price'
            ])
            ->using(PlanUser::class)
            ->as('planUser')->withTimestamps();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function cart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function authTokens(): HasMany
    {
        return $this->hasMany(AuthToken::class);
    }

    public function discount(): HasMany
    {
        return $this->hasMany(Discount::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function vouchers(): HasMany
    {
        return $this->hasMany(Voucher::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * return user sessions
     * @return HasMany
     */
    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class);
    }

    public function isManager(): bool
    {
        return $this->hasRole('manager');
    }


    public function isSupport(): bool
    {
        return $this->hasRole('support');
    }

    public function isAgent(): bool
    {
        return $this->hasRole('agent');
    }

    public function isClient(): bool
    {
        return $this->hasRole('client');
    }

    public function clients()
    {
        return $this->introduced()->role('client')->get();
    }

    public function agents()
    {
        return $this->introduced()->role('agent')->get();
    }

    public function layer(): BelongsTo
    {
        return $this->belongsTo(Layer::class);
    }

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    public function supportTickets(){
        return $this->hasMany(Ticket::class,'assigned_to_user_id');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName($this->full_name)->logOnlyDirty()->logExcept(['delete']);
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

    /**
     * Retrieves a user role name or role [ parameter ] if it is not null
     * @param $parameter
     * @return mixed
     */
    public function getRole($parameter = null): mixed
    {
        $role = $this->roles()->first()?->toArray();
        if ($role == null){
            return null;
        }
        $result = $role['name'];

        if ($parameter != null)
            try {
                $result = $role[$parameter];
            } catch (\Exception $ignored) {
            }

        return $result;
    }

    /**
     * Retrieves current user agents references
     * @return array
     */
    public function getReferences($maxStep = 0, $currentStep = 0): array
    {
        if(!$this->isAgent() || $maxStep == 0) {
            # return empty if it is not an agent
            return [];
        }

        $children = [];

        if($this->agents()->count() > 0) {
            # It has children, let's get them.
            $children[] = ($this->agents()->map(function (User $reference) use ($children, $maxStep, $currentStep) {
                # Add the child to the list of children, and get its sub-children
                if($maxStep > $currentStep) {
                    if($this->agents()->count()) {
                        $sub_children = $reference->getReferences($maxStep, $currentStep + 1);
                        $references = [];
                        $key = 0;
                        if(count($sub_children) > 0) {
                            $sub_children = $sub_children[0];
                        }
                        foreach ($sub_children as $sub_child) {
                            if($sub_child != []) {
                                $references[] = $sub_child;
                            }
                        }
                        $reference->references = $references;
                    } else {
                        $reference->references = [];
                    }
                    return $reference;
                }
                return [];
            })->toArray());
        }

        return $children;
    }


    public static function generateUsername(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $uniqueUsername = '';
        do{
            for ($i = 0; $i < 6; $i++) {
                $uniqueUsername .= $characters[rand(0, $charactersLength - 1)];
            }
        }while(User::where('username',$uniqueUsername)->first());
        return 'sv'.$uniqueUsername;
    }

    public static function generateInviteCode(): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $uniqueInviteCode = '';
        do{
            for ($i = 0; $i < 6; $i++) {
                $uniqueInviteCode .= $characters[rand(0, $charactersLength - 1)];
            }
        }while(User::where('invite_code',$uniqueInviteCode)->first());
        return strtoupper($uniqueInviteCode);
    }


    public static function generatePassword(): string
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $password = '';
        for ($i = 0; $i < 6; $i++) {
            $password .= $characters[rand(0, $charactersLength - 1)];
        }
        return $password;
    }


    public function isUserAllowedToBuy(Plan $plan): bool
    {
        if (!$this->isAgent() && !config('app.debug')){
            return false;
        }
        $planUsers = PlanUser::getActivePlanUsers($this);
        if (in_array($plan->id,$planUsers->pluck('plan_id')->toArray())){
            return false;
        }
        return true;
    }


    public function isUserAllowedToAddToCart(Plan $plan): bool
    {
        if (!$this->isAgent() && !config('app.debug')){
            return false;
        }
        $carts = $this->cart()->where('plan_id',$plan->id)->get();
        if ($carts->count()) {
           return false;
        }
        return $this->isUserAllowedToBuy($plan);
    }

    /**
     * recognize the notification icon base on notification type
     * @param DatabaseNotification $notification
     * @return string
     */
    public static function getNotificationStatusIcon(DatabaseNotification $notification): string
    {
        switch ($notification->data['type']){
            case 'success' : {
                return 'fa-square-check';
                break;
            }
            case 'info' : {
                return 'fa-square-info';
                break;
            }
            case 'warning' : {
                return 'fa-square-exclamation';
                break;
            }
            case 'danger' : {
                return 'fa-square-xmark';
                break;
            }
        }
        return 'fa-square-info';
    }

    /**
     * return profile link based on the tab and user role
     * @param string $route
     * @return string
     */
    public function getProfileLink(string $route = 'overview'): string
    {
        try {
            if ($this->isManager())
                return route('managers.'.$route,$this);
            if ($this->isAgent())
                return route('agents.'.$route,$this);
            if ($this->isClient())
                return route('clients.'.$route,$this);
        }catch (\Exception $ignored){}
        return route('dashboard');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification()); // my notification
    }


    public function trafficUsages(): HasMany {
        return $this->hasMany(TrafficUsage::class);
    }

    public function subscriptions(): ?HasMany {
        if(!$this->isClient()) {
            return null;
        }
        return $this->hasMany(Subscription::class);
    }

    /**
     * get current subscription that client is using, it may ran out of traffic or time
     * @return Subscription|HasMany|null
     */
    public function getCurrentSubscription(): Subscription|HasMany|null {
        return $this->subscriptions()?->where('using',true)->where('ends_at', '>' , now())?->latest()?->first();
    }

    /**
     * check whether client has an active subscription with traffic and time
     * @return bool
     */
    public function hasActiveSubscription(): bool {
        $currentSub = $this->getCurrentSubscription();
        if($currentSub != null && $currentSub->ends_at > now()) {
            return true;
        }
        return false;
    }

    /**
     * get the reserved subscription if exist
     * @return Subscription|HasMany|null
     */
    public function getReservedSubscription(): Subscription|HasMany|null {
        return $this->subscriptions()->where('using',false)->whereNull('starts_at')->whereNull('ends_at')->latest()->first();
    }

    /**
     * return the status of sending email to user based on their email preferences
     * @param string $type
     * @return bool
     */
    public function wantToReceiveEmail(string $type): bool {
        $email_preferences = json_decode($this->getData('email_preferences'), true);
        if (!$this->getData('email_subscription') || (!is_null($email_preferences) && isset($email_preferences[$type]))){
            return false;
        }
        return true;
    }

    /**
     * generate unsubscribe link for emails
     * @return string
     */
    public function generateUnsubscribeLink(): string {
        return \Illuminate\Support\Facades\URL::signedRoute('email.unsubscribe',['email' => $this->email,'salt' => rand(1000000,9999999)]);
    }

    public function resetTraffic(): bool
    {
        if (!$this->isClient()){
            return false;
        }
        $inbound = new \App\Models\Inbound();
        $inbound->resetClientTraffic($this);
        return true;
    }

    public function trafficUsage(): int {
        if (!$this->isClient()){
            return false;
        }
        $inbound = new \App\Models\Inbound();
        $inbound->layer($this->layer_id);
        /** @var ClientTraffic $clientTraffic */
        $clientTraffic = $inbound->where('port',2095)->first()->clientTraffics()->where('email', 'LIKE', '%'.$this->uuid)->first();
//        dd($this,$inbound->where('port',2095)->first()->clientTraffics()->pluck('email'));
        return $clientTraffic?->up + $clientTraffic?->down;
    }

    public function trafficUploadUsage(): int {
        if (!$this->isClient()){
            return false;
        }
        $inbound = new \App\Models\Inbound();
        $inbound->layer($this->layer_id);
        /** @var ClientTraffic $clientTraffic */
        $clientTraffic = $inbound->where('port',2095)->first()->clientTraffics()->where('email', 'LIKE', '%'.$this->uuid)->first();
        return $clientTraffic?->up ?? 0;
    }

    public function trafficDownloadUsage(): int {
        if (!$this->isClient()){
            return false;
        }
        $inbound = new \App\Models\Inbound();
        $inbound->layer($this->layer_id);
        /** @var ClientTraffic $clientTraffic */
        $clientTraffic = $inbound->where('port',2095)->first()->clientTraffics()->where('email', 'LIKE', '%'.$this->uuid)->first();
        return $clientTraffic?->down ?? 0;
    }


    public function activeConnections(): bool
    {
        if (!$this->isClient()){
            return false;
        }
        $inbound = new \App\Models\Inbound();
        $inbound->layer($this->layer->id);
        $inbound->changeUserActivation($this,true);

        return true;
    }


    public function deactivateConnections(): bool
    {
        if (!$this->isClient()){
            return false;
        }
        $inbound = new \App\Models\Inbound();
        $inbound->layer($this->layer->id);
        $inbound->changeUserActivation($this,false);
        return true;
    }


    public function deleteInbounds(): bool
    {
        if (!$this->isClient()){
            return false;
        }
        $inbound = new \App\Models\Inbound();
        $inbound->layer($this->layer->id);
        $inbound->deleteUserInbound($this);
        return true;
    }


    public function resetTrafficAndActiveConnections(): bool
    {
        if (!$this->isClient()){
            return false;
        }
        $this->resetTraffic();
        $this->activeConnections();

        return true;
    }

    /**
     * return whether client introducer is solidvpn_sales or not
     * @return bool
     */
    public function isSolidClient(): bool
    {
        return $this->introducer?->id == self::where('username','solidvpn_sales')->first()?->id;
    }

    public function inviter(): BelongsTo
    {
        return $this->belongsTo(self::class,'invited_by');
    }

    public function invited(): HasMany
    {
        return $this->hasMany(self::class,'invited_by');
    }

    public static function getIntroducerByLevel(User $user,$level = 1){
        if ($level == 0){
            return $user;
        }
        if (is_null($user->introducer)){
            return null;
        }
        return self::getIntroducerByLevel($user->introducer,$level - 1);
    }

    public function resetUUID(?string $uuid = null){
        $inbound = new \App\Models\Inbound();
        $inbound->changeClientUUID($this,$uuid ?? \Str::uuid());
        $this->uuid = $uuid;
        $this->save();
    }

    public static function addSubscriptionEndTime() {
        foreach (self::role('client')->get() as $client) {
            /** @var User $client */
            if(!$client->isClient()) {
                continue;
            }
            /** @var Subscription $lastSubscription */
            $lastSubscription = $client->subscriptions()->whereNotNull('ends_at')->latest()->first();
            if($lastSubscription != null && $lastSubscription->ends_at >= now()->subDays(12)) {
                $lastSubscription->using = true;
                $lastSubscription->ends_at = now()->addDays(12);
                $lastSubscription->save();
            }
        }
    }

}
