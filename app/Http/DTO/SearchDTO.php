<?php

namespace App\Http\DTO;

use Spatie\LaravelData\Data;

class SearchDTO extends Data
{
    /**
     * @param string|null $search
     */
    public function __construct(
        public string|null $search,
    ){}
}
