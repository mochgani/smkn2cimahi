<?php

namespace App\Filament\Resources\Beritas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class BeritasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->label('Cover')
                    ->disk('public')
                    ->square()
                    ->size(50),

                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->limit(60)
                    ->wrap(),

                TextColumn::make('kategoris.name')
                    ->label('Kategori')
                    ->badge()
                    ->separator(','),

                TextColumn::make('approval_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'approved' => 'success',
                        'pending'  => 'warning',
                        'rejected' => 'danger',
                        default    => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'approved' => 'Approved',
                        'pending'  => 'Menunggu',
                        'rejected' => 'Ditolak',
                        default    => 'Draft',
                    }),

                IconColumn::make('is_published')
                    ->label('Published')
                    ->boolean(),

                TextColumn::make('creator.name')
                    ->label('Dibuat oleh')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('published_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('approval_status')
                    ->label('Status Approval')
                    ->options([
                        'draft'    => 'Draft',
                        'pending'  => 'Menunggu Approval',
                        'approved' => 'Approved',
                        'rejected' => 'Ditolak',
                    ]),
                SelectFilter::make('kategoris')
                    ->relationship('kategoris', 'name')
                    ->multiple()
                    ->preload(),
                TernaryFilter::make('is_published')->label('Status Publikasi'),
                TernaryFilter::make('is_featured')->label('Featured'),
            ])
            ->recordActions([
                // Tombol Approve (hanya super_admin, hanya untuk status pending)
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn ($record) => Auth::user()?->isSuperAdmin()
                        && $record->approval_status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Berita')
                    ->modalDescription('Berita akan dipublish dan tampil di website.')
                    ->action(function ($record) {
                        $record->update([
                            'approval_status' => 'approved',
                            'is_published'    => true,
                            'approved_by'     => Auth::id(),
                            'approved_at'     => now(),
                            'published_at'    => $record->published_at ?? now(),
                        ]);
                    }),

                // Tombol Reject (hanya super_admin, hanya untuk status pending)
                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn ($record) => Auth::user()?->isSuperAdmin()
                        && $record->approval_status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Berita')
                    ->modalDescription('Berita akan ditolak dan tidak akan dipublish.')
                    ->action(function ($record) {
                        $record->update([
                            'approval_status' => 'rejected',
                            'is_published'    => false,
                        ]);
                    }),

                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc');
    }
}
