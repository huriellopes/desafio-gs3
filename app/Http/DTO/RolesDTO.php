<?php

namespace App\Http\DTO;

use AllowDynamicProperties;
use Spatie\LaravelData\Data;

#[AllowDynamicProperties] class RolesDTO extends Data
{
    /**
     * @param string $name
     * @param string $description
     * @param array|null $permissions
     */
    public function __construct(
        public string $name,
        public string $description,
        public array|null $permissions,
    ){}
}
