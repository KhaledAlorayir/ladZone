<?php

namespace App\Shared\Dtos;

use App\Shared\Enums\Visibility;
use Spatie\LaravelData\Data;

/** @typescript */
class ListPreview extends Data
{
    public function __construct(
        public int $id,
        public string $title,
        public Visibility $visibility,
        public string $created_at,
        public int $likesCount,
        public int $commentsCount,
        public UserResponse $user,
        /** @var array<string> */
        public array $images,
    ) {
    }

    public static function mapToListPreview(array $list): ListPreview
    {
        $collection = collect($list);
        return ListPreview::from($collection->merge(['images' => collect($list['entires'])->map(fn ($entry) => $entry['game']['image'])]));
    }
}
