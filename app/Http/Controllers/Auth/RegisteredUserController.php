<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessReferralAcceptance;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create(Request $request)
    {
        return Inertia::render('Auth/Register', [
            'code' => $request->code
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        /**
         * Decrypt Code get referred by user.
         */
        $referredBy = null;

        if(!empty($request->code)) {
            $referredByEmail = Crypt::decryptString($request->code);

            if(!empty($referredByEmail)) {
                $referredBy  = User::where('email', $referredByEmail)->first();
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if(!empty($referredBy)) {
            /**
             * Create a referral if it's not exist or get existing one.
             */
            $referral = $referredBy->referrals()->firstOrCreate([
                'email' => $user->email,
            ]);

            /**
             * Update Referral
             */
            $referral->status = 3;
            $referral->user_id = $user->id;
            $referral->save();

            /**
             * Dispatch referral acceptance job.
             */
            ProcessReferralAcceptance::dispatch($referral, $referredBy);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
