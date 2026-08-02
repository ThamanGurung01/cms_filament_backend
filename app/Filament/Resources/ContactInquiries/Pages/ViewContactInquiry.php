<?php

namespace App\Filament\Resources\ContactInquiries\Pages;

use App\Filament\Resources\ContactInquiries\ContactInquiryResource;
use Filament\Resources\Pages\ViewRecord;

class ViewContactInquiry extends ViewRecord
{
    protected static string $resource = ContactInquiryResource::class;

    protected function mutateRecordDataBeforeFill(array $data): array
    {
        // Auto-mark as read when the admin opens the record
        $this->record->markAsRead();
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('mark_replied')
                ->label('Mark as Replied')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn () => in_array($this->record->status, ['new', 'read']))
                ->action(fn () => $this->record->update(['status' => 'replied'])),

            \Filament\Actions\Action::make('archive')
                ->label('Archive')
                ->icon('heroicon-o-archive-box')
                ->color('gray')
                ->visible(fn () => $this->record->status !== 'archived')
                ->action(fn () => $this->record->update(['status' => 'archived'])),

            \Filament\Actions\DeleteAction::make(),
        ];
    }
}
