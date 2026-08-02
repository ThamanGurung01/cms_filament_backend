<?php

namespace App\Filament\Resources\SlugSeos;

use App\Filament\Resources\SlugSeos\Pages\CreateSlugSeo;
use App\Filament\Resources\SlugSeos\Pages\EditSlugSeo;
use App\Filament\Resources\SlugSeos\Pages\ListSlugSeos;
use App\Models\SlugSeo;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class SlugSeoResource extends Resource
{
    protected static ?string $model = SlugSeo::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedMagnifyingGlass;

    protected static ?string $navigationLabel = 'SEO (by Slug)';

    protected static ?string $modelLabel = 'SEO Entry';

    protected static ?string $pluralModelLabel = 'SEO Entries';

    protected static string|UnitEnum|null $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema

            ->components([
                Section::make('SEO Content')
                    ->description('Manage the search engine appearance for this URL.')
                    ->schema([
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(table: 'slug_seos', column: 'slug', ignoreRecord: true)
                            ->placeholder('/')
                            ->helperText('The URL path this SEO should apply to (e.g., /tours, /, /contact)')
                            ->live(onBlur: true),

                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->live(),

                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->rows(4)
                            ->live(),

                        TagsInput::make('meta_keywords')
                            ->label('Meta Keywords')
                            ->separator(',')
                            ->placeholder('New tag'),

                        Placeholder::make('seo_preview')
                            ->label('Search Engine Preview')
                            ->content(function ($get) {
                                return view('filament.components.seo-preview', [
                                    'title' => $get('meta_title') ?? '',
                                    'description' => $get('meta_description') ?? '',
                                    'slug' => $get('slug') ?? '/',
                                ]);
                            })
                            ->columnSpanFull(),

                    ])
                    ->columnSpanFull()
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('slug')
                    ->label('URL Path')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono')
                    ->color('gray'),

                TextColumn::make('meta_title')
                    ->label('Meta Title')
                    ->searchable()
                    ->limit(50)
                    ->placeholder('—'),

                TextColumn::make('meta_description')
                    ->label('Meta Description')
                    ->limit(60)
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->since()
                    ->sortable(),
            ])
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
            ])
            ->defaultSort('slug');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListSlugSeos::route('/'),
            'create' => CreateSlugSeo::route('/create'),
            'edit'   => EditSlugSeo::route('/{record}/edit'),
        ];
    }
}
