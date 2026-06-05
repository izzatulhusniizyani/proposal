<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const form = useForm({
    name: '',
    matric_number: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register" />

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-surface dark:bg-slate-900">
        <div class="mb-6 text-center">
            <div class="mx-auto flex items-center justify-center">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" class="drop-shadow-lg">
                    <rect width="64" height="64" rx="18" fill="#0D9488" />
                    <path d="M22 42V28l10-5 10 5v14l-10 5-10-5z" fill="white" />
                    <path d="M22 28l10 5 10-5" fill="#0D9488" stroke="white" stroke-width="2" />
                    <path d="M32 33v8" stroke="white" stroke-width="2.2" stroke-linecap="round" />
                    <circle cx="32" cy="24" r="3" fill="white" />
                    <path d="M46 28a4 4 0 0 1 4 4v3l-3 1.5-3-1.5v-3a4 4 0 0 1 1-4z" fill="white" opacity="0.8" />
                    <path d="M18 28a4 4 0 0 0-4 4v3l3 1.5 3-1.5v-3a4 4 0 0 0-1-4z" fill="white" opacity="0.8" />
                    <path d="M28 14l4-2 4 2" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <h1 class="mt-4 text-3xl font-extrabold text-brand-teal dark:text-teal-400 tracking-tight">StudyBuddy</h1>
            <p class="mt-1 text-sm font-semibold text-brand-indigo dark:text-indigo-400">Create your account</p>
        </div>

        <div class="w-full sm:max-w-md px-8 py-7 bg-white dark:bg-slate-800 shadow-xl shadow-gray-200/50 dark:shadow-slate-950/50 sm:rounded-2xl border border-gray-100 dark:border-slate-700">
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <InputLabel for="name" value="Full Name" class="dark:text-slate-300" />
                    <TextInput
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring focus:ring-brand-teal/20 transition"
                        placeholder="e.g. Alex Johnson"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div>
                    <InputLabel for="matric_number" value="Matric Number" class="dark:text-slate-300" />
                    <TextInput
                        id="matric_number"
                        v-model="form.matric_number"
                        type="text"
                        class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring focus:ring-brand-teal/20 transition"
                        placeholder="e.g. 2410123"
                        required
                        autocomplete="off"
                    />
                    <InputError class="mt-2" :message="form.errors.matric_number" />
                </div>

                <div>
                    <InputLabel for="email" value="Student Email" class="dark:text-slate-300" />
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring focus:ring-brand-teal/20 transition"
                        placeholder="you@student.edu"
                        required
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div>
                    <InputLabel for="password" value="Password" class="dark:text-slate-300" />
                    <TextInput
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring focus:ring-brand-teal/20 transition"
                        placeholder="Min. 8 characters"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div>
                    <InputLabel for="password_confirmation" value="Confirm Password" class="dark:text-slate-300" />
                    <TextInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring focus:ring-brand-teal/20 transition"
                        placeholder="Re-enter your password"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-2">
                    <InputLabel for="terms">
                        <div class="flex items-center">
                            <Checkbox id="terms" v-model:checked="form.terms" name="terms" required class="dark:border-slate-600" />
                            <div class="ms-2 text-sm text-gray-600 dark:text-slate-300">
                                I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-brand-teal dark:text-teal-400 hover:text-brand-teal/80 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-teal">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-brand-teal dark:text-teal-400 hover:text-brand-teal/80 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-teal">Privacy Policy</a>
                            </div>
                        </div>
                        <InputError class="mt-2" :message="form.errors.terms" />
                    </InputLabel>
                </div>

                <div class="mt-6">
                    <button
                        class="w-full inline-flex items-center justify-center rounded-xl bg-brand-teal px-4 py-3 text-sm font-bold text-white shadow-md shadow-brand-teal/20 hover:bg-brand-teal/90 focus:outline-none focus:ring-2 focus:ring-brand-teal/50 transition-all duration-300 disabled:opacity-50"
                        :disabled="form.processing"
                    >
                        <svg v-if="form.processing" class="animate-spin -ml-1 mr-2 size-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                        </svg>
                        <svg v-else class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Create Account
                    </button>
                </div>
            </form>

            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200 dark:border-slate-600" />
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="bg-white dark:bg-slate-800 px-4 text-gray-500 dark:text-slate-400">or sign up with</span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <a href="#" class="inline-flex items-center justify-center gap-2.5 rounded-xl border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-slate-600 transition-all duration-200 shadow-sm">
                    <svg class="size-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 0 1-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4" />
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
                    </svg>
                    Google
                </a>
                <a href="#" class="inline-flex items-center justify-center gap-2.5 rounded-xl border border-gray-200 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5 text-sm font-semibold text-gray-700 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-slate-600 transition-all duration-200 shadow-sm">
                    <svg class="size-5" viewBox="0 0 23 23" fill="currentColor">
                        <rect width="23" height="23" rx="3" fill="#00A4EF" />
                        <path d="M5 5h6v6H5V5zm7 0h6v6h-6V5zm-7 7h6v6H5v-6zm7 0h6v6h-6v-6z" fill="white" />
                    </svg>
                    Microsoft
                </a>
            </div>

            <p class="mt-6 text-center text-sm text-gray-500 dark:text-slate-400">
                Already registered?
                <Link :href="route('login')" class="text-brand-indigo dark:text-indigo-400 hover:text-brand-indigo/80 font-semibold underline underline-offset-2 transition-colors">Log in</Link>
            </p>
        </div>

        <p class="mt-6 text-xs text-gray-400 dark:text-slate-500">BIIT 2305 — Web Application Development &middot; Section 1</p>
    </div>
</template>
