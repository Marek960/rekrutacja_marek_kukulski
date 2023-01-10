<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Price;

class PriceRepository extends BaseRepository
{
    public function __construct(Price $model) {
        $this->model = $model;
    }
}