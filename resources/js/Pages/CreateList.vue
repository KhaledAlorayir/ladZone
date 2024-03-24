<script setup lang="ts">
import Layout from "@/components/Layout.vue";
import GameSearchInput from "@/components/GameSearchInput.vue";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { Button } from "@/components/ui/button";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import { Checkbox } from "@/components/ui/checkbox";
import type {
    CreateListData,
    RawgGameResponse,
} from "resources/types/generated";
import { useForm } from "@inertiajs/vue3";
import { Trash2, Notebook } from "lucide-vue-next";
import { cn } from "@/lib/utils";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import { Ref, ref, watch } from "vue";

const props = defineProps<CreateListData>();

const form = useForm<{
    title: string;
    description: string;
    visibility: string;
    selectedGames: RawgGameResponse[];
    ranked: boolean;
}>({
    title: "",
    description: "",
    visibility: props.visibilityTypes[0],
    selectedGames: [],
    ranked: false,
});

const selectedGameForNote = ref<RawgGameResponse | null>(null);
const gameNoteMap = ref(new Map<number, Ref<string>>());

function removeGameHandler(gameId: number) {
    form.selectedGames = form.selectedGames.filter((game) => game.id != gameId);
    gameNoteMap.value.delete(gameId);
}

watch(form.selectedGames, () => {
    const lastAdded = form.selectedGames[form.selectedGames.length - 1];

    if (lastAdded && !gameNoteMap.value.has(lastAdded.id)) {
        gameNoteMap.value.set(lastAdded.id, ref(""));
    }
});
</script>

<template>
    <Layout>
        <section class="max-w-4xl mx-auto w-full space-y-8">
            <p class="font-bold text-lg">create a new list</p>
            <form class="flex flex-col gap-4">
                <Input
                    v-model="form.title"
                    placeholder="title..."
                    required
                    type="text"
                    maxlength="256"
                />
                <Textarea
                    v-model="form.description"
                    maxlength="5000"
                    placeholder="description..."
                    class="resize-none"
                    rows="5"
                ></Textarea>
                <div class="flex items-center justify-between">
                    <Select v-model="form.visibility">
                        <SelectTrigger class="w-[180px]">
                            <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Visibility</SelectLabel>
                                <SelectItem
                                    v-for="(
                                        visibility, index
                                    ) in props.visibilityTypes"
                                    :key="visibility"
                                    :value="visibility"
                                    >{{ visibility }}</SelectItem
                                >
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                    <div class="flex items-center space-x-2">
                        <Checkbox id="ranked" v-model:checked="form.ranked" />
                        <label
                            for="ranked"
                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                        >
                            ranked list
                        </label>
                    </div>
                </div>
                <div class="mt-8 w-1/2">
                    <GameSearchInput
                        @update:model-value="(a) => (form.selectedGames = a)"
                        :model-value="form.selectedGames"
                        placeholder="add games..."
                    />
                </div>
                <!--TODO show list & create, then rank ui -->
                <Button class="w-full mt-8">create</Button>
            </form>
            <section class="rounded-md border border-input">
                <ul v-if="form.selectedGames.length">
                    <li
                        class="flex items-center justify-between border-b-input px-4"
                        :class="
                            cn({
                                'border-b-2':
                                    index !== form.selectedGames.length - 1,
                            })
                        "
                        v-for="(game, index) in form.selectedGames"
                        :key="game.id"
                    >
                        <div class="flex items-center gap-4">
                            <section
                                class="h-32 w-32 rounded-lg overflow-hidden"
                            >
                                <img
                                    class="w-full h-full object-contain"
                                    v-if="game.background_image"
                                    :src="game.background_image"
                                    :alt="game.name"
                                />
                            </section>
                            <span class="text-lg font-bold">
                                {{ game.name }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <Button @click="selectedGameForNote = game">
                                note <Notebook class="w-4 h-4 ml-2" />
                            </Button>
                            <Button
                                variant="destructive"
                                size="icon"
                                @click="removeGameHandler(game.id)"
                            >
                                <Trash2 class="w-4 h-4" />
                            </Button>
                        </div>
                    </li>
                </ul>
                <p v-else class="py-6 text-xl font-bold text-center">
                    your list is empty
                </p>
            </section>
        </section>
        <Dialog
            :open="!!selectedGameForNote"
            @update:open="selectedGameForNote = null"
        >
            <DialogContent v-if="selectedGameForNote" class="max-w-xl">
                <DialogHeader>
                    <DialogTitle>note</DialogTitle>
                    <DialogDescription>{{
                        selectedGameForNote.name
                    }}</DialogDescription>
                </DialogHeader>
                <form @submit.prevent="">
                    <Textarea
                        v-model="form.description"
                        maxlength="5000"
                        placeholder="note..."
                        class="resize-none"
                        rows="4"
                    ></Textarea>
                    <Button class="w-full mt-8">save</Button>
                </form>
            </DialogContent>
        </Dialog>
    </Layout>
</template>
