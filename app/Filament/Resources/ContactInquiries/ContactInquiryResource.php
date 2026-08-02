<?php

namespace App\Filament\Resources\ContactInquiries;

use App\Filament\Resources\ContactInquiries\Pages\ListContactInquiries;
use App\Filament\Resources\ContactInquiries\Pages\ViewContactInquiry;
use App\Models\ContactInquiry;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\ActionGroup;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;

class ContactInquiryResource extends Resource
{
    protected static ?string $model = ContactInquiry::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?string $navigationLabel = 'Contact Inquiries';

    protected static string|UnitEnum|null $navigationGroup = 'Site Content';

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        return (string) ContactInquiry::where('status', 'new')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function form(Schema $schema): Schema
    {
        // Read-only infolist-style view; no direct create form needed
        return $schema->components([]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Sender Details')
                ->schema([
                    Grid::make(2)->schema([
                        TextEntry::make('name')->label('Full Name')->weight('bold'),
                        TextEntry::make('email')
                            ->label('Email Address')
                            ->copyable()
                            ->color('primary'),
                    ]),
                    Grid::make(2)->schema([
                        TextEntry::make('phone')->label('Phone')->placeholder('—'),
                        TextEntry::make('service')->label('Service Requested')->placeholder('—'),
                    ]),
                ])
                ->columnSpanFull(),

            Section::make('Message')
                ->schema([
                    TextEntry::make('message')
                        ->label('')
                        ->prose()
                        ->columnSpanFull(),
                ])
                ->columnSpanFull(),

            Section::make('Metadata')
                ->schema([
                    Grid::make(3)->schema([
                        TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'new'      => 'danger',
                                'read'     => 'warning',
                                'replied'  => 'success',
                                'archived' => 'gray',
                                default    => 'gray',
                            }),
                        TextEntry::make('created_at')->label('Received At')->dateTime('M j, Y \a\t h:i A'),
                        TextEntry::make('read_at')->label('First Read At')->dateTime('M j, Y \a\t h:i A')->placeholder('—'),
                    ]),
                ])
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('service')
                    ->label('Service')
                    ->badge()
                    ->color('primary')
                    ->placeholder('—'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new'      => 'danger',
                        'read'     => 'warning',
                        'replied'  => 'success',
                        'archived' => 'gray',
                        default    => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('message')
                    ->label('Message')
                    ->limit(60)
                    ->tooltip(fn ($record) => $record->message),
                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('M j, Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'new'      => 'New',
                        'read'     => 'Read',
                        'replied'  => 'Replied',
                        'archived' => 'Archived',
                    ]),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    Action::make('mark_read')
                        ->label('Mark as Read')
                        ->icon('heroicon-o-eye')
                        ->color('warning')
                        ->visible(fn ($record) => $record->status === 'new')
                        ->action(fn ($record) => $record->markAsRead()),
                    Action::make('mark_replied')
                        ->label('Mark as Replied')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn ($record) => in_array($record->status, ['new', 'read']))
                        ->action(fn ($record) => $record->update(['status' => 'replied'])),
                    Action::make('archive')
                        ->label('Archive')
                        ->icon('heroicon-o-archive-box')
                        ->color('gray')
                        ->visible(fn ($record) => $record->status !== 'archived')
                        ->action(fn ($record) => $record->update(['status' => 'archived'])),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContactInquiries::route('/'),
            'view'  => ViewContactInquiry::route('/{record}'),
        ];
    }
}
