<?php

namespace App\Filament\Resources\ReferralResource\Pages;

use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ReferralResource;
use App\Models\Referral;

class ListReferrals extends ListRecords
{
    protected static string $resource = ReferralResource::class;

    /**
     * Get table records per page select options
     *
     * @return array
     */
    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
    }


    /**
     * Is table searchable
     *
     * @return bool
     */
    public function isTableSearchable(): bool
    {
        return true;
    }

    /**
     * Apply Global Search query
     *
     * @param Builder $query
     * @return Builder
     */
    protected  function applySearchToTableQuery(Builder $query): Builder
    {
        if (filled($searchQuery = $this->getTableSearchQuery())) {
            $query->where('email', 'like', '%' .$searchQuery .'%');
        }

        return $query;
    }
}
