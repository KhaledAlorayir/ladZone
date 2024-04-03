export type CreateListData = {
visibilityTypes: string[];
};
export type CreateListRequest = {
title: string;
description: string;
visibility: string;
selectedGames: Array<ListEntry>;
};
export type ListEntry = {
note: string;
id: number;
rank: number | null;
};
export type RawgGameResponse = {
name: string;
id: number;
released: string | null;
background_image: string | null;
metacritic: number | null;
};
export type Visibility = 'public' | 'link' | 'private';
