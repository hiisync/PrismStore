<script setup lang="ts">
import { Link }  from '@inertiajs/vue3';

defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
});
</script>


<template>
    <div v-if="data.links.length > 3" class="flex justify-center mt-4 space-x-2">
        <Link
            v-for="(link, k) in data.links"
            :key="k"
            class="px-4 py-3 text-sm leading-4 bg-white rounded hover:bg-white focus:text-indigo-500 hover:shadow"
            :class="{'text-gray-400': link.active}"
            :href="link.url ? link.url : '#'"
            v-html="link.label"
        />
    </div>
</template>
