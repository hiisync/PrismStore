
<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'
import Dropdown from "@/Components/Dropdown.vue"
import ApplicationLogo from "@/Components/ApplicationLogo.vue"
import DropdownLink from "@/Components/DropdownLink.vue"
import { trans } from "laravel-vue-i18n"
import { computed } from "vue"

interface NavbarItem {
    id: number
    name: { [key: string]: string }
    link?: string
    url: string
}
const page = usePage()

interface Locale {
    locale: string
}

const locale = page.props.locale as Locale['locale'];


const navbar = computed<NavbarItem[]>(() => {
    return (page.props.navbar as NavbarItem[]).map(item => ({
        id: item.id,
        name: item.name,
        link: item.link,
        url: item.url
    }))
})
</script>
<template>
    <nav class="bg-primary">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="relative flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                   <Link :href="route('home')">
                       <ApplicationLogo class="block h-9 w-auto fill-current text-gray-200" />
                   </Link>
                </div>
                <!-- Mobile menu -->
                <div class="absolute inset-y-0 right-0 flex items-center sm:hidden">
                    <button @click="toggleMenu" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
                        <span class="sr-only">Open main menu</span>
                        <!-- Heroicon name: menu -->
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!-- Heroicon name: x -->
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <!-- Desktop menu -->
                <div class="hidden sm:block sm:ml-6">
                    <div class="flex space-x-5">
                        <Link :href="route('home')" class="text-gray-300 hover:bg-secondary hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                           {{ trans('global.nav.home') }}
                        </Link>

                        <Link v-for="link in navbar" :href="link.url" class="text-gray-300 hover:bg-secondary hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            {{ link.name[locale] }}
                        </Link>

                        <div v-if="$page.props.auth.user" class="ml-3 relative">
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="text-gray-300 bg-secondary hover:text-white px-3 py-2 rounded-md text-base font-medium inline-flex"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                </template>

                                <template #content>
                                    <DropdownLink v-if="($page.props.auth as any).can['see admin dashboard']" :href="route('admin.dashboard')">
                                        {{ trans('admin.control_panel') }}
                                    </DropdownLink>
                                    <DropdownLink :href="route('logout')" method="post" as="button">
                                        {{ trans('auth.logout') }}
                                    </DropdownLink>
                                </template>
                            </Dropdown>
                        </div>

                        <a :href="route('login')" v-if="!$page.props.auth.user" class="text-gray-300 bg-secondary hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fa-brands fa-steam"></i>  {{ trans('auth.login') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile menu, toggle classes based on menu state -->
        <div v-show="isOpen" class="sm:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <Link :href="route('home')" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fas fa-home"></i> {{ trans('global.nav.home') }}
                </Link>


                <Link :href="route('logout')" v-if="$page.props.auth.user" class="text-gray-300 bg-secondary hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fa-solid fa-square-xmark"></i>  {{ trans('auth.logout') }}
                </Link>

                <a :href="route('login')" v-else class="text-gray-300 bg-secondary hover:text-white block px-3 py-2 rounded-md text-base font-medium">
                    <i class="fa-brands fa-steam"></i>  {{ trans('auth.login') }}
                </a>
            </div>
        </div>
    </nav>
</template>

<script lang="ts">


export default {
    data() {
        return {
            isOpen: false,
        };
    },
    methods: {
        toggleMenu() {
            this.isOpen = !this.isOpen;
        },
    },
};
</script>
