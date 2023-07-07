<script setup lang="ts">


import {useForm, Head, Link, usePage} from '@inertiajs/vue3'
import AdminLayout from '@/Layouts/AdminLayout.vue'
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {trans} from "laravel-vue-i18n";
import Toast from "awesome-toast-component";
const page = usePage()
let props = defineProps({
    settings:{
        type: Object,
        required: true
    }
})

interface Locale {
    locale: string
}


const locale = page.props.locale as Locale['locale'];

const form = useForm({
    key: '',
    value: '',
})

const submit = () => {
    form.put(route('admin.settings.update', form.key), {
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
    <Head><title>{{ trans('admin.edit') }}</title></Head>

    <AdminLayout>
        <div class="bg-primary text-white my-10 p-5">
            <form @submit.prevent="submit">

                <div class="mt-4" v-for="setting in settings">
                    <InputLabel for="name" :value="setting.name" />
                    <small>Українською</small>
                    <input id="name" v-model="setting.key" placeholder="Name" class="w-full text-white p-2 rounded bg-secondary" >
                    <InputError class="mt-2" :message="form.errors.key" />
                </div>


                <div class="mt-4">
                    <PrimaryButton class="mx-1" type="submit">{{ trans('admin.update') }}</PrimaryButton>

                    <Link class="mx-1" :href="route('admin.categories.index')" as="button">
                        <DangerButton>{{ trans('admin.cancel') }}</DangerButton>
                    </Link>
                </div>

            </form>
        </div>
    </AdminLayout>
</template>
