<?php

namespace App\Filament\Resources\Services;

use App\Filament\Resources\Services\Pages\CreateService;
use App\Filament\Resources\Services\Pages\EditService;
use App\Filament\Resources\Services\Pages\ListServices;
use App\Filament\Resources\Services\Pages\ViewService;
use App\Models\Service;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

// Form Imports
use App\Filament\Components\MaterialIconPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Support\Str;

// Table Imports
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\HtmlString;

// Infolist Imports
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\RepeatableEntry;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Services';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Service Details')
                    ->tabs([
                        Tab::make('General')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('title')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn(string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                                        TextInput::make('slug')
                                            ->required()
                                            ->unique(ignoreRecord: true),
                                    ]),
                                Select::make('service_category_id')
                                    ->relationship('category', 'title')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->createOptionForm([
                                        TextInput::make('title')
                                            ->required()
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn(string $operation, $state, Set $set) => $set('slug', Str::slug($state))),
                                        TextInput::make('slug')
                                            ->required()
                                            ->unique('service_categories', 'slug'),
                                        TextInput::make('subtitle'),
                                        TextInput::make('sort_order')
                                            ->numeric()
                                            ->default(0),
                                        Toggle::make('is_active')
                                            ->default(true),
                                    ]),
                                MaterialIconPicker::make('icon')
                                    ->required()
                                    ->placeholder('movie'),
                                TextInput::make('subtitle')
                                    ->required(),
                                TextInput::make('hero_pill_text')
                                    ->label('Hero Pill Text')
                                    ->placeholder('e.g., SERVICE_ACTIVE or leave empty to hide')
                                    ->nullable(),
                                FileUpload::make('image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('services')
                                    ->columnSpanFull()
                                    ->imageResizeMode('cover')
                                    ->imageResizeTargetWidth(1600)
                                    ->imageResizeTargetHeight(1066),
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('sort_order')
                                            ->required()
                                            ->numeric()
                                            ->default(0),
                                        Toggle::make('is_active')
                                            ->default(true)
                                            ->required(),
                                    ]),
                            ]),

                        Tab::make('Content')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('content_title')
                                            ->required(),
                                        TextInput::make('content_title_color_text')
                                            ->required(),
                                    ]),
                                RichEditor::make('content')
                                    ->default(null)
                                    ->columnSpanFull(),

                                Repeater::make('info_list')
                                    ->schema([
                                        MaterialIconPicker::make('icon')
                                            ->placeholder('verified_user'),
                                        TextInput::make('text')->required(),
                                    ])
                                    ->columnSpanFull()
                                    ->columns(2)
                                    ->grid(['md' => 1])
                                    ->collapsible(),

                                Section::make('Section Label Overrides')
                                    ->description('Customize the "About This Service" badge and the capabilities card heading shown in the overview area.')
                                    ->collapsed()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('overview_badge')
                                                    ->label('Overview Badge')
                                                    ->placeholder('e.g., About This Service')
                                                    ->nullable(),
                                                TextInput::make('capabilities_card_title')
                                                    ->label('Capabilities Card Heading')
                                                    ->placeholder('e.g., Capabilities')
                                                    ->nullable(),
                                            ]),
                                    ]),
                            ]),

                        Tab::make('Capabilities')
                            ->icon('heroicon-o-sparkles')
                            ->schema([
                                Section::make('Service Capabilities')
                                    ->description('Core features or capabilities of this service')
                                    ->schema([
                                        Repeater::make('capabilities')
                                            ->schema([
                                                MaterialIconPicker::make('icon')
                                                    ->required()
                                                    ->placeholder('assignment'),
                                                TextInput::make('title')->required(),
                                                Textarea::make('description')->columnSpanFull()->required(),
                                            ])
                                            ->columnSpanFull()
                                            ->columns(2)
                                            ->grid(['default' => 1])
                                            ->collapsible(),
                                    ]),
                            ]),

                        Tab::make('Expertise & Risks')
                            ->icon('heroicon-o-exclamation-triangle')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('expertise_badge')
                                            ->placeholder('e.g., Why Local Expertise Matters'),
                                        TextInput::make('expertise_title')
                                            ->placeholder('e.g., Why Filming in Nepal Requires a Fixer'),
                                    ]),
                                RichEditor::make('expertise_description')
                                    ->columnSpanFull()
                                    ->placeholder('Detailed description of why a fixer is needed...'),
                                Section::make('Risk Warnings')
                                    ->description('List what goes wrong without a fixer')
                                    ->schema([
                                        TextInput::make('warnings_title')
                                            ->label('Warnings Box Heading')
                                            ->placeholder('e.g., Without Hire a Fixer in Nepal — What Goes Wrong')
                                            ->nullable()
                                            ->columnSpanFull(),
                                        Repeater::make('expertise_warnings')
                                            ->schema([
                                                TextInput::make('text')
                                                    ->required()
                                                    ->placeholder('e.g., Filming without permits in heritage sites can result in detention'),
                                            ])
                                            ->columnSpanFull()
                                            ->grid(['default' => 1])
                                            ->collapsible(),
                                    ]),
                            ]),

                        Tab::make('Custom Capabilities')
                            ->icon('heroicon-o-bolt')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('capabilities_title')
                                            ->placeholder('e.g., Fixer Capabilities'),
                                        TextInput::make('capabilities_badge')
                                            ->label('Capabilities Badge')
                                            ->placeholder('e.g., Capabilities')
                                            ->nullable(),
                                    ]),
                                Textarea::make('capabilities_description')
                                    ->placeholder('Brief intro text for capabilities...'),
                                Section::make('Capabilities Grid')
                                    ->schema([
                                        Repeater::make('capabilities_list')
                                            ->schema([
                                                MaterialIconPicker::make('icon')
                                                    ->required()
                                                    ->placeholder('verified_user'),
                                                TextInput::make('title')->required(),
                                                Textarea::make('description')->required(),
                                            ])
                                            ->columnSpanFull()
                                            ->columns(2)
                                            ->grid(['default' => 1])
                                            ->collapsible(),
                                    ]),
                            ]),

                        Tab::make('How We Work')
                            ->icon('heroicon-o-arrow-trending-up')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('how_we_work_badge')
                                            ->label('Section Badge')
                                            ->placeholder('e.g., Our Process')
                                            ->nullable(),
                                        TextInput::make('how_we_work_title')
                                            ->label('Section Heading')
                                            ->placeholder('e.g., How We Work')
                                            ->nullable(),
                                    ]),
                                Section::make('Process Steps')
                                    ->description('Process steps (01, 02, etc.)')
                                    ->schema([
                                        Repeater::make('how_we_work')
                                            ->schema([
                                                TextInput::make('title')->required()->placeholder('Process Title'),
                                                Textarea::make('description')->required(),
                                            ])
                                            ->grid(['default' => 1])
                                            ->collapsible(),
                                    ]),
                            ]),

                        Tab::make('Requirements')
                            ->icon('heroicon-o-clipboard-document-list')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('requirements_title')
                                            ->placeholder('e.g., Before We Start'),
                                        TextInput::make('requirements_subtitle')
                                            ->placeholder('e.g., What We Need From You'),
                                    ]),
                                Textarea::make('requirements_description')
                                    ->placeholder('The faster you provide...'),
                                TextInput::make('requirements_notice')
                                    ->placeholder('Missing documents delay permits...'),
                                Section::make('Required Documents List')
                                    ->schema([
                                        Repeater::make('requirements_list')
                                            ->schema([
                                                TextInput::make('document')->required()->placeholder('e.g., Script or synopsis'),
                                                TextInput::make('why_required')->required()->placeholder('e.g., Government and location review'),
                                                TextInput::make('format')->required()->placeholder('e.g., PDF, 1-5 pages'),
                                            ])
                                            ->columnSpanFull()
                                            ->columns(3)
                                            ->grid(['default' => 1])
                                            ->collapsible(),
                                    ]),
                                Section::make('Table Column Header Labels')
                                    ->description('Customize the column headers shown in the requirements table.')
                                    ->collapsed()
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                TextInput::make('req_col_document')
                                                    ->label('Column 1 Header')
                                                    ->placeholder('e.g., Document')
                                                    ->nullable(),
                                                TextInput::make('req_col_why_required')
                                                    ->label('Column 2 Header')
                                                    ->placeholder('e.g., Why Required')
                                                    ->nullable(),
                                                TextInput::make('req_col_format')
                                                    ->label('Column 3 Header')
                                                    ->placeholder('e.g., Format')
                                                    ->nullable(),
                                            ]),
                                    ]),
                            ]),

                        Tab::make('Coverage')
                            ->icon('heroicon-o-map')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('coverage_title')
                                            ->placeholder('e.g., Coverage'),
                                        TextInput::make('coverage_subtitle')
                                            ->placeholder('e.g., Where We Work in Nepal'),
                                    ]),
                                Section::make('Coverage Regions')
                                    ->schema([
                                        Repeater::make('coverage_list')
                                            ->schema([
                                                TextInput::make('region_name')->required()->placeholder('e.g., Kathmandu Valley'),
                                                TextInput::make('tags')
                                                    ->placeholder('e.g., Heritage Sites, Streets, Temples')
                                                    ->helperText('Comma-separated list')
                                                    ->required(),
                                                Textarea::make('description')->required(),
                                            ])
                                            ->columnSpanFull()
                                            ->grid(['default' => 1])
                                            ->collapsible(),
                                    ]),
                            ]),

                        Tab::make('Multimedia')
                            ->icon('heroicon-o-play-circle')
                            ->schema([
                                Section::make('Multimedia Content')
                                    ->schema([
                                        TextInput::make('service_video_url')
                                            ->url()
                                            ->label('Video URL')
                                            ->default(null),
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('video_badge')
                                                    ->label('Video Section Badge')
                                                    ->placeholder('e.g., Video')
                                                    ->nullable(),
                                                TextInput::make('video_title')
                                                    ->label('Video Section Heading')
                                                    ->placeholder('e.g., Service Overview')
                                                    ->nullable(),
                                            ]),
                                    ]),
                            ]),

                        Tab::make('FAQ')
                            ->icon('heroicon-o-question-mark-circle')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('faq_badge')
                                            ->label('FAQ Badge')
                                            ->placeholder('e.g., FAQ')
                                            ->nullable(),
                                        TextInput::make('faq_title')
                                            ->label('FAQ Heading')
                                            ->placeholder('e.g., Common Questions')
                                            ->nullable(),
                                    ]),
                                Textarea::make('faq_description')
                                    ->label('FAQ Intro Paragraph')
                                    ->placeholder('e.g., Quick answers to the most critical questions regarding ...')
                                    ->nullable(),
                                Section::make('Frequently Asked Questions')
                                    ->schema([
                                        Repeater::make('faq')
                                            ->schema([
                                                TextInput::make('question')->required(),
                                                Textarea::make('answer')->required(),
                                            ])
                                            ->grid(['default' => 1])
                                            ->collapsible(),
                                    ]),
                            ]),

                        Tab::make('CTA')
                            ->icon('heroicon-o-megaphone')
                            ->schema([
                                Section::make('Call to Action Section')
                                    ->description('Customize the call-to-action block at the bottom of the service page.')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('cta_badge')
                                                    ->label('CTA Badge')
                                                    ->placeholder('e.g., Ready to Begin?')
                                                    ->nullable(),
                                                TextInput::make('cta_title')
                                                    ->label('CTA Heading')
                                                    ->placeholder('e.g., Start Your Project Today')
                                                    ->nullable(),
                                            ]),
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('cta_button_text')
                                                    ->label('Primary Button Text')
                                                    ->placeholder('e.g., Contact Us')
                                                    ->nullable(),
                                                TextInput::make('cta_secondary_text')
                                                    ->label('Secondary Link Text')
                                                    ->placeholder('e.g., Back to All Services')
                                                    ->nullable(),
                                            ]),
                                    ]),
                            ]),

                        Tab::make('SEO')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
                                TextInput::make('meta_title')
                                    ->default(null),
                                Textarea::make('meta_description')
                                    ->default(null),
                                TextInput::make('meta_keywords')
                                    ->default(null),
                                Textarea::make('json_ld_schema')
                                    ->label('JSON-LD Schema')
                                    ->rows(8)
                                    ->placeholder('{"@context": "https://schema.org", ...}')
                                    ->helperText('Paste custom JSON-LD schema (either raw JSON or complete script block).')
                                    ->default(null),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->height(40),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.title')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('icon')
                    ->formatStateUsing(fn(string $state): \Illuminate\Support\HtmlString => new \Illuminate\Support\HtmlString("<span class='material-symbols-outlined'>$state</span>"))
                    ->label('Icon'),
                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable()
                    ->label('Active'),
                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\ActionGroup::make([
                    \Filament\Actions\ViewAction::make(),
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

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Service Details')
                    ->tabs([
                        Tab::make('General')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('title')
                                            ->weight('bold'),
                                        TextEntry::make('slug'),
                                    ]),
                                TextEntry::make('subtitle'),
                                ImageEntry::make('image')
                                    ->disk('public')
                                    ->columnSpanFull()
                                    ->size(200),
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('sort_order'),
                                        IconEntry::make('is_active')
                                            ->boolean()
                                            ->label('Active Status'),
                                    ]),
                            ]),

                        Tab::make('Content')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('content_title'),
                                        TextEntry::make('content_title_color_text'),
                                    ]),
                                TextEntry::make('content')
                                    ->html()
                                    ->columnSpanFull(),

                                RepeatableEntry::make('info_list')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextEntry::make('icon')
                                                    ->formatStateUsing(fn($state) => new HtmlString("<span class='material-symbols-outlined'>{$state}</span>")),
                                                TextEntry::make('text'),
                                            ]),
                                    ])
                                    ->grid(2)
                                    ->columnSpanFull(),

                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('overview_badge')->label('Overview Badge'),
                                        TextEntry::make('capabilities_card_title')->label('Capabilities Card Heading'),
                                    ]),
                            ]),

                        Tab::make('Capabilities')
                            ->icon('heroicon-o-sparkles')
                            ->schema([
                                Section::make('Service Capabilities')
                                    ->schema([
                                        RepeatableEntry::make('capabilities')
                                            ->schema([
                                                TextEntry::make('icon')
                                                    ->formatStateUsing(fn($state) => new HtmlString("<span class='material-symbols-outlined'>{$state}</span>")),
                                                TextEntry::make('title')
                                                    ->weight('bold'),
                                                TextEntry::make('description'),
                                            ])
                                            ->grid(1),
                                    ]),
                            ]),

                        Tab::make('Expertise & Risks')
                            ->icon('heroicon-o-exclamation-triangle')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('expertise_badge'),
                                        TextEntry::make('expertise_title'),
                                    ]),
                                TextEntry::make('expertise_description')->html(),
                                TextEntry::make('warnings_title')->label('Warnings Box Heading'),
                                RepeatableEntry::make('expertise_warnings')
                                    ->schema([
                                        TextEntry::make('text'),
                                    ])
                                    ->grid(1),
                            ]),

                        Tab::make('Custom Capabilities')
                            ->icon('heroicon-o-bolt')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('capabilities_title'),
                                        TextEntry::make('capabilities_badge'),
                                    ]),
                                TextEntry::make('capabilities_description'),
                                RepeatableEntry::make('capabilities_list')
                                    ->schema([
                                        TextEntry::make('icon')
                                            ->formatStateUsing(fn($state) => new HtmlString("<span class='material-symbols-outlined'>{$state}</span>")),
                                        TextEntry::make('title'),
                                        TextEntry::make('description'),
                                    ])
                                    ->grid(2),
                            ]),

                        Tab::make('How We Work')
                            ->icon('heroicon-o-arrow-trending-up')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('how_we_work_badge'),
                                        TextEntry::make('how_we_work_title'),
                                    ]),
                                Section::make('Process Steps')
                                    ->schema([
                                        RepeatableEntry::make('how_we_work')
                                            ->schema([
                                                TextEntry::make('title')
                                                    ->weight('bold'),
                                                TextEntry::make('description'),
                                            ])
                                            ->grid(1),
                                    ]),
                            ]),

                        Tab::make('Requirements')
                            ->icon('heroicon-o-clipboard-document-list')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('requirements_title'),
                                        TextEntry::make('requirements_subtitle'),
                                    ]),
                                TextEntry::make('requirements_description'),
                                TextEntry::make('requirements_notice'),
                                Grid::make(3)
                                    ->schema([
                                        TextEntry::make('req_col_document')->label('Column 1 Header'),
                                        TextEntry::make('req_col_why_required')->label('Column 2 Header'),
                                        TextEntry::make('req_col_format')->label('Column 3 Header'),
                                    ]),
                                RepeatableEntry::make('requirements_list')
                                    ->schema([
                                        TextEntry::make('document'),
                                        TextEntry::make('why_required'),
                                        TextEntry::make('format'),
                                    ])
                                    ->grid(3),
                            ]),

                        Tab::make('Coverage')
                            ->icon('heroicon-o-map')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('coverage_title'),
                                        TextEntry::make('coverage_subtitle'),
                                    ]),
                                RepeatableEntry::make('coverage_list')
                                    ->schema([
                                        TextEntry::make('region_name'),
                                        TextEntry::make('tags'),
                                        TextEntry::make('description'),
                                    ])
                                    ->grid(1),
                            ]),

                        Tab::make('Multimedia')
                            ->icon('heroicon-o-play-circle')
                            ->schema([
                                Section::make('Multimedia Content')
                                    ->schema([
                                        TextEntry::make('service_video_url')
                                            ->url(fn($state) => $state)
                                            ->color('primary'),
                                        Grid::make(2)
                                            ->schema([
                                                TextEntry::make('video_badge'),
                                                TextEntry::make('video_title'),
                                            ]),
                                    ]),
                            ]),

                        Tab::make('FAQ')
                            ->icon('heroicon-o-question-mark-circle')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('faq_badge'),
                                        TextEntry::make('faq_title'),
                                    ]),
                                TextEntry::make('faq_description'),
                                Section::make('Frequently Asked Questions')
                                    ->schema([
                                        RepeatableEntry::make('faq')
                                            ->schema([
                                                TextEntry::make('question')
                                                    ->weight('bold'),
                                                TextEntry::make('answer'),
                                            ])
                                            ->grid(1),
                                    ]),
                            ]),

                        Tab::make('CTA')
                            ->icon('heroicon-o-megaphone')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('cta_badge'),
                                        TextEntry::make('cta_title'),
                                    ]),
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('cta_button_text'),
                                        TextEntry::make('cta_secondary_text'),
                                    ]),
                            ]),

                        Tab::make('SEO')
                            ->icon('heroicon-o-globe-alt')
                            ->schema([
                                TextEntry::make('meta_title'),
                                TextEntry::make('meta_description'),
                                TextEntry::make('meta_keywords'),
                                TextEntry::make('json_ld_schema')
                                    ->label('JSON-LD Schema'),
                            ]),
                    ])
                    ->columnSpanFull(),
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
            'index' => ListServices::route('/'),
            'create' => CreateService::route('/create'),
            'view' => ViewService::route('/{record}'),
            'edit' => EditService::route('/{record}/edit'),
        ];
    }
}
