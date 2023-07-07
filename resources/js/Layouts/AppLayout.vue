<template>
    <div>
        <div class="min-h-screen bg-secondary">
        <!-- Navbar -->
            <Navbar />
            <!-- Page Heading -->
            <header class="bg-white dark:bg-gray-800 shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>

        <footer class="bg-primary py-6">
            <div class="container mx-auto px-4">
                <div class="flex flex-wrap justify-between items-center">
                    <!-- Left section -->
                    <div class="w-full sm:w-1/2">
                        <p class="text-gray-500 w-60 text-sm">
                           {{ new Date().getFullYear() }} © {{ $page.props.appName }}. {{ trans('global.rights_reserved') }}
                        </p>
                    </div>

                    <!-- Right section -->
                    <div v-if="footer.length > 0" class="w-full sm:w-1/2">
                        <ul class="flex space-x-2 justify-end items-center">
                            <li v-for="link in footer">
                                <Link :href="link.url" class="text-gray-500 hover:text-gray-400">
                                   {{ link.name[locale] }}
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</template>
<script setup lang="ts">
import Navbar from "@/Components/Navbar.vue";
import {trans} from "laravel-vue-i18n";
import {usePage, Link} from "@inertiajs/vue3";
import {computed} from "vue";

interface FooterItem {
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


const footer = computed<FooterItem[]>(() => {
    return (page.props.footer as FooterItem[]).map(item => ({
        id: item.id,
        name: item.name,
        link: item.link,
        url: item.url
    }))
})
</script>
