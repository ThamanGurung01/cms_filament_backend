<?php

namespace App\Filament\Resources\Testimonials;

use App\Filament\Resources\Testimonials\Pages\CreateTestimonial;
use App\Filament\Resources\Testimonials\Pages\EditTestimonial;
use App\Filament\Resources\Testimonials\Pages\ListTestimonials;
use App\Models\Testimonial;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use UnitEnum;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-star';

    protected static ?string $recordTitleAttribute = 'client_name';
    
    protected static string|UnitEnum|null $navigationGroup = 'Site Content';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'lg' => 3])
            ->components([
                Section::make('Client Information')
                    ->schema([
                        TextInput::make('client_name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set, $record) => $record === null ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        FileUpload::make('client_logo')
                            ->image()
                            ->directory('testimonials/logos')
                            ->disk('public')
                            ->visibility('public')
                            ->imageResizeMode('contain')
                            ->imageResizeTargetWidth(300)
                            ->imageResizeTargetHeight(200),
                        TextInput::make('author_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('author_role')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('region')
                            ->maxLength(255),
                        TextInput::make('industry')
                            ->maxLength(255),
                    ])
                    ->columns(2)
                    ->columnSpan(['default' => 1, 'lg' => 2]),

                Section::make('Settings')
                    ->schema([
                        Toggle::make('is_featured')
                            ->label('Show on Homepage')
                            ->default(false),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->default(true),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 1]),

                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('SEO Title')
                            ->placeholder('Defaults to client name if empty'),
                        Textarea::make('meta_description')
                            ->label('SEO Description')
                            ->rows(3)
                            ->placeholder('Meta description for search engines'),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 1]),

                Section::make('The Testimonial')
                    ->schema([
                        RichEditor::make('quote')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('video_url')
                            ->label('Video Testimonial URL')
                            ->url()
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->hint('Paste YouTube link or direct video path here.')
                            ->columnSpanFull(),
                        FileUpload::make('featured_image')
                            ->image()
                            ->directory('testimonials/featured')
                            ->disk('public')
                            ->visibility('public')
                            ->columnSpanFull()
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth(1200)
                            ->imageResizeTargetHeight(800),
                    ])
                    ->columnSpanFull(),

                Section::make('Production Record')
                    ->schema([
                        TextInput::make('client_description')
                            ->label('Client Description')
                            ->placeholder('Global pharmaceutical & healthcare company')
                            ->columnSpanFull(),
                        TextInput::make('project_type')
                            ->label('Project Type')
                            ->placeholder('Healthcare Documentary'),
                        TextInput::make('project_description')
                            ->label('Project Description')
                            ->placeholder('Focused on frontline healthcare workers'),
                        TextInput::make('primary_location')
                            ->label('Primary Location')
                            ->placeholder('Pokhara, Nepal'),
                        TextInput::make('location_description')
                            ->label('Location Description')
                            ->placeholder('Lakeside district & surrounding region'),
                        TextInput::make('services_scope')
                            ->label('Services Scope')
                            ->placeholder('Full Fixer Package'),
                        TextInput::make('services_description')
                            ->label('Services Description')
                            ->placeholder('Budgeting, equipment, local crew coordination'),
                        TextInput::make('verification_type')
                            ->label('Verification Type')
                            ->placeholder('Authenticated Letter'),
                        TextInput::make('verification_description')
                            ->label('Verification Description')
                            ->placeholder('Original signed document on file'),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make('Full Letter / Testimonial')
                    ->schema([
                        RichEditor::make('case_study_content')
                            ->columnSpanFull()
                            ->hint('Optional: Detailed story for the case study page.'),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('client_logo')
                    ->label('Logo')
                    ->square()
                    ->size(40)
                    ->disk('public'),
                TextColumn::make('client_name')
                    ->label('Client')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('author_name')
                    ->label('Author')
                    ->searchable(),
                IconColumn::make('is_featured')
                    ->label('Home')
                    ->boolean()
                    ->sortable(),
                IconColumn::make('is_published')
                    ->label('Status')
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
            'index' => ListTestimonials::route('/'),
            'create' => CreateTestimonial::route('/create'),
            'edit' => EditTestimonial::route('/{record}/edit'),
        ];
    }
}
