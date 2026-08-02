<?php

namespace App\Filament\Resources\FilmingLocations;

use App\Filament\Resources\FilmingLocations\Pages\CreateFilmingLocation;
use App\Filament\Resources\FilmingLocations\Pages\EditFilmingLocation;
use App\Filament\Resources\FilmingLocations\Pages\ListFilmingLocations;
use App\Models\FilmingLocation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;

class FilmingLocationResource extends Resource
{
    protected static ?string $model = FilmingLocation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;

    protected static ?string $navigationLabel = 'Filming Locations';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'lg' => 3])
            ->components([
                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set, $record) => $record === null ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('tagline')
                            ->maxLength(255)
                            ->placeholder('e.g. Where Heaven Meets Earth'),
                        Select::make('region')
                            ->options([
                                'Himalayan'  => 'Himalayan',
                                'Hills'      => 'Hills & Valleys',
                                'Terai'      => 'Terai & Jungle',
                                'Historical' => 'Historical Sites',
                                'Urban'      => 'Urban / City',
                            ])
                            ->searchable(),
                        Textarea::make('short_description')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpan(['default' => 1, 'lg' => 2]),

                Section::make('Settings')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active / Visible')
                            ->default(true),
                        Toggle::make('is_featured')
                            ->label('Show on Homepage')
                            ->default(false),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        TextInput::make('map_x')
                            ->label('Map X Position (%)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->default(50)
                            ->suffix('%')
                            ->helperText('Horizontal position of the pin on the Nepal map'),
                        TextInput::make('map_y')
                            ->label('Map Y Position (%)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->default(50)
                            ->suffix('%')
                            ->helperText('Vertical position of the pin on the Nepal map'),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 1]),

                Section::make('Images')
                    ->schema([
                        FileUpload::make('hero_image')
                            ->label('Hero / Cover Image')
                            ->image()
                            ->directory('filming-locations/hero')
                            ->disk('public')
                            ->visibility('public')
                            ->columnSpanFull()
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth(1920)
                            ->imageResizeTargetHeight(1080),
                        FileUpload::make('gallery')
                            ->label('Gallery Images')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->directory('filming-locations/gallery')
                            ->disk('public')
                            ->visibility('public')
                            ->columnSpanFull()
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth(1600)
                            ->imageResizeTargetHeight(1066),
                    ])
                    ->columnSpanFull(),

                Section::make('Detailed Content')
                    ->schema([
                        RichEditor::make('where_is_it')
                            ->label('Where Is It?')
                            ->columnSpanFull(),
                        RichEditor::make('how_to_get_there')
                            ->label('How to Get There')
                            ->columnSpanFull(),
                        RichEditor::make('filming_highlights')
                            ->label('Filming Highlights & Tips')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('hero_image')
                    ->label('Image')
                    ->square()
                    ->size(50)
                    ->disk('public'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('region')
                    ->badge()
                    ->sortable(),
                IconColumn::make('is_featured')
                    ->label('Homepage')
                    ->boolean()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order')
            ->filters([])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListFilmingLocations::route('/'),
            'create' => CreateFilmingLocation::route('/create'),
            'edit'   => EditFilmingLocation::route('/{record}/edit'),
        ];
    }
}
