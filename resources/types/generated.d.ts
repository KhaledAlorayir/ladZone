export type CreateListData = {
visibilityTypes: string[];
};
export type RawgGameResponse = {
name: string;
id: number;
released: string | null;
background_image: string | null;
metacritic: number | null;
};
export type Visibility = 'public' | 'link' | 'private';
