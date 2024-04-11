<?php

namespace App\Shared\Dtos;

use Spatie\LaravelData\Data;

abstract class PaginatedResponse extends Data
{
    public int $current_page;
    public string $first_page_url;
    public int $from;
    public ?string $next_page_url;
    public string $path;
    public int $per_page;
    public ?string $prev_page_url;
    public int $to;
}
