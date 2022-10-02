<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    /**
     * Referral's Statuses
     */
    public static $status = [
        1 => 'Pending',
        2 => 'Invitation Sent',
        3 => 'Enrolled'
    ];

    /**
     * Fillable entities
     */
    protected $fillable = [
        'email',
        'status'
    ];

    /**
     * Get Referred By User.
     */
    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }
}
