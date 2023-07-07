<script setup lang="ts">

import { useForm, Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Toast from "awesome-toast-component";
import { trans } from "laravel-vue-i18n";
import TextInput from '@/Components/TextInput.vue';

let props = defineProps(['user', 'permissions', 'roles'])

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    balance: props.user.balance,
    roles: props.user.roles.map((role: any) => role.id),
    permissions: props.user.permissions.map((permission: any) => permission.id),
})

const submit = () => {
    form.put(route('admin.users.update', props.user), {
        preserveScroll: true,
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
    })
}
</script>

<template>
    <Head>
        <title>{{ user.name }}</title>
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

                <div class="mt-4">
                    <InputLabel for="email" :value="'Email'" />
                    <TextInput id="email" v-model="form.email" placeholder="Email"
                        :class="'w-full text-white p-2 rounded bg-secondary'">
                    </TextInput>
                    <InputError :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="email" :value="trans('admin.user.balance')" />
                    <TextInput id="email" v-model="form.balance" :placeholder="trans('admin.user.balance')"
                        :class="'w-full text-white p-2 rounded bg-secondary'">
                    </TextInput>
                    <InputError :message="form.errors.balance" />
                </div>

                <div class="mt-4 bg-secondary p-5 space-y-3 space-x-2">
                    <div class="w-full p-2">
                        <label class="block text-sm font-medium text-gray-100 mb-2">{{ trans('admin.roles') }}</label>
                        <div class="flex flex-wrap">
                            <div v-for="role in roles">
                                <div :key="role.id" class="flex items-center mr-4">
                                    <input v-model="form.roles" :value="role.name"
                                        :checked="role.name === user.roles[0]?.name" type="radio"
                                        :class="'h-4 w-4 text-indigo-600 transition duration-150 ease-in-out'" />
                                    <label class="ml-2 text-sm text-gray-300 font-medium">{{ role.name }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 bg-secondary p-5 space-y-3 space-x-2">
                    <div class="w-full p-2">
                        <label class="block text-sm font-medium text-gray-100 mb-2">{{ trans('admin.permissions') }}</label>
                        <div class="flex flex-wrap">
                            <div v-for="permission in permissions">
                                <div :key="permission.id" class="flex items-center mr-4">
                                    <input v-model="form.permissions" :value="permission.id"
                                        :checked="user.permissions.some((userPermission: any) => userPermission.id === permission.id)"
                                        type="checkbox"
                                        :class="'form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out'" />
                                    <label class="ml-2 text-sm text-gray-300 font-medium">{{ permission.name }}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <PrimaryButton :class="'mx-1'" type="submit">Update</PrimaryButton>

                    <Link :href="route('admin.users.index')" as="button">
                    <DangerButton>Cancel</DangerButton>
                    </Link>
                </div>

            </form>
        </div>
    </AdminLayout>
</template>
