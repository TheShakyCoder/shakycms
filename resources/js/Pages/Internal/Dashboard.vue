<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout/Index.vue';

const page = usePage();

const allSections = {
    'posts':         { label: 'Posts',         icon: '📰' },
    'pages':         { label: 'Pages',         icon: '📄' },
    'media':         { label: 'Media',         icon: '🖼️' },
    'menu-items':    { label: 'Menu Items',    icon: '🔗' },
    'competitions':  { label: 'Competitions',  icon: '🏆' },
    'activities':    { label: 'Activities',    icon: '📅' },
    'meetings':      { label: 'Meetings',      icon: '🗓️' },
    'page-views':    { label: 'Page Views',    icon: '👁️' },
    'field-changes': { label: 'Field Changes', icon: '🔀' },
};

const isAdmin = computed(() => page.props.auth?.user?.is_admin);

const indexLinks = computed(() => {
    // Admins see everything.
    if (isAdmin.value) {
        return Object.entries(allSections).map(([resource, section]) => ({
            label: section.label,
            href:  `/internal/${resource}`,
            icon:  section.icon,
        }));
    }

    return (page.props.can ?? [])
        .filter(p => typeof p === 'string' && p.endsWith('.index'))
        .map(p => {
            const resource = p.split('.').slice(1, -1).join('-');
            const section = allSections[resource];
            return section ? {
                label: section.label,
                href:  `/internal/${resource}`,
                icon:  section.icon,
            } : null;
        })
        .filter(Boolean);
});

const stats = [
    { label: 'Upcoming Events', value: '4', icon: '📅', change: '+2 this week', trend: 'up', color: 'bg-white border-warm-200', iconBg: 'bg-warm-100', valueColor: 'text-warm-900' },
    { label: 'Active Members', value: '1,248', icon: '👥', change: '+12 this month', trend: 'up', color: 'bg-white border-warm-200', iconBg: 'bg-warm-100', valueColor: 'text-warm-900' },
    { label: 'News Articles', value: '18', icon: '📰', change: '3 drafts pending', trend: 'neutral', color: 'bg-white border-warm-200', iconBg: 'bg-warm-100', valueColor: 'text-warm-900' },
    { label: 'Volunteers', value: '152', icon: '🤝', change: '+5 new sign-ups', trend: 'up', color: 'bg-white border-warm-200', iconBg: 'bg-warm-100', valueColor: 'text-warm-900' },
];

