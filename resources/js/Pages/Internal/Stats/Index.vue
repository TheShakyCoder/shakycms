<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout/Index.vue';

const page = usePage();
defineProps({ stats: { type: Array, default: () => [] } });

function destroy(stat) {
    if (confirm(`Delete the "${stat.label}" stat?`)) {
        router.delete(`/internal/stats/${stat.id}`, { preserveScroll: true });
    }
}
</script>

<template>
    <Head title="Stats" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-warm-900 font-display">Stats</h1>
                    <p class="text-sm text-warm-500 mt-0.5">Manage the statistics shown on the homepage</p>
                </div>
                <Link href="/internal/stats/create"
                      class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-600 text-white text-sm font-semibold rounded-xl hover:bg-brand-700 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New stat
                </Link>
            </div>
        </template>

        <!-- Flash -->
        <div v-if="page.props.flash.success"
             class="mb-6 flex items-center gap-2 px-4 py-3 bg-brand-50 border border-brand-200 rounded-xl text-sm text-brand-700">
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ page.props.flash.success }}
        </div>

        <!-- Empty state -->
        <div v-if="!stats.length"
             class="text-center py-20 bg-warm-50 rounded-2xl border border-warm-200">
            <span class="text-4xl block mb-3">📊</span>
            <p class="font-semibold text-warm-800 mb-1">No stats yet</p>
            <p class="text-sm text-warm-500 mb-5">Add your first stat to show it on the homepage.</p>
            <Link href="/internal/stats/create"
                  class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-600 text-white text-sm font-semibold rounded-xl hover:bg-brand-700 transition-colors">
                Create a stat
            </Link>
        </div>

        <!-- Stats list -->
        <div v-else class="space-y-3">
            <div v-for="stat in stats" :key="stat.id"
                 class="flex items-center gap-4 p-4 bg-white border border-warm-200 rounded-2xl">
                <div v-if="stat.icon" class="w-8 text-center shrink-0 text-2xl leading-none">{{ stat.icon }}</div>
                <div class="w-14 text-center shrink-0">
                    <p class="font-display text-2xl font-extrabold text-brand-600" v-html="stat.value"></p>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-warm-900 text-sm truncate">{{ stat.label }}</p>
                    <p class="text-xs text-warm-400 mt-0.5">Order: {{ stat.order }}</p>
                </div>
                <Link :href="`/internal/stats/${stat.id}/edit`"
                      class="px-3 py-1.5 text-sm font-medium text-warm-600 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-colors">
                    Edit
                </Link>
                <button type="button" @click="destroy(stat)"
                        class="px-3 py-1.5 text-sm font-medium text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                    Delete
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
