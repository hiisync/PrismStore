<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import {trans} from "laravel-vue-i18n";


const links = ref([
    { name: 'admin.dashboard', href: route('admin.dashboard'), icon: 'fa-solid fa-gauge' },
    { name: 'admin.users', href: route('admin.users.index'), icon: 'fa-solid fa-users' },
    { name: 'admin.roles', href: route('admin.roles.index'), icon: 'fa-solid fa-user-tag' },
    { name: 'admin.products', href: route('admin.products.admin'), icon: 'fa-solid fa-boxes' },
    { name: 'admin.categories', href: route('admin.categories.index'), icon: 'fa-solid fa-tags' },
    { name: 'admin.pages', href: route('admin.pages.index'), icon: 'fa-regular fa-file-lines' },
    { name: 'admin.navigation', href: route('admin.navigations.index'), icon: 'fa-solid fa-bars' },
]);

</script>
<template>
    <div class="flex flex-col h-screen">
        <!-- Navbar -->
        <nav class="bg-primary px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex space-x-2 items-center">

                    <button @click="openSidebar" class="text-white focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                <div class="flex items-center">
                    <div class="ml-4 space-x-3">
                        <Link :href="route('home')" class="bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-600 focus:outline-none">
                            <i class="fa-solid fa-home"></i> {{ trans('global.nav.home') }}
                        </Link>
                        <Link method="post" as="button" :href="route('logout')" class="bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-600 focus:outline-none">
                            <i class="fa-solid fa-sign-out"></i> {{ trans('auth.logout') }}
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar -->
        <div class="flex flex-col md:flex-row flex-1">

            <div :class="sidebarOpen ? 'block' : 'hidden'"
                 class="bg-primary md:bg-primary text-white md:text-gray-400 px-4 py-4 md:w-64 flex-shrink-0 transition-all duration-300 ease-in-out"
                 v-if="sidebarOpen">
                <ul class="overflow-y-auto">
                    <li v-for="link in links" class="mb-2">
                        <Link :href="link.href"
                              class="block py-2 px-4 rounded-md hover:bg-secondary transition-colors duration-300 ease-in-out">
                            <i class="mx-0.5" :class="link.icon"></i> {{ trans(link.name) }}
                        </Link>
                    </li>
                </ul>
            </div>


            <!-- Content -->
            <div class="flex-1 bg-secondary overflow-y-auto">
                <div class="container mx-auto px-4 py-4">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>



<script>
export default {
    data() {
        return {
            sidebarOpen: true
        }
    },
    methods: {
        openSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
        }
    }
}
</script>
