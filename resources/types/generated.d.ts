export type CreateListData = {
visibilityTypes: string[];
};
export type CreateListRequest = {
title: string;
description: string;
visibility: string;
ranked: boolean;
selectedGames: Array<ListEntry>;
};
export type ListEntry = {
note: string;
id: number;
};
export type RawgGameResponse = {
name: string;
id: number;
released: string | null;
background_image: string | null;
metacritic: number | null;
};
export type Visibility = 'public' | 'link' | 'private';
