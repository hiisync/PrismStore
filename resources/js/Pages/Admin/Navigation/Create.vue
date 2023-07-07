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

let props = defineProps(['categories'])

const form = useForm({
    name_uk: '',
    name_en: '',
    url: '',
    type: ''
})

const submit = () => {
    form.post(route('admin.navigations.store'), {
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
                    <InputLabel for="link" :value="trans('admin.link')" />
                    <TextInput id="link" v-model="form.url" placeholder="Link" />
                    <InputError class="mt-2" :message="form.errors.url" />
                </div>

                <div class="mt-4">
                    <InputLabel for="type" :value="trans('admin.nav.type')" />
                    <select id="type" class="w-full text-white p-2 rounded bg-secondary" v-model="form.type">
                        <option value="">-- {{ trans('admin.select') }} --</option>
                        <option value="navbar">{{ trans('admin.navigation') }}</option>
                        <option value="footer">{{ trans('admin.footer') }}</option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.type" />
                </div>


                <div class="mt-4">
                    <PrimaryButton class="mx-1" type="submit">{{ trans('admin.create') }}</PrimaryButton>

                    <Link class="mx-1" :href="route('admin.navigations.index')" as="button">
                    <DangerButton>{{ trans('admin.cancel') }}</DangerButton>
                    </Link>
                </div>

            </form>
        </div>
    </AdminLayout>
</template>
