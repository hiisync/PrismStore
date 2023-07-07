<script setup lang="ts">
import {Head, Link, router} from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from "@/Components/Pagination.vue";
import {trans} from "laravel-vue-i18n";
import {ref, watch} from "vue";
import debounce from "lodash/debounce";

let props = defineProps({
    users: {
        type: Object,
        required: true
    },
});

let search = ref('');

watch(search, debounce((value: string) => {
    router.get(
        route('admin.users.index'),
        { search: value },
        {
            preserveState: true,
        }
    );
}, 1000));

function capitalizeFirstLetter(string: string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}
</script>

<template>
    <AdminLayout>
        <Head><title>{{ trans('admin.users') }}</title></Head>
        <div class="justify-between flex">
            <input v-model="search" class="text-white p-2 rounded bg-secondary" type="search" :placeholder="trans('admin.search')">
        </div>
        <div class="bg-primary my-10">
            <div class="overflow-x-auto text-white">
                <table class="table-auto w-full">
                    <thead class="">
                    <tr class="bg-secondary">
                        <th class="text-left p-4 font-medium">
                            {{ trans('admin.name') }}
                        </th>
                        <th class="text-left p-4 font-medium">
                            {{ trans('admin.email') }}
                        </th>
                        <th class="text-left p-4 font-medium">
                            {{ trans('admin.roles') }}
                        </th>
                        <th class="text-left p-4 font-medium">
                            {{ trans('admin.actions') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="users.data.length === 0">
                        {{ trans('admin.record.not_found') }}
                    </tr>
                    <tr v-for="user in users.data" class="rounded-lg">
                        <td class="p-4">
                            <img :src="user.avatar"
                                 class="w-8 h-8 rounded-full mr-2"
                                 :alt="user.name" />
                            {{ user.name }}
                        </td>
                        <td class="p-4">
                            {{ user.email }}
                        </td>
                        <td class="p-4 font-semibold">
                            <div>
                                {{ user.roles[0]?.name ? capitalizeFirstLetter(user.roles[0].name) : 'Undefined' }}
                            </div>
                        </td>
                        <td class="p-4  space-x-2">
                            <Link :href="route('admin.users.edit', user)" method="get" as="button">
                                    <i class="fa-solid fa-pen-to-square"></i>
                            </Link>

                            <Link :href="route('admin.users.show', user)" method="get" as="button">

                                    <i class="fa-solid fa-eye text-blue-500"></i>

                            </Link>

                            <Link v-if="$page.props.auth.user.id !== user.id"  :href="route('admin.users.destroy', user)" method="delete" as="button">

                                    <i class="fa-solid fa-trash text-red-500"></i>

                            </Link>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <Pagination :data="users" />
    </AdminLayout>
</template>
