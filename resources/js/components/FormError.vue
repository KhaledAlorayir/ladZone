<script lang="ts" setup>
import { useSharedData } from "@/hooks/useSharedData";

const sharedData = useSharedData();
const props = defineProps<{ name: string }>();
</script>

<template>
    <p class="text-destructive" v-if="sharedData.props.errors[props.name]">
        {{ sharedData.props.errors[props.name] }}
    </p>
</template>
