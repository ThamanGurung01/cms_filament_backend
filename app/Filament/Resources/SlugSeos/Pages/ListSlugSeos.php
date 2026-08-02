<?php

namespace App\Filament\Resources\SlugSeos\Pages;

use App\Filament\Resources\SlugSeos\SlugSeoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSlugSeos extends ListRecords
{
    protected static string $resource = SlugSeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
