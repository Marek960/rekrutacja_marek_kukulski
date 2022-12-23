<?php
declare(strict_types=1);

namespace App\Services\Filters;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    /**
    * @param array $data 
    * @return Builder
    */
    public function search(array $data, Builder $query): Builder;
}