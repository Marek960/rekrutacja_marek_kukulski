<?php

namespace App\Services\Filters;

use App\Services\Filters\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class ProductPriceService implements FilterInterface
{
    /**
     * @var string
     */
    private const KEY = 'price';
    /**
     * @param array $data
     * @return Builder
     */
    public function search($data, $query): Builder
    {
        if (!array_key_exists(self::KEY, $data)) {
            return $query;
        }
        $price = $data[self::KEY] ?? null;
   
        if ($price !== '') {
            return $query->whereHas('prices', function($q) use ($price)
            {
                $q->where('price', $price);
            });
        }
    }
}
