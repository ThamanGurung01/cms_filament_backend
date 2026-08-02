<?php

namespace App\Filament\Pages;

use App\Models\Brand;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;

class ManageBrands extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationLabel = 'Brands';

    protected static ?int $navigationSort = 3;

    protected string $view = 'filament.pages.manage-brands';

    public function getMaxContentWidth(): \Filament\Support\Enums\Width | string | null
    {
        return \Filament\Support\Enums\Width::Full;
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Content';
    }

    public ?int $editingId = null;
    public ?string $name = '';
    public $logo = null;
    public int $row = 1;
    public bool $is_active = true;
    public ?string $url = null;

    public function mount(): void
    {
        $this->resetForm();
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            FileUpload::make('logo')
                ->image()
                ->disk('public')
                ->directory('brands')
                ->columnSpanFull()
                ->required()
                ->imageResizeMode('contain')
                ->imageResizeTargetWidth(300)
                ->imageResizeTargetHeight(200),

            Select::make('row')
                ->options([
                    1 => 'Row 1 [First]',
                    2 => 'Row 2 [Second]',
                ])
                ->default(1)
                ->required(),

            Toggle::make('is_active')
                ->default(true)
                ->required(),

            TextInput::make('url')
                ->url()
                ->maxLength(255)
                ->nullable(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Brand::query()->orderBy('row')->orderBy('sort_order'))
            ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('logo')
                    ->height(20)
                    ->disk('public'),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('row')
                    ->numeric()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('url')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Action::make('edit')
                    ->label('')
                    ->icon('heroicon-o-pencil-square')
                    ->action(fn(Brand $record) => $this->editBrand($record)),
                DeleteAction::make()
                    ->label('')
                    ->requiresConfirmation()
                    ->action(fn(Brand $record) => $record->delete()),
            ])
            ->defaultSort('row', 'asc');
    }

    public function editBrand(Brand $record): void
    {
        $this->editingId = $record->id;
        $this->name = $record->name;
        $this->logo = $record->logo;
        $this->row = $record->row ?? 1;
        $this->is_active = $record->is_active ?? true;
        $this->url = $record->url;

        $this->form->fill([
            'name' => $this->name,
            'logo' => $this->logo,
            'row' => $this->row,
            'is_active' => $this->is_active,
            'url' => $this->url,
        ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $updateData = [
            'name' => $data['name'],
            'logo' => $data['logo'],
            'row' => $data['row'],
            'is_active' => $data['is_active'],
            'url' => $data['url'],
        ];

        if (!$this->editingId) {
            $updateData['sort_order'] = Brand::max('sort_order') + 1;
        }

        Brand::updateOrCreate(
            ['id' => $this->editingId],
            $updateData
        );

        Notification::make()
            ->title($this->editingId ? 'Brand updated' : 'Brand created')
            ->success()
            ->send();

        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->editingId = null;
        $this->name = '';
        $this->logo = null;
        $this->row = 1;
        $this->is_active = true;
        $this->url = null;

        $this->form->fill();
    }

    public function cancel(): void
    {
        $this->resetForm();
    }
}
