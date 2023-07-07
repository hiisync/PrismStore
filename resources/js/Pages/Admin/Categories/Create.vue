<script setup lang="ts">

import { useForm, Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from '@/Components/TextInput.vue';
import { trans } from "laravel-vue-i18n";
import Toast from "awesome-toast-component";

let props = defineProps(['categories'])

const form = useForm({
    name_uk: '',
    name_en: '',
})

const submit = () => {
    form.post(route('admin.categories.store'), {
        preserveScroll: true,
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
</script>

<template>
    <Head>
        <title>{{ trans('admin.create') }}</title>
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
                    <InputLabel for="name" :value="trans('admin.name')" />
                    <small>English</small>
                    <TextInput id="name" v-model="form.name_en" placeholder="Name" />
                    <InputError class="mt-2" :message="form.errors.name_en" />
                </div>


                <div class="mt-4">
                    <PrimaryButton class="mx-1" type="submit">{{ trans('admin.create') }}</PrimaryButton>

                    <Link class="mx-1" :href="route('admin.categories.index')" as="button">
                    <DangerButton>{{ trans('admin.cancel') }}</DangerButton>
                    </Link>
                </div>

            </form>
        </div>
    </AdminLayout>
</template>
