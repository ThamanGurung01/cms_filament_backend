<?php

namespace App\Filament\Resources\ActivityLogs;

use App\Filament\Resources\ActivityLogs\Pages\ListActivityLogs;
use App\Filament\Resources\ActivityLogs\Pages\ViewActivityLog;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Models\Activity;
use BackedEnum;
use UnitEnum;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Activity Log';

    protected static ?string $modelLabel = 'Activity Log';

    protected static ?string $pluralModelLabel = 'Activity Logs';

    protected static UnitEnum|string|null $navigationGroup = 'Administration';

    protected static ?int $navigationSort = 2;

    /**
     * Only superadmins can access Activity Log.
     */
    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user?->isSuperAdmin() || $user?->isAdmin();
    }

    /**
     * Activity logs are read-only — no create/edit forms.
     */
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Activity Details')
                    ->schema([
                        TextInput::make('causer_name')
                            ->label('User')
                            ->formatStateUsing(fn ($record) => $record?->causer?->name ?? 'System')
                            ->disabled(),
                        TextInput::make('event')
                            ->label('Event')
                            ->disabled(),
                        TextInput::make('subject_type')
                            ->label('Resource Type')
                            ->formatStateUsing(fn(?string $state): string => $state ? class_basename($state) : '—')
                            ->disabled(),
                        TextInput::make('subject_id')
                            ->label('Resource ID')
                            ->disabled(),
                        DateTimePicker::make('created_at')
                            ->label('Date')
                            ->disabled(),
                    ])
                    ->columns(2),
                Section::make('Changes')
                    ->schema([
                        KeyValue::make('properties.old')
                            ->label('Old Values')
                            ->disabled()
                            ->visible(fn($record) => $record && isset($record->properties['old'])),
                        KeyValue::make('properties.attributes')
                            ->label('New Values')
                            ->disabled()
                            ->visible(fn($record) => $record && isset($record->properties['attributes'])),
                    ])
                    ->columns(1),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('causer.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->default('System'),
                TextColumn::make('event')
                    ->label('Event')
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'info',
                        'deleted' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->limit(60)
                    ->searchable(),
                TextColumn::make('subject_type')
                    ->label('Resource')
                    ->formatStateUsing(fn(?string $state): string => $state ? class_basename($state) : '—')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('M d, Y H:i:s')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('event')
                    ->options([
                        'created' => 'Created',
                        'updated' => 'Updated',
                        'deleted' => 'Deleted',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Eager load the polymorphic relations to avoid N+1 query performance issues
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['causer', 'subject']);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivityLogs::route('/'),
            'view' => ViewActivityLog::route('/{record}'),
        ];
    }
}
