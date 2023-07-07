<script setup lang="ts">
import {Head, Link, router} from '@inertiajs/vue3';
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import {trans} from "laravel-vue-i18n";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {ref, watch} from "vue";
import debounce from "lodash/debounce";

let props = defineProps({
    roles: {
        type: Object,
        required: true
    },
});

let search = ref('');

watch(search, debounce((value: string) => {
    router.get(
        route('admin.roles.index'),
        { search: value },
        {
            preserveState: true,
        }
    );
}, 1000));

</script>

<template>
    <AdminLayout>
        <Head><title>{{ trans('admin.roles') }}</title></Head>
        <div class="float-right">
            <Link :href="route('admin.roles.create')">
                <PrimaryButton>{{ trans('admin.create') }}</PrimaryButton>
            </Link>
        </div>
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

                        <th class="text-right p-4 font-medium">
                            {{ trans('admin.actions') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="roles.data.length === 0">
                        {{ trans('admin.record.not_found') }}
                    </tr>
                    <tr v-for="role in roles.data" class="rounded-lg">
                        <td class="p-4">
                            {{ role.name }}
                        </td>

                        <td class="p-4 text-right space-x-2">
                            <Link v-if="role.name !== 'owner'" :href="route('admin.roles.edit', role)" method="get" as="button">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </Link>

                            <Link v-if="role.name !== 'owner' && role.name !== 'user'"  :href="route('admin.roles.destroy', role)" method="delete" as="button">

                                <i class="fa-solid fa-trash text-red-500"></i>

                            </Link>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <Pagination :data="roles" />
    </AdminLayout>
</template>
