<?php

namespace App\Filament\Resources\ResponseResource\Pages;

use App\Filament\Resources\ResponseResource;
use App\Models\Response;
use Filament\Resources\Pages\Page;

class ReviewResponse extends Page
{   
    public Response $record;

    protected static string $resource = ResponseResource::class;

    protected static string $view = 'filament.resources.response-resource.pages.review';
}
