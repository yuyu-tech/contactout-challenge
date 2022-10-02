<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the referrals for the user.
     */
    public function referrals() {
        return $this->hasMany(Referral::class, 'referred_by');
    }

    /**
     * Get Referral Points
     */
    public function getReferralPointsAttribute()
    {
        $enrolledReferralsCount = $this->referrals()->where('status', 3)->count();

        return $enrolledReferralsCount > 0 ? 10 : $enrolledReferralsCount;
    }
    /**
     * Get First Name
     */
    public function getFirstNameAttribute() {
        $arrName = explode(' ', $this->name);

        if(count($arrName) > 0) {
            array_pop($arrName);
        }

        return implode(' ', $arrName);
    }
}
