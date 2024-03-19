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

const props = defineProps<CreateListData>();

const form = useForm<{
    visibility: string;
    selectedGames: RawgGameResponse[];
    ranked: boolean;
}>({
    visibility: props.visibilityTypes[0],
    selectedGames: [],
    ranked: false,
});
</script>

<template>
    <Layout>
        <section class="max-w-2xl mx-auto w-full space-y-4">
            <p class="font-bold text-lg">create a new list</p>
            <form class="flex flex-col gap-4">
                <Input
                    placeholder="title..."
                    required
                    type="text"
                    maxlength="256"
                />
                <Textarea
                    maxlength="5000"
                    placeholder="description..."
                    class="resize-none"
                    rows="5"
                />
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
                            ranked list {{ form.ranked.valueOf() }}
                        </label>
                    </div>
                </div>
                <div class="mt-8 w-1/2">
                    <GameSearchInput
                        v-model="form.selectedGames"
                        placeholder="add games..."
                    />
                    {{ form.selectedGames.length }}
                </div>

                <Button class="w-full mt-8">create</Button>
            </form>
        </section>
    </Layout>
</template>
