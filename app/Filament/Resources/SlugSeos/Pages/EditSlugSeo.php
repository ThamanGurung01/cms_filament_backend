<?php

namespace App\Filament\Resources\SlugSeos\Pages;

use App\Filament\Resources\SlugSeos\SlugSeoResource;
use Filament\Resources\Pages\EditRecord;

class EditSlugSeo extends EditRecord
{
    protected static string $resource = SlugSeoResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
