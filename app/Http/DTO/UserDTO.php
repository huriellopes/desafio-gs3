<?php

namespace App\Http\DTO;

use Spatie\LaravelData\Data;

class UserDTO extends Data
{
    /**
     * @param string $name
     * @param string $email
     * @param string|null $password
     * @param int $role_id
     */
    public function __construct(
        public string $name,
        public string $email,
        public string|null $password,
        public int $role_id
    ){}
}
