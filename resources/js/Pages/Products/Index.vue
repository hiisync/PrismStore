<template>

    <Head>
        <title>{{ trans('global.nav.home') }}</title>
    </Head>
    <AppLayout>
        <div class="flex flex-col max-w-7xl mx-auto">
            <div v-if="$page.props.auth.user" class="flex justify-end space-x-3 text-white items-center my-5 rounded-md">
                <h2 class="font-medium">{{ trans('global.balance') }}: {{ $page.props.auth.user.balance }} ₴</h2>
                <Link :href="route('payments.index')">
                    <PrimaryButton>{{ trans('global.balance.refill') }}</PrimaryButton>
                </Link>
            </div>
            <form @submit.prevent="searchProducts" class="flex justify-end">
                <div class="my-5 space-x-2 flex">
                    <input v-model="search" class="text-white p-2 rounded bg-secondary" type="search" :placeholder="trans('global.search.placeholder')">
                    <PrimaryButton>{{ trans('global.search.button') }}</PrimaryButton>
                </div>
            </form>
            <div class="flex flex-wrap justify-center">
                <Link :href="route('home')" class="bg-primary hover:bg-opacity-70  text-white px-3 py-2 rounded-full text-sm mr-2 mb-2">
                    {{ trans('global.category.all') }}
                </Link>
                <button v-for="category in categories" @click="searchByCategory(category.id)" class="bg-primary hover:bg-opacity-70 text-white px-3 py-2 rounded-full text-sm mr-2 mb-2">
                    {{ category.name[getLang] }}
                </button>

            </div>
            <div v-if="products.length > 0" class="flex flex-wrap gap-3 mt-8">
                <div v-for="product in products.data" :key="product.id" class="group cursor-pointer w-28 gap-2">
                    <div class="relative">
                        <img
                            @click="openModal(product)"
                            class="rounded p-3 bg-primary hover:shadow-2xl"
                            :src="route('storage', product.image)"
                            :alt="product.name[getLang]"
                        />
                        <span class="absolute bottom-0 right-1 bg-opacity-80 bg-gray-100 px-2 rounded">
                          {{ product.price }} ₴
                        </span>
                    </div>
                    <p class="text-gray-500 p-2 group-hover:text-gray-300 truncate">{{ product.name[getLang] }}</p>
                </div>
            </div>
            <div v-else class="text-center text-white space-y-3 my-10">
                <i class="fa-solid text-7xl fa-ghost" style="color: #ffffff;"></i>
                <h1 class="font-bold">{{ trans("global.product.notfound") }}</h1>
            </div>

            <Pagination :data="products" />
        </div>

        <transition
            enter-active-class="duration-300 ease-out"
            enter-from-class="transform opacity-0 -translate-y-full"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="duration-200 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="transform opacity-0 -translate-y-full"
        >
            <div class="modal fixed inset-0 z-50 overflow-hidden flex items-center justify-center" v-if="selectedProduct">
                <div @click="closeModal" class="modal-background fixed inset-0 bg-secondary opacity-80"></div>
                <div class="modal-content bg-primary text-white rounded-lg px-4 py-6 w-full max-w-md mx-auto z-10 transform" style="transform-origin: top;">
                    <div class="modal-header flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold">{{ selectedProduct.name[getLang] }}</h3>
                        <button @click="closeModal" class="text-gray-300 text-lg hover:text-gray-100"><i class="fa-regular fa-circle-xmark"></i></button>
                    </div>
                    <img class="mx-auto h-32 my-2" :src="route('storage', selectedProduct.image)" :alt="selectedProduct.name[getLang]">
                    <p class="mb-2 text-center">{{ selectedProduct.description[getLang] }}</p>
                    <p class="text-lg font-bold mb-2 text-center">{{ price }} грн</p>

                    <form @submit.prevent="buyProduct">
                        <div class="quantity inline-flex mb-4 items-center justify-center">
                            <label for="quantity" class="mr-4">{{ trans('global.count') }}</label>
                            <input type="number" id="quantity" v-model="form.quantity" min="1" max="10" class="rounded bg-secondary text-center">
                            <InputError :message="form.errors.quantity" class="text-red-500" />
                        </div>
                        <div class="flex items-center my-2 justify-center">
                            <h1 class="text-red-500 text-xs">
                                {{ trans('global.product.howtoget') }}
                            </h1>
                        </div>
                        <div class="modal-buttons flex justify-end">
                            <DangerButton type="button" @click="closeModal" class="border rounded-lg px-4 py-2 mr-2">{{ trans('global.cancel') }}</DangerButton>
                            <PrimaryButton class="text-white px-4 py-2">{{ trans('global.buy') }}</PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </transition>


    </AppLayout>
</template>

<script setup lang="ts">
import {computed, ref, watch} from 'vue';
import {Head, router, useForm, Link, usePage} from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import { trans } from "laravel-vue-i18n";
import DangerButton from "@/Components/DangerButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Pagination from "@/Components/Pagination.vue";
import Toast from "awesome-toast-component";
import InputError from "@/Components/InputError.vue";

interface Product {
    name: { [key: string]: string };
    image: string;
    description: { [key: string]: string };
    price: number;
    id: number;
    data: {}
}

const selectedProduct = ref<Product | null>(null);
const quantity = ref(1);

let props = defineProps({
    products: {
        type: Object,
        required: true
    },
    getLang: {
        type: String,
        required: true
    },
    categories: {
        type: Object,
        required: true
    },
    user: {
        type: Object,
        required: false,
    }
});

let form = useForm({
    quantity: quantity.value,
    product_id: null as number | null,
});

const price = computed(() => {
    if (selectedProduct.value) {
        return selectedProduct.value?.price * form.quantity;
    }
    return 0;
});

const buyProduct = () => {
   if (usePage().props.auth.user){
       form.post(route('orders.store'), {
           preserveScroll: true,
           onSuccess: () => {
               form.reset();
               closeModal();
               new Toast(trans('global.buy.success'), {
                   position: 'top',
                   style: {
                       container: [
                           ['background-color', '#000000']
                       ],
                       message: [
                           ['color', '#ffffff'],
                       ],
                       bold: [
                           ['font-weight', 'bold'],
                       ]
                   }
               });
           },
           onError: () => {
               if (usePage().props.errors.balance){
                   new Toast(trans('validation.money.not_enough_funds'), {
                       style: {
                           position: 'top',
                           container: [
                               ['background-color', '#EF4444']
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
           }
       });
    }
   else if (!usePage().props.auth.user) {
         new Toast(trans('global.need_auth'), {
              position: 'top',
                 style: {
                     position: 'top',
                     container: [
                         ['background-color', '#EF4444']
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
}
let search = ref('');


function searchProducts() {
    router.get(
        route('home'),
        { search: search.value },
        {
            preserveState: true,
        }
    );
}

function searchByCategory(category: string) {
    router.get(
        route('home'),
        { category: category },
        {
            preserveState: true,
        }
    );
}

function openModal(product: Product) {
    selectedProduct.value = product;
}

function closeModal() {
    selectedProduct.value = null;
}

watch(selectedProduct, (newValue) => {
    form.product_id = newValue ? newValue.id : null;
});
</script>

