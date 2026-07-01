<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout/Index.vue';

const page = usePage();
defineProps({ testimonials: { type: Array, default: () => [] } });

function destroy(testimonial) {
    if (confirm(`Delete the testimonial from "${testimonial.author}"?`)) {
        router.delete(`/internal/testimonials/${testimonial.id}`, { preserveScroll: true });
    }
}
</script>

<template>
    <Head title="Testimonials" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-warm-900 font-display">Testimonials</h1>
                    <p class="text-sm text-warm-500 mt-0.5">Manage customer testimonials</p>
                </div>
                <Link href="/internal/testimonials/create"
                      class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-600 text-white text-sm font-semibold rounded-xl hover:bg-brand-700 transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New testimonial
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
        <div v-if="!testimonials.length"
             class="text-center py-20 bg-warm-50 rounded-2xl border border-warm-200">
            <span class="text-4xl block mb-3">💬</span>
            <p class="font-semibold text-warm-800 mb-1">No testimonials yet</p>
            <p class="text-sm text-warm-500 mb-5">Add your first customer testimonial.</p>
            <Link href="/internal/testimonials/create"
                  class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-600 text-white text-sm font-semibold rounded-xl hover:bg-brand-700 transition-colors">
                Create a testimonial
            </Link>
        </div>

        <!-- Testimonials list -->
        <div v-else class="space-y-3">
            <div v-for="t in testimonials" :key="t.id"
                 class="flex items-start gap-4 p-4 bg-white border border-warm-200 rounded-2xl">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <p class="font-semibold text-warm-900 text-sm">{{ t.author }}</p>
                        <span v-if="t.role" class="text-xs text-warm-400">· {{ t.role }}</span>
                        <span v-if="t.rating" class="text-xs text-amber-500">{{ '★'.repeat(t.rating) }}</span>
                        <span v-if="t.homepage" class="text-[10px] font-semibold px-1.5 py-0.5 rounded-full bg-brand-100 text-brand-700">Homepage</span>
                        <span v-if="t.featured" class="text-[10px] font-semibold px-1.5 py-0.5 rounded-full bg-amber-100 text-amber-700">Featured</span>
                    </div>
                    <p v-if="t.headline" class="text-sm font-semibold text-warm-800 mt-1">{{ t.headline }}</p>
                    <p class="text-sm text-warm-600 mt-0.5 line-clamp-2">“{{ t.quote }}”</p>
                    <p class="text-xs text-warm-400 mt-1">Order: {{ t.order }}</p>
                </div>
                <Link :href="`/internal/testimonials/${t.id}/edit`"
                      class="px-3 py-1.5 text-sm font-medium text-warm-600 hover:text-brand-600 hover:bg-brand-50 rounded-lg transition-colors">
                    Edit
                </Link>
                <button type="button" @click="destroy(t)"
                        class="px-3 py-1.5 text-sm font-medium text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                    Delete
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
