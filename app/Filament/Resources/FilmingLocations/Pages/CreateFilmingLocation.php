<?php

namespace App\Filament\Resources\FilmingLocations\Pages;

use App\Filament\Resources\FilmingLocations\FilmingLocationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFilmingLocation extends CreateRecord
{
    protected static string $resource = FilmingLocationResource::class;
}
