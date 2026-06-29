<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    page: Object,
});
</script>

<template>
    <Head :title="page.title ?? 'Home'" />

    <div class="min-h-screen bg-gray-100 p-6 dark:bg-gray-900">
        <div class="mx-auto max-w-7xl">
            <div
                class="overflow-hidden bg-white p-6 text-gray-900 shadow-sm sm:rounded-lg dark:bg-gray-800 dark:text-gray-100"
            >
                <h1 class="text-2xl font-semibold">{{ page.title }}</h1>
                <h2>MASTER</h2>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Page slug: <code>{{ page.slug }}</code>
                </p>
            </div>
        </div>
    </div>
</template>
