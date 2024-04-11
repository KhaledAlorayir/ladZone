<script setup lang="ts">
import Layout from "@/components/Layout.vue";
import type { ListsPreviewResponse } from "resources/types/generated";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Heart, MessageSquare } from "lucide-vue-next";
import { cn } from "@/lib/utils";
import { Link } from "@inertiajs/vue3";

const props = defineProps<{ lists: ListsPreviewResponse }>();

const styles = new Map([
    [0, "left-0 z-50"],
    [1, "left-14 z-40"],
    [2, "left-28 z-30"],
    [3, "left-44 z-20"],
]);
</script>

<template>
    <Layout>
        <section class="flex flex-wrap gap-4 py-4">
            <article
                v-for="list in props.lists.data"
                :key="list.id"
                class="w-96 space-y-4"
            >
                <div class="relative h-32 w-full rounded overflow-hidden">
                    <img
                        v-for="(image, index) in list.images.slice(0, 4)"
                        :src="image"
                        :key="image"
                        class="absolute w-28 h-full object-cover"
                        :class="cn(styles.get(index))"
                    />
                </div>

                <p class="text-xl capitalize">{{ list.title }}</p>
                <div class="flex items-center gap-3">
                    <Avatar size="xs">
                        <AvatarImage
                            :src="list.user.avatar"
                            :alt="list.user.name"
                        />
                        <AvatarFallback>{{ list.user.name }}</AvatarFallback>
                    </Avatar>
                    <p class="text-sm font-semibold">{{ list.user.name }}</p>
                    <span class="flex items-center gap-1"
                        >{{ list.likesCount }} <Heart class="size-4"
                    /></span>
                    <span class="flex items-center gap-1">
                        {{ list.commentsCount }}
                        <MessageSquare class="size-4" />
                    </span>
                </div>
            </article>
        </section>
        <section>
            <Link
                v-if="props.lists.prev_page_url"
                :href="props.lists.prev_page_url"
                >prev</Link
            >
            <Link
                v-if="props.lists.next_page_url"
                :href="props.lists.next_page_url"
                >Next</Link
            >
        </section>
    </Layout>
</template>
