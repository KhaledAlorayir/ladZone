<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Button } from "@/components/ui/button";
import { useSharedData } from "@/hooks/useSharedData";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { LogOut, ListMinus } from "lucide-vue-next";
import {
    DropdownMenu,
    DropdownMenuTrigger,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuGroup,
    DropdownMenuSeparator,
} from "@/components/ui/dropdown-menu";

const {
    props: { auth },
} = useSharedData();
</script>

<template>
    <main class="h-svh flex flex-col py-8">
        <header class="px-8 xl:px-32 flex items-center justify-between">
            <Link href="/" class="text-2xl font-bold">LadZone</Link>
            <Button v-if="!auth"
                ><a href="/auth/discord/redirect">Login</a></Button
            >
            <DropdownMenu v-else>
                <DropdownMenuTrigger as-child>
                    <Avatar size="base" class="cursor-pointer">
                        <AvatarImage :src="auth.avatar" :alt="auth.name" />
                        <AvatarFallback>{{ auth.name }}</AvatarFallback>
                    </Avatar>
                </DropdownMenuTrigger>
                <DropdownMenuContent class="w-24 mt-1">
                    <DropdownMenuGroup>
                        <Link href="/list/create-list">
                            <DropdownMenuItem>
                                <ListMinus class="mr-2 h-4 w-4" />
                                <span>create list</span>
                            </DropdownMenuItem>
                        </Link>
                    </DropdownMenuGroup>
                    <DropdownMenuSeparator />
                    <DropdownMenuGroup>
                        <Link href="/auth/logout">
                            <DropdownMenuItem>
                                <LogOut class="mr-2 h-4 w-4" />
                                <span>Log out</span>
                            </DropdownMenuItem>
                        </Link>
                    </DropdownMenuGroup>
                </DropdownMenuContent>
            </DropdownMenu>
        </header>
        <section class="flex flex-col flex-1 container mx-auto">
            <slot></slot>
        </section>
    </main>
</template>
