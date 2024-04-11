<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Shared\Dtos\ListPreview;
use App\Shared\Dtos\ListsPreviewResponse;
use App\Shared\Enums\InteractionType;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Log;

class UserController extends Controller
{
    public function userProfile(User $user)
    {
        $lists = collect(
            $user
                ->lists()
                ->with(['entires.game', 'user'])
                ->withCount([
                    'interactions as likesCount' => function ($query) {
                        $query->where('type', InteractionType::Like);
                    },
                    'interactions as commentsCount' => function ($query) {
                        $query->where('type', InteractionType::Comment);
                    }
                ])
                ->simplePaginate(2)
        );

        $parsed = ListsPreviewResponse::from(
            $lists->except('data')->merge(
                ['data' => collect($lists['data'])->map(fn ($list) => ListPreview::mapToListPreview($list))]
            )
        );

        return Inertia::render('UserProfile', ['lists' => $parsed]);
    }
}
