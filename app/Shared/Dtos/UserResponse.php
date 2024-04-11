<?php

namespace App\Shared\Dtos;

use App\Shared\Enums\Visibility;
use Spatie\LaravelData\Data;

/** @typescript */
class UserResponse extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $avatar,
    ) {
    }
}
