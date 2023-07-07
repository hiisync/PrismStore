<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import {trans} from "laravel-vue-i18n";
</script>

<template>
    <Head>
        <title>{{ trans('global.payments.success') }}</title>
    </Head>
    <AppLayout>
        <div class="flex flex-col space-y-3 items-center text-center my-10">
            <span class="text-5xl text-gray-100">🎉</span>
             <div>
                 <h1 class="text-3xl font-bold text-gray-100">{{ trans('global.payments.success') }}</h1>
                 <p class="text-gray-300">{{ trans('global.payments.success.description') }}</p>
             </div>
            <Link :href="route('home')" class="mt-5">
                <button class="px-4 py-2 text-white bg-primary rounded-md">{{ trans('global.to_home') }}</button>
            </Link>
        </div>
    </AppLayout>
</template>
