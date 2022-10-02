<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Referral;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ReferralResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ReferralResource\RelationManagers;

class ReferralResource extends Resource
{
    /**
     * Resource Model
     *
     * @var string
     */
    protected static ?string $model = Referral::class;

    /**
     * Navigation Icon
     *
     * @var string
     */
    protected static ?string $navigationIcon = 'heroicon-s-user-add';

    /**
     * table configuration
     *
     * @param Table $table
     * @return Table
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email'),
                TextColumn::make('referredBy.name')
                    ->label('Referred By'),
                TextColumn::make('status')->enum(Referral::$status)
            ])
            ->filters([
                SelectFilter::make('Referred By')->relationship('referredBy', 'name'),
                SelectFilter::make('status')
                    ->options(Referral::$status)
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    /**
     * Get pages
     *
     * @return array
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReferrals::route('/'),
        ];
    }
}
