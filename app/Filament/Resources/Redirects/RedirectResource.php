<?php

namespace App\Filament\Resources\Redirects;

use App\Filament\Resources\Redirects\Pages\CreateRedirect;
use App\Filament\Resources\Redirects\Pages\EditRedirect;
use App\Filament\Resources\Redirects\Pages\ListRedirects;
use App\Models\Redirect;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowPath;

    protected static string|UnitEnum|null $navigationGroup = 'Site Content';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Redirect Configuration")
                    ->schema([
                        TextInput::make('old_url')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->placeholder('/old-url')
                            ->helperText('The old URL path (e.g. /about-us)'),
                        TextInput::make('new_url')
                            ->required()
                            ->placeholder('/new-url')
                            ->helperText('The new URL path (e.g. /about) or full destination URL'),
                        Select::make('status_code')
                            ->options([
                                301 => '301 - Permanent Redirect',
                                302 => '302 - Temporary Redirect',
                            ])
                            ->required()
                            ->default(301),
                        Toggle::make('is_active')
                            ->required()
                            ->default(true),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('old_url')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('new_url')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status_code')
                    ->badge()
                    ->color(fn(int $state): string => match ($state) {
                        301 => 'success',
                        302 => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\ActionGroup::make([
                    \Filament\Actions\EditAction::make(),
                    \Filament\Actions\DeleteAction::make(),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRedirects::route('/'),
            'create' => CreateRedirect::route('/create'),
            'edit' => EditRedirect::route('/{record}/edit'),
        ];
    }
}
