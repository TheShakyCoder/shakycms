<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: { type: String, required: true },
    title: { type: String, required: true },
});
</script>

<template>
    <Link
        :href="route(href)"
        class="px-3 py-2 text-sm font-medium rounded-lg transition-colors"
        :class="
            route().current(href)
                ? 'bg-brand-50 text-brand-700'
                : 'text-warm-600 hover:bg-warm-100 hover:text-warm-900'
        "
    >
        {{ title }}
    </Link>
</template>
