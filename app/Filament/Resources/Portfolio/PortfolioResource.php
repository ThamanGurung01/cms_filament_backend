<?php

namespace App\Filament\Resources\Portfolio;

use App\Filament\Resources\Portfolio\Pages\CreatePortfolioItem;
use App\Filament\Resources\Portfolio\Pages\EditPortfolioItem;
use App\Filament\Resources\Portfolio\Pages\ListPortfolioItems;
use App\Models\PortfolioItem;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class PortfolioResource extends Resource
{
    protected static ?string $model = PortfolioItem::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedVideoCamera;

    protected static ?string $navigationLabel = 'Portfolio';

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?string $modelLabel = 'Portfolio Item';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'lg' => 2])
            ->components([
                Section::make('Project Details')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('client')
                            ->required()
                            ->maxLength(255)
                            ->label('Client / Brand'),

                        TextInput::make('type')
                            ->required()
                            ->maxLength(255)
                            ->label('Project Type')
                            ->placeholder('e.g. Documentary, Commercial, TV Series'),

                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->label('Sort Order'),
                    ])
                    ->columnSpan(1),

                Section::make('Media')
                    ->schema([
                        TextInput::make('video_url')
                            ->required()
                            ->url()
                            ->label('Video URL')
                            ->placeholder('YouTube URL or direct MP4 link')
                            ->columnSpanFull(),

                        TextInput::make('thumbnail_url')
                            ->required()
                            ->url()
                            ->label('Thumbnail URL')
                            ->placeholder('Direct image URL for the thumbnail')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(1),

                Section::make('Visibility')
                    ->schema([
                        Toggle::make('is_featured')
                            ->label('Show on Homepage')
                            ->helperText('Featured items appear in the homepage "Featured Productions" grid (first 6).')
                            ->default(false),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->helperText('Inactive items are hidden everywhere.')
                            ->default(true),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail_url')
                    ->label('Thumbnail')
                    ->width(80)
                    ->height(50)
                    ->extraImgAttributes(['style' => 'object-fit: cover; border-radius: 6px;']),

                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('client')
                    ->searchable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('type')
                    ->limit(20)
                    ->color('gray'),

                IconColumn::make('is_featured')
                    ->label('Homepage')
                    ->boolean(),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([])
            ->recordActions([
                \Filament\Actions\ActionGroup::make([
                    EditAction::make(),
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
            'index'  => ListPortfolioItems::route('/'),
            'create' => CreatePortfolioItem::route('/create'),
            'edit'   => EditPortfolioItem::route('/{record}/edit'),
        ];
    }
}
