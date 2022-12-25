<?php

namespace App\Services\Filters;

use App\Services\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class ProductDescriptionService implements FilterInterface
{
    /**
     * @var string
     */
    private const KEY = 'description';
    /**
     * @param array $data
     * @return Builder
     */
    public function search($data, $query): Builder
    {
        if (!array_key_exists(self::KEY, $data)) {
            return $query;
        }
        $description = $data[self::KEY] ?? null;
      
        if ($description !== '') {
            return $query->where('description', 'like', '%' . $description . '%');
        }
    }
}
