import { usePage } from "@inertiajs/vue3";
import type { User } from "../types";
import type { RawgGameResponse } from "resources/types/generated";

export function useSharedData() {
    const page = usePage<{
        auth: User | null;
        searchResults: RawgGameResponse[] | null;
    }>();
    return page;
}
