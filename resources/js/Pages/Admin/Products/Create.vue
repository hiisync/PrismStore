<script setup lang="ts">

import { useForm, Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import { trans } from "laravel-vue-i18n";
import Toast from "awesome-toast-component";
import TextInput from '@/Components/TextInput.vue';
let props = defineProps(['locale', 'categories'])

const form = useForm({
    name_en: '',
    name_uk: '',
    description_en: '',
    description_uk: '',
    price: '',
    image: null,
    category_id: '',
    command: '',
    item: '',
    type: '',
    amount: 1,
})

const submit = () => {
    form.post(route('admin.products.store'), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            new Toast(trans('admin.record.created'), {
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
            new Toast(trans('admin.record.oops'), {
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
    })
}

const onFileChange = (event: any) => {
    form.image = event.target.files[0];
};
</script>

<template>
    <Head>
        <title>{{ trans('admin.products.create') }}</title>
    </Head>

    <AdminLayout>
        <div class="bg-primary text-white my-10 p-5">
            <form @submit.prevent="submit">
                <div class="mt-4">
                    <InputLabel for="name" :value="trans('admin.name')" />
                    <small>Українською</small>
                    <TextInput id="name" v-model="form.name_uk" placeholder="Name" />
                    <InputError class="mt-2" :message="form.errors.name_uk" />
                </div>

                <div class="mt-4">
                    <InputLabel for="desciption" :value="trans('admin.description')" />
                    <small>Українською</small>
                    <textarea id="description" v-model="form.description_uk" placeholder="Description"
                        class="w-full text-white p-2 rounded bg-secondary"></textarea>
                    <InputError class="mt-2" :message="form.errors.description_uk" />
                </div>

                <div class="mt-4">
                    <InputLabel for="name" :value="trans('admin.name')" />
                    <small>English</small>
                    <TextInput id="name" v-model="form.name_en" placeholder="Name" />
                    <InputError class="mt-2" :message="form.errors.name_en" />
                </div>


                <div class="mt-4">
                    <InputLabel for="desciption" :value="trans('admin.description')" />
                    <small>English</small>
                    <textarea id="description" v-model="form.description_en" placeholder="Description"
                        class="w-full text-white p-2 rounded bg-secondary"></textarea>
                    <InputError class="mt-2" :message="form.errors.description_en" />
                </div>

                <div class="mt-4">
                    <InputLabel for="price" :value="trans('admin.price')" />
                    <TextInput id="price" v-model="form.price" placeholder="..." />
                    <InputError class="mt-2" :message="form.errors.price" />
                </div>

                <div class="mt-4">
                    <InputLabel for="image" :value="trans('admin.image')" />
                    <TextInput id="image" type="file" @change="onFileChange" />
                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                        {{ form.progress.percentage }}%
                    </progress>
                    <a target="_blank" href="https://rust-items.com/">
                        <small class="p-3 bg-secondary">
                            <i class="fa-solid fa-paperclip"></i>
                            {{ trans('admin.itemslist') }}
                        </small>
                    </a>
                    <InputError class="mt-2" :message="form.errors.image" />
                </div>

                <div class="mt-4">
                    <InputLabel for="categories" :value="trans('admin.categories')" />
                    <select id="categories" v-model="form.category_id" class="w-full text-white p-2 rounded bg-secondary">
                        <option selected disabled value="">{{ trans('admin.categories.select') }}</option>
                        <option v-for="category in categories" :value="category.id">{{ category.name[locale] }}</option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.category_id" />
                </div>

                <div class="mt-4 space-y-2">

                    <InputLabel for="type" :value="trans('admin.product.type')" />
                    <select id="type" class="w-full text-white p-2 rounded bg-secondary" v-model="form.type">
                        <option value="">-- {{ trans('admin.product.type.select') }} --</option>
                        <option value="command">{{ trans('admin.command') }}</option>
                        <option value="item">{{ trans('admin.item') }}</option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.type" />

                    <div v-if="form.type === 'command'">
                        <InputLabel for="commandInput" :value="trans('admin.command.label')" />
                        <TextInput type="text" id="commandInput" v-model="form.command" />
                        <InputError class="mt-2" :message="form.errors.command" />
                    </div>

                    <div v-if="form.type === 'item'">
                        <InputLabel for="itemInput" :value="trans('admin.item.label')" />
                        <TextInput type="text" id="itemInput" v-model="form.item" />
                        <InputError class="mt-2" :message="form.errors.item" />
                    </div>

                    <div v-if="form.type === 'item'">
                        <InputLabel for="itemAmount" :value="trans('admin.amount')" />
                        <TextInput type="number" id="itemAmount" v-model="form.amount" />
                        <InputError class="mt-2" :message="form.errors.amount" />
                    </div>

                </div>


                <div class="mt-4">
                    <PrimaryButton class="mx-1" type="submit">{{ trans('admin.create') }}</PrimaryButton>

                    <Link class="mx-1" :href="route('admin.products.admin')" as="button">
                    <DangerButton>{{ trans('admin.cancel') }}</DangerButton>
                    </Link>
                </div>

            </form>
        </div>
    </AdminLayout>
</template>
