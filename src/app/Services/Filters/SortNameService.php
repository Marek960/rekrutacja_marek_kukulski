<?php

namespace App\Services\Filters;

use App\Services\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class SortNameService implements FilterInterface
{
    /**
     * @var string
     */
    private const KEY = 'sort_name';
    /**
     * @param array $data
     * @return Builder
     */
    public function search($data, $query): Builder
    {
        if (!array_key_exists(self::KEY, $data)) {
            return $query;
        }
        $sort = $data[self::KEY] ?? null;

        return $query->orderBy('products.name', $sort);
    }
}