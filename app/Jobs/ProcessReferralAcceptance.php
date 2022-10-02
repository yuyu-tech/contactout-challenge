<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Referral;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessReferralAcceptance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Referral
     *
     * @var Referral
     */
    protected $referral;

    /**
     * Referred By
     *
     * @var User
     */
    protected $referredBy;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Referral $referral, User $referredBy)
    {
        $this->referral = $referral;
        $this->referredBy = $referredBy;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Credit Points to Referred By account and notify to user.
    }
}
