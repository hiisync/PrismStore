<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'steam_id',
        'avatar',
        'balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'steam_id';
    }

    public function getPermissionArray()
    {
        return $this->getAllPermissions()->mapWithKeys(function ($pr) {
            return [$pr['name'] => true];
        });
    }

    /**
     * Get the orders associated with this user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Deposit the given amount to this user's balance and save the user.
     *
     * @param  int  $amount The amount to deposit in cents
     */
    public function deposit(int $amount): void
    {
        $this->balance += $amount;
        $this->save();
    }

    /**
     * Withdraw the given amount from this user's balance and save the user.
     * Throws an exception if the user does not have sufficient balance.
     *
     * @param  int  $amount The amount to withdraw in cents
     *
     * @throws \Exception if the user does not have sufficient balance to withdraw the given amount.
     */
    public function withdraw(int $amount): void
    {
        if ($this->balance >= $amount) {
            $this->balance -= $amount;
            $this->save();
        }
    }

    /**
     * Get the payments associated with this user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany A relation representing the user's payments
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
