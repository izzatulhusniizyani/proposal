@extends('layouts.guest')

@section('title', 'Register')

@section('auth-content')
<div class="w-full sm:max-w-md px-8 py-7 bg-white dark:bg-slate-800 shadow-xl shadow-gray-200/50 dark:shadow-slate-950/50 sm:rounded-2xl border border-gray-100 dark:border-slate-700">
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Full Name</label>
            <input
                id="name"
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring focus:ring-brand-teal/20 transition placeholder:text-gray-400 dark:placeholder-slate-500"
                placeholder="e.g. Alex Johnson"
                required
                autofocus
                autocomplete="name"
            />
            @error('name')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="matric_number" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Matric Number</label>
            <input
                id="matric_number"
                type="text"
                name="matric_number"
                value="{{ old('matric_number') }}"
                class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring focus:ring-brand-teal/20 transition placeholder:text-gray-400 dark:placeholder-slate-500"
                placeholder="e.g. 2410123"
                required
                autocomplete="off"
            />
            @error('matric_number')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Student Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring focus:ring-brand-teal/20 transition placeholder:text-gray-400 dark:placeholder-slate-500"
                placeholder="you@student.edu"
                required
                autocomplete="username"
            />
            @error('email')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring focus:ring-brand-teal/20 transition placeholder:text-gray-400 dark:placeholder-slate-500"
                placeholder="Min. 8 characters"
                required
                autocomplete="new-password"
            />
            @error('password')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Confirm Password</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring focus:ring-brand-teal/20 transition placeholder:text-gray-400 dark:placeholder-slate-500"
                placeholder="Re-enter your password"
                required
                autocomplete="new-password"
            />
            @error('password_confirmation')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
        <div class="mt-2">
            <label class="flex items-center">
                <input type="checkbox" name="terms" id="terms" class="rounded border-gray-300 dark:border-slate-600 text-brand-teal focus:ring-brand-teal/30 dark:bg-slate-700" required />
                <span class="ms-2 text-sm text-gray-600 dark:text-slate-300">
                    I agree to the <a href="{{ route('terms.show') }}" target="_blank" class="underline text-brand-teal dark:text-teal-400 hover:text-brand-teal/80">Terms of Service</a> and <a href="{{ route('policy.show') }}" target="_blank" class="underline text-brand-teal dark:text-teal-400 hover:text-brand-teal/80">Privacy Policy</a>
                </span>
            </label>
            @error('terms')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        @endif

        <div class="mt-6">
            <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl bg-brand-teal px-4 py-3 text-sm font-bold text-white shadow-md shadow-brand-teal/20 hover:bg-brand-teal/90 focus:outline-none focus:ring-2 focus:ring-brand-teal/50 transition-all duration-300">
                <svg class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
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
        <a href="{{ route('login') }}" class="text-brand-indigo dark:text-indigo-400 hover:text-brand-indigo/80 font-semibold underline underline-offset-2 transition-colors">Log in</a>
    </p>
</div>
@endsection
