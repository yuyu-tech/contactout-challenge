<?php

namespace App\Http\Resources;

use App\Models\Referral;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReferralCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return ($this->collection->map(function($referral) {
            $referral->status = Referral::$status[$referral->status];
            $referral->modified_at = $referral->updated_at->format('m/d/Y H:i');

            return $referral->only(
                'id', 'email', 'modified_at', 'status'
            );
        }));
    }
}
