<?php

namespace App\Services\Filters;

use App\Services\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class FilterProvider
{
    /**
     * @param $array $data
     * @return Builder
     */
    public function search(array $data = [], $query): Builder
    {
        foreach (app()->tagged(FilterInterface::class) as $service) {
            $query = $service->search($data, $query); 
        }
        return $query;
    }
}