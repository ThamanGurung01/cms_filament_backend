<?php

namespace App\Filament\Resources\MenuResource;

use App\Filament\Resources\MenuResource\Pages;
use App\Models\Menu;
use BackedEnum;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;
use UnitEnum;

class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-bars-4';

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Menu Details')->schema([
                    TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn(string $operation, $state, callable $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                    TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),
                ])->columns(2),

                Section::make('Menu Items')->schema([
                    Repeater::make('items')
                        ->label('Items')
                        ->schema([
                            TextInput::make('label')->required(),
                            TextInput::make('url')->label('URL / Route Route')->required(),
                            Select::make('target')
                                ->options([
                                    '_self' => 'Same Window',
                                    '_blank' => 'New Tab',
                                ])->default('_self')->required(),

                            Repeater::make('children')
                                ->label('Submenu Items')
                                ->schema([
                                    TextInput::make('label')->required(),
                                    TextInput::make('url')->label('URL / Route')->required(),
                                    Select::make('target')
                                        ->options([
                                            '_self' => 'Same Window',
                                            '_blank' => 'New Tab',
                                        ])->default('_self')->required(),
                                ])
                                ->collapsible()
                                ->itemLabel(fn(array $state): ?string => $state['label'] ?? null),
                        ])
                        ->collapsible()
                        ->itemLabel(fn(array $state): ?string => $state['label'] ?? null)
                        ->reorderableWithButtons()
                ])
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('slug')->searchable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
