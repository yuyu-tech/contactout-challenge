<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Jobs\ProcessReferrals;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use App\Http\Resources\ReferralCollection;

class ReferralController extends Controller
{
    /**
     * Referral Home Page
     *
     * @param Request $request
     */
    public function index(Request $request)
    {
        return Inertia::render('Referrals/Index', [
            'referrals' => new ReferralCollection(
                $request->user()->referrals()
                    ->orderBy('updated_at', 'desc')
                    ->paginate()
                    ->appends($request->all())
            ),
            'referral_points' => $request->user()->referral_points
        ]);
    }

    /**
     * Store Referrals
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $rules =[
            'emails' => [
                'required',
                'array'
            ],
        ];

        $request->validate($rules);

        /**
         * Dispatch job to process emails.
         */
        ProcessReferrals::dispatch($request->emails, $request->user());

        /**
         * Redirect to referrals page with success messace
         */
        return Redirect::route('referrals')->with('success', 'Contact updated.');;
    }
}
