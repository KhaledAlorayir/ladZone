<script lang="ts">
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <main class="h-svh flex flex-col">
        <header>
            <Link href="/auth/discord"></Link>
        </header>
        <section class="flex flex-col flex-1">
            <slot></slot>
        </section>
    </main>
</template>
