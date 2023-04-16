<?php
 
namespace App\Filament\Resources;
 
class FilterSetResource extends \Archilex\FilamentFilterSets\Resources\FilterSetResource
{
    protected static ?string $navigationLabel = 'Filters';
 
    protected static ?string $navigationIcon = 'heroicon-o-adjustments';
 
    protected static ?string $navigationGroup = 'Settings';
 
    protected static ?int $navigationSort = 2;
}