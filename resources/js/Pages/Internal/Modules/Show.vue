<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout/Index.vue';

const props = defineProps({ module: { type: Object, required: true } });
</script>

<template>
    <Head :title="module.name" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-xl font-semibold text-warm-900 font-display">{{ module.name }}</h1>
                <p class="text-sm text-warm-500 mt-0.5">Module</p>
            </div>
        </template>

        <div class="max-w-xl">
            <div class="bg-white border border-warm-200 rounded-2xl p-7 shadow-sm">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-11 h-11 rounded-xl bg-brand-100 flex items-center justify-center shrink-0">
                        <span class="text-xl">🧩</span>
                    </div>
                    <div>
                        <p class="font-semibold text-warm-900">{{ module.name }}</p>
                        <span class="text-xs px-2 py-0.5 rounded-full"
                              :class="module.active ? 'bg-brand-100 text-brand-700' : 'bg-warm-100 text-warm-500'">
                            {{ module.active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                <p class="text-sm text-warm-600 leading-relaxed">{{ module.description }}</p>

                <!-- Inactive guidance -->
                <div v-if="!module.active"
                     class="mt-6 flex items-start gap-2 px-4 py-3 bg-warm-50 border border-warm-200 rounded-xl text-sm text-warm-600">
                    <svg class="w-4 h-4 shrink-0 mt-0.5 text-warm-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>This module is currently switched off. An admin can enable it in
                        <Link href="/admin/modules" class="font-medium text-brand-600 hover:text-brand-700">Admin → Modules</Link>.</span>
                </div>

                <!-- Active with a page -->
                <div v-else-if="module.route" class="mt-6">
                    <Link :href="route(module.route)"
                          class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-600 text-white text-sm font-semibold rounded-xl hover:bg-brand-700 transition-colors shadow-sm">
                        Open {{ module.name }}
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
