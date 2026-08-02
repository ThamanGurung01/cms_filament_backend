<?php

namespace App\Filament\Resources\FilmingLocations\Pages;

use App\Filament\Resources\FilmingLocations\FilmingLocationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFilmingLocations extends ListRecords
{
    protected static string $resource = FilmingLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
