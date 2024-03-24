<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import { Search, Loader2 } from "lucide-vue-next";
import { Input } from "@/components/ui/input";
import { useSharedData } from "@/hooks/useSharedData";
import type { RawgGameResponse } from "resources/types/generated";
import {
    DropdownMenuRoot,
    DropdownMenuTrigger,
    DropdownMenuContent,
    DropdownMenuPortal,
    DropdownMenuItem,
} from "radix-vue";
import { ref } from "vue";

const selectedGames = defineModel<RawgGameResponse[]>({
    default: [],
    required: true,
});

const props = defineProps({
    placeholder: { default: "Search...", required: false },
});

const form = useForm({
    query: "",
});

function submitHandler() {
    form.get("/list/search-games", {
        preserveState: true,
        onSuccess: () => (open.value = true),
    });
}

function selectGameHandler(game: RawgGameResponse) {
    if (!selectedGames.value.find(({ id }) => game.id === id)) {
        selectedGames.value.push(game);
    }
}

const sharedData = useSharedData();
const open = ref(false);
</script>

<template>
    <form @submit.prevent="submitHandler">
        <div class="w-full space-y-1">
            <section class="space-y-2">
                <div class="relative">
                    <Input
                        type="text"
                        :placeholder="props.placeholder"
                        class="pl-10"
                        v-model="form.query"
                    />
                    <span
                        class="absolute start-0 inset-y-0 flex items-center justify-center px-2"
                    >
                        <Search class="size-5 text-muted-foreground" />
                    </span>
                    <span
                        class="absolute end-0 inset-y-0 flex items-center justify-center px-2"
                    >
                        <Loader2
                            v-if="form.processing"
                            class="size-5 text-muted-foreground animate-spin"
                        />
                    </span>
                </div>
                <p
                    class="text-destructive"
                    v-if="sharedData.props.errors['query']"
                >
                    {{ sharedData.props.errors["query"] }}
                </p>
            </section>
            <DropdownMenuRoot v-model:open="open">
                <DropdownMenuTrigger class="w-full h-0 invisible"
                    >.</DropdownMenuTrigger
                >
                <DropdownMenuPortal>
                    <DropdownMenuContent
                        class="w-[--radix-dropdown-menu-trigger-width] max-h-60 bg-gray-800 rounded py-1 space-y-3 overflow-y-auto"
                    >
                        <DropdownMenuItem
                            v-if="sharedData.props.searchResults?.length"
                            as="button"
                            @click="selectGameHandler(game)"
                            type="button"
                            class="data-[highlighted]:bg-gray-900 select-none outline-none w-full inline-block text-left p-2"
                            v-for="game in sharedData.props.searchResults"
                            :key="game.id"
                        >
                            {{ game.name }}
                        </DropdownMenuItem>
                        <DropdownMenuItem
                            v-else
                            type="button"
                            class="data-[highlighted]:bg-gray-900 select-none outline-none w-full inline-block text-left p-2"
                        >
                            no results found
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenuPortal>
            </DropdownMenuRoot>
        </div>
    </form>
</template>
