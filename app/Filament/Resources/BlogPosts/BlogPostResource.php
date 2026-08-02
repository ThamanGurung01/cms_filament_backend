<?php

namespace App\Filament\Resources\BlogPosts;

use App\Filament\Resources\BlogPosts\Pages\CreateBlogPost;
use App\Filament\Resources\BlogPosts\Pages\EditBlogPost;
use App\Filament\Resources\BlogPosts\Pages\ListBlogPosts;
use App\Models\BlogPost;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedNewspaper;

    protected static ?string $navigationLabel = 'Blog Posts';

    protected static string|UnitEnum|null $navigationGroup = 'Blog';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'lg' => 3])
            ->components([
                Group::make([
                    Section::make('Post Details')
                        ->schema([
                            TextInput::make('title')->required(),
                            TextInput::make('slug')->required()->unique(ignoreRecord: true),
                            Select::make('blog_category_id')->relationship('category', 'name')->required(),
                            DatePicker::make('published_at'),
                            Select::make('status')
                                ->options([
                                    'draft' => 'Draft',
                                    'published' => 'Published',
                                ])
                                ->required()
                                ->default('draft'),
                        ])
                        ->columns(2),

                    Section::make('Content')
                        ->schema([
                            FileUpload::make('image')
                                ->image()
                                ->directory('blog-images')
                                ->disk('public')
                                ->visibility('public')
                                ->imageResizeMode('cover')
                                ->imageResizeTargetWidth(1200)
                                ->imageResizeTargetHeight(800),
                            Textarea::make('excerpt')->rows(3),
                            RichEditor::make('content'),
                        ]),
                ])
                ->columnSpan(['default' => 1, 'lg' => 2]),

                Section::make('SEO Optimization')
                    ->schema([
                        TextInput::make('seo_title')
                            ->label('Meta Title')
                            ->placeholder('Defaults to blog title if left blank'),
                        Textarea::make('seo_description')
                            ->label('Meta Description')
                            ->rows(3)
                            ->placeholder('Key summary for search results'),
                        TextInput::make('seo_keywords')
                            ->label('Meta Keywords')
                            ->placeholder('keyword1, keyword2, ...'),
                        Textarea::make('json_ld_schema')
                            ->label('JSON-LD Schema')
                            ->rows(16)
                            ->placeholder('{"@context": "https://schema.org", ...}')
                            ->helperText('Paste custom JSON-LD schema (either raw JSON or complete script block).'),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 1]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->square()->size(60)->disk('public'),
                TextColumn::make('title')->searchable()->limit(40),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'danger',
                        'published' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('category.name')->badge()->sortable(),
                TextColumn::make('published_at')->date('M d, Y')->sortable(),
            ])->defaultSort('created_at', 'desc')
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
                    //Action to Update post status to published or draft
                    BulkAction::make('publish')
                        ->label('Publish')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function (Collection $records) {
                            $records->each->update(['status' => 'published']);
                        }),
                    BulkAction::make('draft')
                        ->label('Draft')
                        ->icon('heroicon-o-clock')
                        ->color('warning')
                        ->action(function (Collection $records) {
                            $records->each->update(['status' => 'draft']);
                        }),
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
            'index' => ListBlogPosts::route('/'),
            'create' => CreateBlogPost::route('/create'),
            'edit' => EditBlogPost::route('/{record}/edit'),
        ];
    }
}
