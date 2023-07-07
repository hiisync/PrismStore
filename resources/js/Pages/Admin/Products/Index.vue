<script setup lang="ts">
import {Head, Link, router, useForm} from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Pagination from "@/Components/Pagination.vue";
import {trans} from "laravel-vue-i18n";
import {ref, watch} from "vue";
import debounce from "lodash/debounce";
import Toast from 'awesome-toast-component';
import PrimaryButton from "@/Components/PrimaryButton.vue";

let props = defineProps({
    products: {
        type: Object,
        required: true
    },
    locale: {
        type: String,
        required: true
    },
});

let search = ref('');

watch(search, debounce((value: string) => {
    router.get(
        route('admin.products.admin'),
        { search: value },
        {
            preserveState: true,
        }
    );
}, 1000));

const form = useForm({
    product: '',
});

const remove = (value: any) => {
    form.delete(route('admin.products.destroy', value), {
        preserveScroll: true,
        onSuccess: () => {
            new Toast(trans('admin.remove.success'), {
                position: 'top',
                style: {
                    container: [
                        ['background-color', 'green']
                    ],
                    message: [
                        ['color', '#eee'],
                    ],
                    bold: [
                        ['font-weight', 'bold'],
                    ]
                }
            });
        },
        onError: () => {
            new Toast(trans('admin.remove.error'), {
                style: {
                    position: 'top',
                    container: [
                        ['background-color', 'red']
                    ],
                    message: [
                        ['color', '#eee'],
                    ],
                    bold: [
                        ['font-weight', 'bold'],
                    ]
                }
            });
        }
    });
};

</script>

<template>
    <AdminLayout>
        <Head><title>{{ trans('admin.products') }}</title></Head>
        <div class="float-right">
            <Link :href="route('admin.products.create')">
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
                        <th class="text-left p-4 font-medium">
                            {{ trans('admin.categories') }}
                        </th>
                        <th class="text-left p-4 font-medium">
                            {{ trans('admin.price') }}
                        </th>
                        <th class="text-left p-4 font-medium">
                            {{ trans('admin.actions') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="products.data.length === 0">
                            {{ trans('admin.record.not_found') }}
                    </tr>
                    <tr v-for="product in products.data" class="rounded-lg">
                        <td class="p-4">
                            <img :src="route('storage', product.image)"
                                 class="w-8 h-8 rounded-full mr-2"
                                 :alt="product.name" />
                            {{ product.name[locale] }}
                        </td>
                        <td class="p-4">
                            {{ product.category.name[locale] }}
                        </td>
                        <td class="p-4">
                            {{ product.price }}
                        </td>
                        <td class="p-4  space-x-2">
                            <Link :href="route('admin.products.edit', product)" method="get" as="button">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </Link>

                            <Link href="#" @click="remove(product)">

                                <i class="fa-solid fa-trash text-red-500"></i>

                            </Link>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <Pagination :data="products" />
    </AdminLayout>
</template>
