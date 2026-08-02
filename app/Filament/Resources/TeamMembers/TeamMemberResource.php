<?php

namespace App\Filament\Resources\TeamMembers;

use App\Filament\Resources\TeamMembers\Pages\CreateTeamMember;
use App\Filament\Resources\TeamMembers\Pages\EditTeamMember;
use App\Filament\Resources\TeamMembers\Pages\ListTeamMembers;
use App\Models\TeamMember;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
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
use Illuminate\Support\Facades\Storage;

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;

    protected static BackedEnum|string|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'Team Members';

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?string $modelLabel = 'Team Member';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'lg' => 2])
            ->components([
                Section::make('Member Details')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('role')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g. CEO, Cinematographer, Drone Pilot'),

                        Textarea::make('bio')
                            ->label('Bio')
                            ->maxLength(1000)
                            ->columnSpanFull(),

                        Repeater::make('social_links')
                            ->label('Social Media Links')
                            ->schema([
                                Select::make('platform')
                                    ->label('Platform')
                                    ->options([
                                        'instagram' => 'Instagram',
                                        'linkedin'  => 'LinkedIn',
                                        'twitter'   => 'Twitter / X',
                                        'facebook'  => 'Facebook',
                                        'youtube'   => 'YouTube',
                                        'vimeo'     => 'Vimeo',
                                        'imdb'      => 'IMDb',
                                        'website'   => 'Website',
                                    ])
                                    ->required(),
                                TextInput::make('url')
                                    ->label('URL')
                                    ->url()
                                    ->required(),
                            ])
                            ->columns(2)
                            ->columnSpanFull(),

                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->label('Display Order'),

                        Toggle::make('is_active')
                            ->label('Active (visible on website)')
                            ->default(true),
                    ])
                    ->columnSpan(1),

                Section::make('Photo')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Member Photo')
                            ->image()
                            ->disk('public')
                            ->directory('team')
                            ->visibility('public')
                            ->helperText('Upload a cutout/portrait photo. PNG with transparent background works best.')
                            ->columnSpanFull()
                            ->imageResizeMode('cover')
                            ->imageResizeTargetWidth(600)
                            ->imageResizeTargetHeight(800),
                    ])
                    ->columnSpan(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Photo')
                    ->height(60)
                    ->width(50)
                    ->disk('public')
                    ->defaultImageUrl(fn ($record) => $record->image && !str_starts_with($record->image, 'team/')
                        ? asset($record->image)
                        : null)
                    ->extraImgAttributes(['style' => 'object-fit: contain;']),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('role')
                    ->searchable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean(),
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
            'index'  => ListTeamMembers::route('/'),
            'create' => CreateTeamMember::route('/create'),
            'edit'   => EditTeamMember::route('/{record}/edit'),
        ];
    }
}
