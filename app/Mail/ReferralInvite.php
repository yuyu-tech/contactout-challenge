<?php

namespace App\Mail;

use App\Models\Referral;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReferralInvite extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Referral
     *
     * @var Referral
     */
    protected $referral;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Referral $referral)
    {
        $this->referral = $referral;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $referredBy = $this->referral->referredBy;

        /**
         * Update status of referral
         */
        $this->referral->status = 2;
        $this->referral->save();

        return $this->subject($referredBy->first_name .' recommends ' .config('app.name'))
                ->markdown('emails.referral.invite', [
                    'firstName' => $referredBy->first_name,
                    'referLink' => route('register', ['code' => Crypt::encryptString($referredBy->email)])
                ]);
    }
}
