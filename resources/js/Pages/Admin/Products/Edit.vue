<script setup lang="ts">

import { useForm, Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from '@/Components/TextInput.vue';
import Toast from "awesome-toast-component";
import { trans } from "laravel-vue-i18n";

let props = defineProps(['product', 'categories', 'locale'])

const form = useForm({
    name_uk: props.product.name['uk'],
    name_en: props.product.name['en'],
    description_uk: props.product.description['uk'],
    description_en: props.product.description['en'],
    price: props.product.price,
    category_id: props.product.category_id,
    image: '',
    type: props.product.type,
    item: props.product.item,
    command: props.product.command,
    _method: 'put',
    amount: props.product.amount,
})

const submit = (product: any) => {
    form.post(route('admin.products.update', product), {
        onSuccess: () => {
            new Toast(trans('admin.record.updated'), {
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
    });
}

const onFileChange = (event: any) => {
    form.image = event.target.files[0];
};

</script>

<template>
    <Head>
        <title>{{ product.name[locale] }}</title>
    </Head>

    <AdminLayout>
        <div class="bg-primary text-white my-10 p-5">
            <form @submit.prevent="submit(product)">
                <div class="mt-4">
                    <InputLabel for="name_uk" value="Name" />
                    <small>Українською</small>
                    <TextInput id="name_uk" v-model="form.name_uk" placeholder="Name" />
                    <InputError class="mt-2" :message="form.errors.name_uk" />
                </div>

                <div class="mt-4">
                    <InputLabel for="name_en" value="Name" />
                    <small>English</small>
                    <TextInput id="name_en" v-model="form.name_en" placeholder="Email" />
                    <InputError class="mt-2" :message="form.errors.name_en" />
                </div>

                <div class="mt-4">
                    <InputLabel for="description_uk" value="Description" />
                    <small>Українською</small>
                    <textarea id="description_uk" v-model="form.description_uk" placeholder="Description"
                        class="w-full text-white p-2 rounded bg-secondary"></textarea>
                    <InputError class="mt-2" :message="form.errors.description_uk" />
                </div>

                <div class="mt-4">
                    <InputLabel for="description_en" value="Description" />
                    <small>English</small>
                    <textarea id="description_en" v-model="form.description_en" placeholder="Description"
                        class="w-full text-white p-2 rounded bg-secondary"></textarea>
                    <InputError class="mt-2" :message="form.errors.description_en" />
                </div>

                <div class="mt-4">
                    <InputLabel for="price" value="Price" />
                    <TextInput id="price" v-model="form.price" placeholder="Price"
                        class="w-full text-white p-2 rounded bg-secondary" />
                    <InputError class="mt-2" :message="form.errors.price" />
                </div>

                <div class="mt-4">
                    <InputLabel for="category_id" value="Category" />
                    <select id="category_id" v-model="form.category_id" class="w-full text-white p-2 rounded bg-secondary">
                        <option v-for="category in categories" :value="category.id">{{ category.name[locale] }}</option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.category_id" />
                </div>

                <div class="mt-4">
                    <InputLabel for="image" value="Image" />
                    <TextInput id="image" type="file" @change="onFileChange" placeholder="Image"
                        class="w-full text-white p-2 rounded bg-secondary" />
                    <InputError class="mt-2" :message="form.errors.image" />
                    <img :src="route('storage', product.image)" class="w-20 h-20 object-cover" alt="">
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
                        <TextInput id="itemInput" type="text" v-model="form.item" />
                        <InputError class="mt-2" :message="form.errors.item" />
                    </div>

                    <div v-if="form.type === 'item'">
                        <InputLabel for="itemAmount" :value="trans('admin.amount')" />
                        <TextInput type="text" id="itemAmount" v-model="form.amount" />
                        <InputError class="mt-2" :message="form.errors.amount" />
                    </div>

                </div>


                <div class="mt-4">
                    <PrimaryButton class="mx-1" type="submit">Update</PrimaryButton>

                    <Link class="mx-1" :href="route('admin.products.admin')" as="button">
                    <DangerButton>{{ trans('admin.cancel') }}</DangerButton>
                    </Link>
                </div>

            </form>
        </div>
    </AdminLayout>
</template>
