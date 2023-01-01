<template>
    <div class="flex">
        <template v-for="(link, key) in links" :key="key"></template>
        <div v-if="link.url === null" v-html="link.label" class="mb-1 mr-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"></div>
        <Link v-else :href="link.url" v-html="link.label" class="mb-1 mr-1 px-4 py-3 text-gray-900 text-sm leading-4 border rounded hover:bg-white focus:text-indigo-500 focus:border-indigo-400" :class="{'bg-indigo-100':link.active}"></Link>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";
defineProps({
    links: [],
});
</script>
