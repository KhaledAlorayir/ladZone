<script setup lang="ts">
import { useSharedData } from "../hooks/useSharedData";
import { Link } from "@inertiajs/vue3";

const sharedData = useSharedData();
</script>

<template>
    <div>
        <p v-if="sharedData.props.auth">{{ sharedData.props.auth.name }}</p>
        <p v-else>not authenticated</p>
    </div>
    <div>
        <a v-if="!sharedData.props.auth" href="/auth/discord/redirect">login</a>
        <Link v-else href="/auth/logout">logout</Link>
    </div>
</template>
