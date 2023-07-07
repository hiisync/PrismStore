<script setup lang="ts">
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import {trans} from 'laravel-vue-i18n';

const form = useForm({
    amount: ''
});

const submit = () => {
    form.post(route('payments.paypal.payment'))
}
</script>

<template>
    <Head><title>PayPal</title></Head>
    <AppLayout>
   <div class="max-w-7xl mx-auto bg-primary space-y-3 p-5 my-5">
    <div class="flex justify-center">
        <img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-200px.png" alt="PayPal">
    </div>
    <form @submit.prevent="submit">
        <div class="flex flex-col items-center justify-center">
            <input id="name" v-model="form.amount" :placeholder="trans('global.payment.amount')" class="text-white my-2 p-2 rounded bg-[#22252A]" >
            <span class="text-xs text-red-500">{{ form.errors.amount }}</span>
            <button type="submit" class="px-4 py-2 text-white bg-[#22252A] rounded">{{ trans('global.next') }}</button>
        </div>
    </form>

    <div class="my-5 text-center">
        <p class="text-xs text-white">{{ trans('global.paymentWarning') }}</p>
        <p class="text-xs text-white">{{ trans('global.paymentWarning2') }}</p>
    </div>

    <div>
    <Link :href="route('payments.index')" type="submit" >
        <PrimaryButton>
            <i class="fa-solid fa-circle-chevron-left"></i>
        {{ trans('global.payments.back') }}
        </PrimaryButton>
    </Link>
    </div>
   </div>
    </AppLayout>
</template>