const recentActivity = [
    { action: 'New member registered', detail: 'Sarah Thompson joined the community', time: '2 mins ago', icon: '👤', color: 'bg-warm-100 text-warm-700' },
    { action: 'Event created', detail: '"Spring Community Fair" added for 12 Apr', time: '1 hour ago', icon: '📅', color: 'bg-warm-100 text-warm-700' },
    { action: 'News article published', detail: 'Sensory garden opening published', time: '3 hours ago', icon: '📰', color: 'bg-warm-100 text-warm-700' },
    { action: 'Donation received', detail: '£50 received via online form', time: 'Yesterday', icon: '💚', color: 'bg-warm-100 text-warm-700' },
    { action: 'Venue hire booking', detail: 'Main hall booked for 19 Apr', time: 'Yesterday', icon: '🏛️', color: 'bg-warm-100 text-warm-700' },
];

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout title="Internal Dashboard">
        <template #header>
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-warm-900 font-display">Dashboard</h1>
                    <p class="text-sm text-warm-500 mt-0.5">Welcome back, {{ $page.props.auth.user.name }}</p>
                </div>
   
            </div>
        </template>

        <!-- Quick actions -->
        <div v-if="indexLinks.length" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 mb-8">
            <a v-for="link in indexLinks" :key="link.href" :href="link.href"
               class="flex items-center gap-3 px-4 py-3 bg-white border border-warm-200 rounded-xl text-sm font-medium text-warm-700 hover:border-warm-300 hover:bg-warm-50 hover:text-warm-900 transition-colors shadow-sm">
                <span class="text-base">{{ link.icon }}</span>
                {{ link.label }}
            </a>
        </div>

        <!-- Stats grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div v-for="stat in stats" :key="stat.label"
                 class="p-5 rounded-2xl border-2 transition-shadow hover:shadow-md"
                 :class="stat.color">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl" :class="stat.iconBg">
                        {{ stat.icon }}
                    </div>
                </div>
                <p class="text-2xl font-bold font-display" :class="stat.valueColor">{{ stat.value }}</p>
                <p class="text-xs font-medium text-warm-600 mt-0.5">{{ stat.label }}</p>
                <p class="text-xs text-warm-400 mt-1">{{ stat.change }}</p>
            </div>
        </div>

        <!-- Main content grid -->
        <div class="grid lg:grid-cols-3 gap-6">

            <!-- Recent activity -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-warm-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-warm-100 flex items-center justify-between">
                    <h2 class="font-semibold text-warm-900 text-sm">Recent Activity</h2>
                    <a href="#" class="text-xs text-warm-600 hover:text-warm-900 font-medium transition-colors">View all</a>
                </div>
                <div class="divide-y divide-warm-50">
                    <div v-for="item in recentActivity" :key="item.action"
                         class="flex items-start gap-3 px-6 py-4 hover:bg-warm-50 transition-colors">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm shrink-0 mt-0.5" :class="item.color">
                            {{ item.icon }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-warm-900">{{ item.action }}</p>
                            <p class="text-xs text-warm-500 mt-0.5 truncate">{{ item.detail }}</p>
                        </div>
                        <span class="text-xs text-warm-400 shrink-0 ml-2 mt-0.5">{{ item.time }}</span>
                    </div>
                </div>
            </div>

            <!-- Right column -->
            <div class="space-y-5">

                <!-- Charity info card -->
                <div class="bg-gradient-to-br from-warm-700 to-warm-900 rounded-2xl p-5 text-white">
                    <div class="flex items-center gap-3 mb-4">
                        <img src="/media/logo.png" alt="Acme Sweets" class="h-12 w-auto brightness-0 invert opacity-90" />
                        <div>
                            <p class="font-semibold text-sm font-display">Acme Sweets</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-center">
                        <div class="bg-white/15 rounded-xl p-3">
                            <p class="text-lg font-bold font-display">1,248</p>
                            <p class="text-white/70 text-xs">Members</p>
                        </div>
                        <div class="bg-white/15 rounded-xl p-3">
                            <p class="text-lg font-bold font-display">152</p>
                            <p class="text-white/70 text-xs">Volunteers</p>
                        </div>
                    </div>
                </div>

                <!-- Upcoming events mini list -->
                <div class="bg-white rounded-2xl border border-warm-200 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-warm-100">
                        <h2 class="font-semibold text-warm-900 text-sm">Next Events</h2>
                    </div>
                    <div class="divide-y divide-warm-50">
                        <div class="flex items-center gap-3 px-5 py-3">
                            <div class="text-center shrink-0">
                                <p class="text-xs font-bold text-warm-500">APR</p>
                                <p class="text-lg font-bold text-warm-900 leading-none">12</p>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-warm-800 truncate">Spring Community Fair</p>
                                <p class="text-xs text-warm-400">10:00 – Main Hall</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 px-5 py-3">
                            <div class="text-center shrink-0">
                                <p class="text-xs font-bold text-warm-500">APR</p>
                                <p class="text-lg font-bold text-warm-900 leading-none">16</p>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-warm-800 truncate">Senior Coffee Morning</p>
                                <p class="text-xs text-warm-400">09:30 – Café</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 px-5 py-3">
                            <div class="text-center shrink-0">
                                <p class="text-xs font-bold text-warm-500">APR</p>
                                <p class="text-lg font-bold text-warm-900 leading-none">25</p>
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-warm-800 truncate">Youth Film Night</p>
                                <p class="text-xs text-warm-400">18:00 – Activity Room</p>
                            </div>
                        </div>
                    </div>
                    <div class="px-5 py-3 border-t border-warm-100">
                        <a href="#" class="text-xs font-medium text-warm-600 hover:text-warm-900 transition-colors">Manage events →</a>
                    </div>
                </div>

            </div>
        </div>

    </AuthenticatedLayout>
</template>
