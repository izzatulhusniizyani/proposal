<script setup>
import { Head, Link, useForm, usePage, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    helpRequest: Object,
});

const page = usePage();
const flash = computed(() => page.props.flash);
const user = computed(() => page.props.auth.user);

const responseForm = useForm({
    message: '',
});

function submitResponse() {
    responseForm.post(route('help-requests.responses.store', props.helpRequest.id), {
        onSuccess: () => responseForm.reset(),
        preserveScroll: true,
    });
}

function helpStatusBadge(s) {
    if (s === 'resolved') return { label: 'Resolved', class: 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 ring-gray-200 dark:ring-slate-600' };
    if (s === 'in_progress') return { label: 'In-Progress', class: 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 ring-amber-200 dark:ring-amber-800' };
    return { label: 'Open', class: 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 ring-emerald-200 dark:ring-emerald-800' };
}

function formatDate(d) {
    if (!d) return '';
    return new Date(d).toLocaleDateString('en-MY', { weekday: 'short', day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' });
}

function dismissToast() {
    router.get(route('help-requests.show', props.helpRequest.id), {}, { preserveState: true, preserveScroll: true });
}
</script>

<template>
    <AppLayout title="Help Request">
        <template #header>
            <div class="flex items-center gap-3">
                <Link :href="route('dashboard') + '#help'" class="inline-flex items-center gap-1.5 rounded-xl px-3 py-2 text-sm font-semibold text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Back to Dashboard
                </Link>
                <div>
                    <h2 class="text-xl font-extrabold text-gray-900 dark:text-white tracking-tight">Help Request</h2>
                    <p class="text-sm text-gray-500 dark:text-slate-400">View and respond to peer academic support requests.</p>
                </div>
            </div>
        </template>

        <!-- Toast Notifications -->
        <div class="fixed top-4 right-4 z-50 space-y-3 max-w-sm">
            <div v-if="flash?.success" class="rounded-2xl bg-white dark:bg-slate-800 border border-emerald-200 dark:border-emerald-800 shadow-lg px-5 py-4 flex items-start gap-3 animate-slide-in">
                <div class="size-9 rounded-full bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center shrink-0">
                    <svg class="size-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-800 dark:text-slate-200 pt-1">{{ flash.success }}</p>
                <button class="ml-auto shrink-0 text-gray-400 hover:text-gray-600 dark:hover:text-slate-300" @click="dismissToast">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div v-if="flash?.error" class="rounded-2xl bg-white dark:bg-slate-800 border border-red-200 dark:border-red-800 shadow-lg px-5 py-4 flex items-start gap-3 animate-slide-in">
                <div class="size-9 rounded-full bg-red-100 dark:bg-red-900/40 flex items-center justify-center shrink-0">
                    <svg class="size-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
                <p class="text-sm font-medium text-gray-800 dark:text-slate-200 pt-1">{{ flash.error }}</p>
                <button class="ml-auto shrink-0 text-gray-400 hover:text-gray-600 dark:hover:text-slate-300" @click="dismissToast">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="py-8">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <!-- Original Request Card -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center rounded-lg bg-brand-amber/10 dark:bg-amber-900/40 px-3 py-1.5 text-xs font-bold text-brand-amber dark:text-amber-400">{{ helpRequest.course_code }}</span>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset" :class="helpStatusBadge(helpRequest.status).class">{{ helpStatusBadge(helpRequest.status).label }}</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-slate-500">
                            <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            {{ formatDate(helpRequest.created_at) }}
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">{{ helpRequest.topic }}</h3>
                    <p class="text-gray-600 dark:text-slate-300 leading-relaxed whitespace-pre-wrap">{{ helpRequest.description }}</p>
                    <div v-if="helpRequest.image_path" class="mt-4">
                        <img :src="'/storage/' + helpRequest.image_path" :alt="helpRequest.topic" class="rounded-xl max-h-96 w-full object-contain border border-gray-100 dark:border-slate-600 bg-gray-50 dark:bg-slate-900" />
                    </div>
                    <div class="mt-4 flex items-center gap-2 text-sm text-gray-500 dark:text-slate-400">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        Posted by <strong class="font-medium text-gray-700 dark:text-slate-300">{{ helpRequest.user?.name || 'Unknown' }}</strong>
                    </div>
                </div>

                <!-- Responses Timeline -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="size-9 rounded-xl bg-brand-teal/10 dark:bg-teal-900/40 flex items-center justify-center">
                            <svg class="size-5 text-brand-teal dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                            </svg>
                        </span>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Peer Responses ({{ helpRequest.response_count }})</h3>
                    </div>

                    <!-- Empty state -->
                    <div v-if="helpRequest.responses.length === 0" class="text-center py-12">
                        <svg class="mx-auto size-10 text-gray-300 dark:text-slate-600 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                        </svg>
                        <p class="font-semibold text-gray-500 dark:text-slate-400">No responses yet</p>
                        <p class="text-sm text-gray-400 dark:text-slate-500 mt-1">Be the first to help a peer!</p>
                    </div>

                    <!-- Response Timeline -->
                    <div v-else class="space-y-4">
                        <div v-for="(resp, idx) in helpRequest.responses" :key="resp.id" class="relative pl-8 pb-4" :class="{ 'border-l-2 border-gray-100 dark:border-slate-700': idx < helpRequest.responses.length - 1 }">
                            <div class="absolute -left-2.5 top-0 size-5 rounded-full border-2 border-white dark:border-slate-800 flex items-center justify-center" :class="resp.user_id === user.id ? 'bg-brand-teal dark:bg-teal-600' : 'bg-gray-200 dark:bg-slate-600'">
                                <span class="text-[10px] font-bold text-white">{{ resp.user?.name?.charAt(0) || '?' }}</span>
                            </div>
                            <div class="bg-gray-50 dark:bg-slate-700/50 rounded-xl p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-bold text-gray-800 dark:text-slate-200">{{ resp.user?.name || 'Anonymous' }}</span>
                                        <span v-if="resp.user_id === helpRequest.user_id" class="text-[10px] font-bold uppercase bg-brand-amber/10 dark:bg-amber-900/40 text-brand-amber dark:text-amber-400 px-1.5 py-0.5 rounded">Author</span>
                                    </div>
                                    <span class="text-xs text-gray-400 dark:text-slate-500">{{ formatDate(resp.created_at) }}</span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-slate-300 whitespace-pre-wrap">{{ resp.message }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reply Form -->
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="size-9 rounded-xl bg-brand-indigo/10 dark:bg-indigo-900/40 flex items-center justify-center">
                            <svg class="size-5 text-brand-indigo dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2Z" />
                            </svg>
                        </span>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-white">Submit a Reply</h3>
                    </div>
                    <form @submit.prevent="submitResponse">
                        <textarea v-model="responseForm.message" class="block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white shadow-sm focus:border-brand-indigo focus:ring-brand-indigo/20 text-sm" placeholder="Write your answer or solution here..." rows="4" required></textarea>
                        <InputError class="mt-2" :message="responseForm.errors.message" />
                        <div class="mt-4 flex justify-end">
                            <button
                                class="inline-flex items-center gap-2 rounded-xl bg-brand-indigo px-6 py-2.5 text-sm font-bold text-white shadow-md shadow-brand-indigo/20 hover:bg-brand-indigo/90 transition-all duration-300 disabled:opacity-50"
                                :disabled="responseForm.processing"
                            >
                                <svg v-if="responseForm.processing" class="animate-spin size-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                                </svg>
                                <svg v-else class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                </svg>
                                Submit Reply
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </AppLayout>
</template>
