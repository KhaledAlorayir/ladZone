<?php

namespace App\Shared\Dtos;


/** @typescript */
class ListsPreviewResponse extends PaginatedResponse
{
    public function __construct(
        /** @var array<ListPreview> */
        public array $data,
    ) {
    }
}
