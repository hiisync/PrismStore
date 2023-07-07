<script setup lang="ts">
import AppLayout from "@/Layouts/AppLayout.vue";
import {trans} from "laravel-vue-i18n";
import {Head, Link} from '@inertiajs/vue3';
</script>

<template>
    <Head>
        <title>{{ trans('global.payments') }}</title>
    </Head>
    <AppLayout>
    <div class="max-w-7xl space-y-3 mx-auto my-5 bg-primary p-5">
        <h1 class="text-2xl font-semibold text-white">
            {{ trans('global.payments.select') }}
        </h1>
        <div class="flex flex-wrap gap-4 py-10 justify-center">
            <Link :href="route('payments.paypal')">
                <div class="p-4 bg-white border rounded-lg shadow-md">
                    <img class="w-48" src="https://www.paypalobjects.com/digitalassets/c/website/marketing/apac/C2/logos-buttons/optimize/Full_Online_Tray_RGB.png" alt="PayPal">
                </div>
            </Link>

        </div>
    </div>
       <div class="text-center">
           <small class="text-white">{{ trans('global.payments.select.description') }}</small>
       </div>
    </AppLayout>
</template>
