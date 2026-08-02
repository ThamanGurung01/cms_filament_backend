<?php

namespace App\Filament\Widgets;

use App\Models\ContactInquiry;
use App\Filament\Resources\ContactInquiries\ContactInquiryResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestInquiriesWidget extends BaseWidget
{
    protected static ?string $heading = 'Latest Inquiries';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 1;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                ContactInquiry::query()
                    ->whereNotNull('service')
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone number'),
                Tables\Columns\TextColumn::make('service')
                    ->label('Tour')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Action::make('markAsRead')
                    ->label('Mark as Read')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->hidden(fn (ContactInquiry $record): bool => $record->status === 'read' || $record->read_at !== null)
                    ->action(fn (ContactInquiry $record) => $record->markAsRead()),
                DeleteAction::make(),
            ])
            ->recordUrl(
                fn (ContactInquiry $record): string => ContactInquiryResource::getUrl('view', ['record' => $record]),
            );
    }
}
