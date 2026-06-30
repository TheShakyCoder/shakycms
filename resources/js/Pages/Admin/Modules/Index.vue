<script setup>
import { Head, router, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout/Index.vue';

const page = usePage();
defineProps({ modules: { type: Array, default: () => [] } });

function toggle(module) {
    router.put(`/admin/modules/${module.key}`, { active: !module.active }, {
        preserveScroll: true,
    });
}
</script>

<template>
    <Head title="Modules" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <h1 class="text-xl font-semibold text-warm-900 font-display">Modules</h1>
                <p class="text-sm text-warm-500 mt-0.5">Activate or deactivate feature areas of the site</p>
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

        <!-- Modules list -->
        <div class="space-y-4">
            <div v-for="module in modules" :key="module.key"
                 class="flex items-center gap-4 p-5 bg-white border border-warm-200 rounded-2xl">
                <div class="w-10 h-10 rounded-xl bg-brand-100 flex items-center justify-center shrink-0">
                    <span class="text-xl">🧩</span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <p class="font-semibold text-warm-900 text-sm">{{ module.name }}</p>
                        <span class="text-xs px-2 py-0.5 rounded-full"
                              :class="module.active ? 'bg-brand-100 text-brand-700' : 'bg-warm-100 text-warm-500'">
                            {{ module.active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <p class="text-sm text-warm-500 mt-0.5">{{ module.description }}</p>
                    <p class="text-xs text-warm-400 font-mono mt-0.5">{{ module.key }}</p>
                </div>

                <!-- Toggle -->
                <button type="button" role="switch" :aria-checked="module.active" @click="toggle(module)"
                        class="relative inline-flex h-6 w-11 shrink-0 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2"
                        :class="module.active ? 'bg-brand-600' : 'bg-warm-300'">
                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                          :class="module.active ? 'translate-x-6' : 'translate-x-1'" />
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
