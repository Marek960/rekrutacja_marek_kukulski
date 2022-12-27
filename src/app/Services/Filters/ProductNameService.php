<?php

namespace App\Services\Filters;

use App\Services\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class ProductNameService implements FilterInterface
{
    /**
     * @var string
     */
    private const KEY = 'name';
    /**
     * @param array $data
     * @return Builder
     */
    public function search(array $data, Builder $query): Builder
    {
        if (!array_key_exists(self::KEY, $data)) {
            return $query;
        }
        $name = $data[self::KEY] ?? null;
      
        if ($name !== '') {
            return $query->where('name', 'like', '%' . $name . '%');
        }
    }
}
