import { usePage } from "@inertiajs/vue3";
import { User } from "../types";

export function useSharedData() {
    const page = usePage<{ auth: User | null }>();
    return page;
}
