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
    CreateListRequest,
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
} from "@/components/ui/dialog";
import { computed, ref } from "vue";
import { VueDraggableNext } from "vue-draggable-next";
import FormError from "@/components/FormError.vue";

interface CreateListForm extends Omit<CreateListRequest, "selectedGames"> {
    selectedGames: { game: RawgGameResponse; note: string }[];
}

const props = defineProps<CreateListData>();

const form = useForm<CreateListForm>({
    title: "",
    description: "",
    visibility: props.visibilityTypes[0],
    selectedGames: [],
    ranked: false,
});

const selectedGameForNoteIndex = ref<number>(-1);

const isRequiredFieldsValid = computed(
    () => !!form.selectedGames.length && !!form.title.trim().length
);

function removeGameHandler(gameId: number) {
    form.selectedGames = form.selectedGames.filter(
        ({ game }) => game.id != gameId
    );
}

function createListHandler() {
    if (!isRequiredFieldsValid.value || form.processing) return;
    form.transform(
        (data): CreateListRequest => ({
            ...data,
            selectedGames: data.selectedGames.map(({ game, note }) => ({
                id: game.id,
                note,
            })),
        })
    ).post("/list/create-list");
}
</script>

<template>
    <Layout>
        <section class="max-w-4xl mx-auto w-full space-y-8">
            <p class="font-bold text-lg">create a new list</p>
            <form
                @submit.prevent="createListHandler()"
                class="flex flex-col gap-4"
            >
                <div>
                    <Input
                        v-model="form.title"
                        placeholder="title..."
                        required
                        type="text"
                        maxlength="256"
                    />
                    <FormError name="title" />
                </div>
                <div>
                    <Textarea
                        v-model="form.description"
                        maxlength="5000"
                        placeholder="description..."
                        class="resize-none"
                        rows="5"
                    ></Textarea>
                    <FormError name="description" />
                </div>

                <div class="flex items-center justify-between">
                    <Select v-model="form.visibility">
                        <SelectTrigger class="w-[180px]">
                            <SelectValue />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectLabel>Visibility</SelectLabel>
                                <SelectItem
                                    v-for="visibility in props.visibilityTypes"
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
                        :selected-games="
                            form.selectedGames.map(({ game }) => game)
                        "
                        @select="
                            (game) =>
                                form.selectedGames.push({ game, note: '' })
                        "
                        placeholder="add games..."
                    />
                </div>
                <Button
                    class="w-full mt-8"
                    :disabled="!isRequiredFieldsValid || form.processing"
                    >create</Button
                >
            </form>
            <section class="rounded-md border border-input">
                <VueDraggableNext
                    :disabled="!form.ranked"
                    v-if="form.selectedGames.length"
                    v-model="form.selectedGames"
                >
                    <TransitionGroup name="list">
                        <li
                            class="flex items-center justify-between border-b-input px-4"
                            :class="
                                cn({
                                    'border-b-2':
                                        index !== form.selectedGames.length - 1,
                                    'cursor-move': form.ranked,
                                })
                            "
                            v-for="({ game }, index) in form.selectedGames"
                            :key="game.id"
                        >
                            <div class="flex items-center gap-4">
                                <span
                                    :class="{ invisible: !form.ranked }"
                                    class="font-bold"
                                    >{{ index + 1 }}</span
                                >
                                <section class="h-32 w-32 overflow-hidden">
                                    <img
                                        class="w-full h-full rounded-md object-contain"
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
                                <Button
                                    @click="selectedGameForNoteIndex = index"
                                >
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
                    </TransitionGroup>
                </VueDraggableNext>
                <p v-else class="py-6 text-xl font-bold text-center">
                    your list is empty
                </p>
            </section>
        </section>
        <Dialog
            :open="selectedGameForNoteIndex > -1"
            @update:open="selectedGameForNoteIndex = -1"
        >
            <DialogContent
                v-if="selectedGameForNoteIndex > -1"
                class="max-w-xl"
            >
                <DialogHeader>
                    <DialogTitle>note</DialogTitle>
                    <DialogDescription>{{
                        form.selectedGames[selectedGameForNoteIndex].game.name
                    }}</DialogDescription>
                </DialogHeader>
                <Textarea
                    v-model="form.selectedGames[selectedGameForNoteIndex].note"
                    maxlength="5000"
                    placeholder="note..."
                    class="resize-none"
                    rows="4"
                ></Textarea>
            </DialogContent>
        </Dialog>
    </Layout>
</template>
