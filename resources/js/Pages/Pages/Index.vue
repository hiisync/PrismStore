<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head } from "@inertiajs/vue3";

let props = defineProps({
    page: {
        type: Object,
        required: true
    },
    lang: {
        type: String,
        required: true
    }
});
</script>

<template>

    <Head>
        <title>{{ page.name[lang] }}</title>
        <meta name="description" :content="page.description[lang]">
    </Head>

    <AppLayout>
        <div class="max-w-7xl mx-auto text-white my-10" >
            <h1 class="font-bold my-5 text-2xl">{{ page.name[lang] }}</h1>
            <div class="bg-primary p-5" v-html="page.content[lang]"></div>
        </div>
    </AppLayout>

</template>
