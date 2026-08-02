<?php

namespace App\Filament\Pages;

use App\Models\ServiceCategory;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Str;

class ManageServiceCategories extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Categories';

    protected string $view = 'filament.pages.manage-service-categories';

    public function getMaxContentWidth(): \Filament\Support\Enums\Width|string|null
    {
        return \Filament\Support\Enums\Width::Full;
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Services';
    }

    public ?int $editingId = null;
    public ?string $categoryTitle = '';
    public ?string $categorySlug = '';
    public ?string $title_color_text = null;
    public ?string $subtitle = '';
    public ?string $description = '';
    public int $sort_order = 0;
    public bool $is_active = true;

    public function mount(): void
    {
        $this->resetForm();
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('category_title')
                ->label('Title')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn(string $operation, $state, Set $set) => $this->editingId === null ? $set('category_slug', Str::slug($state)) : null),

            TextInput::make('category_slug')
                ->label('Slug')
                ->required()
                ->unique('service_categories', 'slug', ignoreRecord: $this->editingId !== null),

            TextInput::make('title_color_text')
                ->label('Colored Part of Title (Optional)')
                ->helperText('This word/phrase will be styled differently in the title.'),

            TextInput::make('subtitle'),

            Textarea::make('description')
                ->columnSpanFull(),

            TextInput::make('sort_order')
                ->numeric()
                ->default(0)
                ->required(),

            Toggle::make('is_active')
                ->default(true)
                ->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(ServiceCategory::query()->orderBy('sort_order'))
            ->reorderable('sort_order')
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subtitle')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable()
                    ->label('Active'),

                TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
            ])
            ->actions([
                Action::make('edit')
                    ->label('')
                    ->icon('heroicon-o-pencil-square')
                    ->action(fn(ServiceCategory $record) => $this->editCategory($record)),
                DeleteAction::make()
                    ->label('')
                    ->requiresConfirmation()
                    ->action(fn(ServiceCategory $record) => $record->delete()),
            ])
            ->defaultSort('sort_order', 'asc');
    }

    public function editCategory(ServiceCategory $record): void
    {
        $this->editingId = $record->id;
        $this->categoryTitle = $record->title;
        $this->categorySlug = $record->slug;
        $this->title_color_text = $record->title_color_text;
        $this->subtitle = $record->subtitle;
        $this->description = $record->description;
        $this->sort_order = $record->sort_order ?? 0;
        $this->is_active = $record->is_active ?? true;

        $this->form->fill([
            'category_title' => $this->categoryTitle,
            'category_slug' => $this->categorySlug,
            'title_color_text' => $this->title_color_text,
            'subtitle' => $this->subtitle,
            'description' => $this->description,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $updateData = [
            'title' => $data['category_title'],
            'slug' => $data['category_slug'],
            'title_color_text' => $data['title_color_text'],
            'subtitle' => $data['subtitle'],
            'description' => $data['description'],
            'sort_order' => $data['sort_order'],
            'is_active' => $data['is_active'],
        ];

        if ($this->editingId) {
            $record = ServiceCategory::find($this->editingId);
            $record->update($updateData);
        } else {
            if (!isset($updateData['sort_order'])) {
                $updateData['sort_order'] = ServiceCategory::max('sort_order') + 1;
            }
            ServiceCategory::create($updateData);
        }

        Notification::make()
            ->title($this->editingId ? 'Category updated' : 'Category created')
            ->success()
            ->send();

        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->editingId = null;
        $this->categoryTitle = '';
        $this->categorySlug = '';
        $this->title_color_text = null;
        $this->subtitle = '';
        $this->description = '';
        $this->sort_order = 0;
        $this->is_active = true;

        $this->form->fill();
    }

    public function cancel(): void
    {
        $this->resetForm();
    }
}
