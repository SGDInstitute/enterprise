<?php

namespace App\Http\Livewire\Traits;

use App\Models\Product;

trait WithProducts
{
    public function getProductsProperty()
    {
        return Product::with('type')->without('builds')
            ->when(! auth()->user()->hasRole('admin'), function ($query) {
                $query->where('manufacturer_id', auth()->user()->current_manufacturer_id);
            })
            ->published()
            ->soldIndividually()
            ->get()
            ->sortBy('name')
            ->each(function ($item) {
                $item->nameWithType = $item->name.' ('.$item->type->name.')';
            })
            ->pluck('nameWithType', 'id');
    }
}
