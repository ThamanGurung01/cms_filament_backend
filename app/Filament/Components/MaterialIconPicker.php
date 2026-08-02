<?php

namespace App\Filament\Components;

use App\Helpers\MaterialIcons;
use Filament\Forms\Components\TextInput;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\HtmlString;

class MaterialIconPicker extends TextInput
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->placeholder('verified_user');

        // Add a datalist for quick suggestions while typing
        $this->datalist(array_values(MaterialIcons::getIcons()));

        $this->suffixAction(
            Action::make('pickIcon')
                ->icon('heroicon-m-swatch')
                ->color('primary')
                ->tooltip('Open Icon Picker')
                ->form([
                    Select::make('selected_icon')
                        ->label('Select Icon')
                        ->options(function () {
                            $icons = MaterialIcons::getIcons();
                            $options = [];

                            foreach ($icons as $name => $ligature) {
                                $options[$ligature] = "
                                    <div class='flex items-center gap-x-3 py-0.5'>
                                        <span class='material-symbols-outlined shrink-0 text-[1.25rem]'>{$ligature}</span>
                                        <span class='text-sm leading-6'>{$name}</span>
                                    </div>";
                            }

                            return $options;
                        })
                        ->allowHtml()
                        ->searchable()
                        ->preload()
                        ->native(false)
                ])
                ->action(function ($set, $state) {
                    if (isset($state['selected_icon'])) {
                        $set($this->getName(), $state['selected_icon']);
                    }
                })
        );
    }

    public static function make(?string $name = null): static
    {
        $static = parent::make($name);
        $static->label($name ? str($name)->title() : 'Icon');

        return $static;
    }
}
