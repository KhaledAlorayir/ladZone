<script setup lang="ts">
import Layout from "@/components/layout/Layout.vue";
import Button from "@/components/ui/button/Button.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    query: "",
});

function submitHandler() {
    form.get("/list/search-games", { preserveState: true });
}
</script>

<template>
    <Layout>
        hello world
        <form @submit.prevent="submitHandler">
            <input type="text" v-model="form.query" class="text-black" />
            <Button>thing</Button>
        </form>
    </Layout>
</template>
