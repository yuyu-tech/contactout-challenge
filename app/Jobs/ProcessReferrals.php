<?php

namespace App\Jobs;

use App\Mail\ReferralInvite;
use App\Models\User;
use App\Models\Referral;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Mail;

class ProcessReferrals implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Emails
     *
     * @var array
     */
    protected $emails;

    /**
     * Auth User
     *
     * @var User
     */
    protected $authUser;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $emails, User $authUser)
    {
        $this->emails = $emails;
        $this->authUser = $authUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach($this->emails as $email) {
            /**
             * Skip email if it's not valid
             */
            $validator = Validator::make(['email' => $email], [
                'email' => 'required|email:rfc,dns',
            ]);

            if ($validator->fails()) {
                continue;
            }

            /**
             * Email should not be part of existing users & referrals database.
             */

            if( User::where('email', $email)->count() > 0
                || Referral::where('email', $email)->count() > 0
            ) {
                continue;
            }

            /**
             * Create a Referral.
             */
            $referral = $this->authUser->referrals()->create([
                'email' => $email,
            ]);

            /**
             * Send referral invite
             */
            Mail::to($email)->send(new ReferralInvite($referral));
        }
    }
}
