<?php

namespace App\Shared\Dtos;

use Spatie\LaravelData\Data;

/** @typescript */
class RawgGameResponse extends Data
{
    public function __construct(
        public string  $name,
        public int     $id,
        public ?string $released,
        public ?string  $background_image,
        public ?int    $metacritic,
    ) {
    }
}
