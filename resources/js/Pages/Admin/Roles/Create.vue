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

let props = defineProps(['permissions'])

const form = useForm({
    name: '',
    permissions: [],
})

const submit = () => {
    form.post(route('admin.roles.store'), {
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
        <title>{{ trans('admin.roles.create') }}</title>
    </Head>

    <AdminLayout>
        <div class="bg-primary text-white my-10 p-5">
            <form @submit.prevent="submit">
                <div class="mt-4">
                    <InputLabel for="name" :value="trans('admin.name')" />
                    <TextInput id="name" v-model="form.name" placeholder="Name"
                        :class="'w-full text-white p-2 rounded bg-secondary'">
                    </TextInput>
                    <InputError :message="form.errors.name" />
                </div>

                <div class="mt-4 bg-secondary p-5 space-y-3 space-x-2">
                    <div class="w-full p-2">
                        <InputLabel :for="form.permissions" :value="trans('admin.permissions')" />
                        <div class="flex flex-wrap">
                            <div v-for="permission in permissions">
                                <div :key="permission.id" class="flex items-center mr-4">
                                    <input v-model="form.permissions" :value="permission.id" type="checkbox"
                                        :class="'form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out'" />
                                    <label class="ml-2 text-sm text-gray-300 font-medium">{{ permission.name }}</label>
                                </div>
                            </div>
                        </div>
                        <InputError :message="form.errors.permissions" />
                    </div>
                </div>

                <div class="mt-4">
                    <PrimaryButton :class="'mx-1'" type="submit">{{ trans('admin.create') }}</PrimaryButton>

                    <Link :href="route('admin.roles.index')" as="button">
                    <DangerButton>{{ trans('admin.cancel') }}</DangerButton>
                    </Link>
                </div>

            </form>
        </div>
    </AdminLayout>
</template>
