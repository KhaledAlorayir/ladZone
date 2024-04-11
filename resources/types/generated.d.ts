export type CreateListData = {
visibilityTypes: string[];
};
export type CreateListRequest = {
title: string;
description: string;
visibility: string;
selectedGames: Array<ListEntry>;
};
export type InteractionType = 'comment' | 'like';
export type ListEntry = {
note: string;
id: number;
rank: number | null;
};
export type ListPreview = {
id: number;
title: string;
visibility: Visibility;
created_at: string;
likesCount: number;
commentsCount: number;
user: UserResponse;
images: Array<string>;
};
export type ListsPreviewResponse = {
data: Array<ListPreview>;
current_page: number;
first_page_url: string;
from: number;
next_page_url: string | null;
path: string;
per_page: number;
prev_page_url: string | null;
to: number;
};
export type RawgGameResponse = {
name: string;
id: number;
released: string | null;
background_image: string | null;
metacritic: number | null;
};
export type UserResponse = {
id: number;
name: string;
avatar: string;
};
export type Visibility = 'public' | 'link' | 'private';
