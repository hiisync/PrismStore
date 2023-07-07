<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { trans, transChoice } from "laravel-vue-i18n";
import Pagination from "@/Components/Pagination.vue";

let props = defineProps({
    user: {
        type: Object,
        required: true
    },
    lang: {
        type: String,
        required: true
    },
    orders: {
        type: Object,
        required: true
    },
    payments: {
        type: Object,
        required: true
    },
});

function formatDate(time: number) {
    const millisPerSecond = 1000
    const millisPerMinute = millisPerSecond * 60
    const millisPerHour = millisPerMinute * 60
    const millisPerDay = millisPerHour * 24
    const millisPerMonth = millisPerDay * 30 // assume 30 days per month on average
    const millisPerYear = millisPerMonth * 12

    let date: Date = new Date(time)
    let duration: number = new Date().getTime() - date.getTime()
    let result = ''

    if (duration < millisPerMinute) {
        result = transChoice('global.seconds', Math.round(duration / millisPerSecond));
    } else if (duration < millisPerHour) {
        result = transChoice('global.minutes', Math.round(duration / millisPerMinute));
    } else if (duration < millisPerDay) {
        result = transChoice('global.hours', Math.round(duration / millisPerHour));
    } else if (duration < millisPerMonth) {
        result = transChoice('global.days', Math.round(duration / millisPerDay));
    } else if (duration < millisPerYear) {
        result = transChoice('global.months', Math.round(duration / millisPerMonth));
    } else {
        result = transChoice('global.years', Math.round(duration / millisPerYear));
    }

    return result
}
</script>

<template>
    <AdminLayout>

        <Head>
            <title>{{ user.name }}</title>
        </Head>
        <div class="bg-primary space-y-10 my-10 p-5">
            <div class="flex justify-center items-center">
                <div class="relative">
                    <img class="h-28 w-28 rounded-full" :src="user.avatar" alt="Avatar">
                    <span class="absolute border top-0 right-0 bg-secondary text-white text-xs font-bold px-2 rounded-full">
                        {{ user.balance }} ₴
                    </span>
                </div>
                <div class="mx-5">
                    <h1 class="text-2xl text-white font-bold">{{ user.name }}</h1>
                </div>
            </div>
            <div class="bg-secondary shadow rounded-lg p-6 sm:p-8 md:flex items-center justify-between">
                <div class="md:w-1/3">
                    <h3 class="text-xl text-gray-100 font-bold leading-tight mb-2">SteamID</h3>
                    <p class="text-gray-300 font-semibold">{{ user.steam_id }}</p>
                </div>
                <div class="md:w-1/3 border-t md:border-t-0 md:border-l p-4 md:p-6">
                    <p class="text-gray-100">Email</p><br>
                    <p class="text-gray-300 font-semibold">{{ user.email }}</p>
                </div>
                <div class="md:w-1/3 border-t md:border-t-0 md:border-l p-4 md:p-6">
                    <p class="text-gray-100">{{ trans('admin.created_at') }}</p><br>
                    <p class="text-gray-300 font-semibold">{{ formatDate(user.created_at) }}</p>
                    <small class="text-gray-300 font-semibold">({{ user.created_at }})</small>
                </div>
            </div>

            <div class="flex flex-wrap overflow-x-auto">
                <div class="w-full lg:w-1/2 px-4 mb-8 lg:mb-0">
                    <h2 class="text-lg text-white font-medium mb-4">
                        {{ trans('admin.orders') }}
                    </h2>
                    <table class="table-auto text-white w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">{{ trans('admin.orderid') }}</th>
                                <th class="px-4 py-2">{{ trans('admin.name') }}</th>
                                <th class="px-4 py-2">{{ trans('admin.amount') }}</th>
                                <th class="px-4 py-2">{{ trans('admin.price') }}</th>
                                <th class="px-4 py-2">{{ trans('admin.status') }}</th>
                                <th class="px-4 py-2">{{ trans('admin.date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in orders.data">
                                <td class="border px-4 py-2">{{ order.id }}</td>
                                <td class="border px-4 py-2">{{ order.product.name[lang] }}</td>
                                <td class="border px-4 py-2">{{ order.quantity }}</td>
                                <td class="border px-4 py-2">{{ order.price }}</td>
                                <td class="border px-4 py-2">
                                    <span class="p-1 rounded"
                                        :class="order.status == 0 ? 'bg-secondary text-white' : 'bg-green-200 text-green-800'">
                                        {{ order.status == 0 ? trans('admin.received') : trans('admin.purchased') }}
                                    </span>
                                </td>
                                <td class="border px-4 py-2">{{ formatDate(order.created_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination :data="orders" />
                </div>
                <div class="w-1/2 px-4">
                    <h2 class="text-lg text-white font-medium mb-4">
                        {{ trans('admin.payments') }}
                    </h2>
                    <table class="table-auto text-white w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">
                                    {{ trans('admin.paymentid') }}
                                </th>
                                <th class="px-4 py-2">{{ trans('admin.email') }}</th>
                                <th class="px-4 py-2">{{ trans('admin.amount') }}</th>
                                <th class="px-4 py-2">{{ trans('admin.status') }}</th>
                                <th class="px-4 py-2">{{ trans('admin.date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="payment in payments.data">
                                <td class="border px-4 py-2">{{ payment.id }}</td>
                                <td class="border px-4 py-2">{{ payment.payer_email }}</td>
                                <td class="border px-4 py-2">{{ payment.amount }}</td>
                                <td class="border px-4 py-2">
                                    <span class="p-1 rounded"
                                        :class="payment.payment_status == 0 ? 'bg-secondary text-white' : 'bg-green-200 text-green-800'">
                                        {{ payment.payment_status == 0 ? trans('admin.error.payment') :
                                            trans('admin.success.payment') }}
                                    </span>
                                </td>
                                <td class="border px-4 py-2">{{ formatDate(payment.created_at) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination :data="payments" />
                </div>
            </div>

        </div>
    </AdminLayout>
</template>

