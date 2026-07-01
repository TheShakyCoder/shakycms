<script setup>
import { useForm, Link, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout/Index.vue';

const form = useForm({ author: '', role: '', headline: '', quote: '', rating: null, homepage: false, featured: false, order: 0 });

function submit() {
    form.post('/internal/testimonials');
}
</script>

<template>
    <Head title="Create Testimonial" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-3">
                <Link href="/internal/testimonials"
                      class="p-1.5 rounded-lg text-warm-400 hover:text-warm-700 hover:bg-warm-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </Link>
                <div>
                    <h1 class="text-xl font-semibold text-warm-900 font-display">Create Testimonial</h1>
                    <p class="text-sm text-warm-500 mt-0.5">Add a customer testimonial</p>
                </div>
            </div>
        </template>

        <div class="max-w-lg">
            <div class="bg-white border border-warm-200 rounded-2xl p-7 shadow-sm">
                <form @submit.prevent="submit" class="space-y-5">
                    <div>
                        <label for="author" class="block text-xs font-semibold text-warm-700 mb-1.5">Author</label>
                        <input v-model="form.author" id="author" type="text" required placeholder="e.g. Jane Doe"
                               class="w-full px-4 py-2.5 text-sm border rounded-xl bg-white text-warm-900
                                      focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition placeholder-warm-300"
                               :class="form.errors.author ? 'border-rose-300' : 'border-warm-200'" />
                        <p v-if="form.errors.author" class="mt-1.5 text-xs text-rose-600">{{ form.errors.author }}</p>
                    </div>

                    <div>
                        <label for="role" class="block text-xs font-semibold text-warm-700 mb-1.5">Role <span class="font-normal text-warm-400">(optional)</span></label>
                        <input v-model="form.role" id="role" type="text" placeholder="e.g. Regular customer"
                               class="w-full px-4 py-2.5 text-sm border rounded-xl bg-white text-warm-900
                                      focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition placeholder-warm-300"
                               :class="form.errors.role ? 'border-rose-300' : 'border-warm-200'" />
                        <p v-if="form.errors.role" class="mt-1.5 text-xs text-rose-600">{{ form.errors.role }}</p>
                    </div>

                    <div>
                        <label for="headline" class="block text-xs font-semibold text-warm-700 mb-1.5">Headline</label>
                        <input v-model="form.headline" id="headline" type="text" required placeholder="e.g. Great!"
                               class="w-full px-4 py-2.5 text-sm border rounded-xl bg-white text-warm-900
                                      focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition placeholder-warm-300"
                               :class="form.errors.headline ? 'border-rose-300' : 'border-warm-200'" />
                        <p v-if="form.errors.headline" class="mt-1.5 text-xs text-rose-600">{{ form.errors.headline }}</p>
                    </div>

                    <div>
                        <label for="quote" class="block text-xs font-semibold text-warm-700 mb-1.5">Quote</label>
                        <textarea v-model="form.quote" id="quote" rows="4" required placeholder="What did they say?"
                                  class="w-full px-4 py-2.5 text-sm border rounded-xl bg-white text-warm-900
                                         focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition placeholder-warm-300"
                                  :class="form.errors.quote ? 'border-rose-300' : 'border-warm-200'"></textarea>
                        <p v-if="form.errors.quote" class="mt-1.5 text-xs text-rose-600">{{ form.errors.quote }}</p>
                    </div>

                    <div class="flex gap-4">
                        <div>
                            <label for="rating" class="block text-xs font-semibold text-warm-700 mb-1.5">Rating <span class="font-normal text-warm-400">(optional)</span></label>
                            <select v-model="form.rating" id="rating"
                                    class="w-32 px-4 py-2.5 text-sm border rounded-xl bg-white text-warm-900
                                           focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition"
                                    :class="form.errors.rating ? 'border-rose-300' : 'border-warm-200'">
                                <option :value="null">—</option>
                                <option v-for="n in 5" :key="n" :value="n">{{ n }} ★</option>
                            </select>
                            <p v-if="form.errors.rating" class="mt-1.5 text-xs text-rose-600">{{ form.errors.rating }}</p>
                        </div>

                        <div>
                            <label for="order" class="block text-xs font-semibold text-warm-700 mb-1.5">Order</label>
                            <input v-model="form.order" id="order" type="number" min="0"
                                   class="w-28 px-4 py-2.5 text-sm border rounded-xl bg-white text-warm-900
                                          focus:outline-none focus:ring-2 focus:ring-brand-400 focus:border-transparent transition"
                                   :class="form.errors.order ? 'border-rose-300' : 'border-warm-200'" />
                            <p v-if="form.errors.order" class="mt-1.5 text-xs text-rose-600">{{ form.errors.order }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 pt-1">
                        <label class="inline-flex items-center gap-2 text-sm text-warm-700">
                            <input v-model="form.homepage" type="checkbox"
                                   class="rounded border-warm-300 text-brand-600 focus:ring-brand-400" />
                            Show on homepage
                        </label>
                        <label class="inline-flex items-center gap-2 text-sm text-warm-700">
                            <input v-model="form.featured" type="checkbox"
                                   class="rounded border-warm-300 text-brand-600 focus:ring-brand-400" />
                            Featured
                        </label>
                    </div>

                    <div class="flex items-center gap-3 pt-2">
                        <button type="submit" :disabled="form.processing"
                                class="px-6 py-2.5 bg-brand-600 text-white text-sm font-semibold rounded-xl hover:bg-brand-700 transition-colors shadow-sm disabled:opacity-50">
                            Create testimonial
                        </button>
                        <Link href="/internal/testimonials" class="text-sm text-warm-500 hover:text-warm-700">Cancel</Link>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
