<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    public static $status = [
        1 => 'Pending',
        2 => 'Notified',
        3 => 'Created'
    ];

    /**
     * Get Referred By User.
     */
    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }
}
