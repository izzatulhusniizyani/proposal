@extends('layouts.guest')

@section('title', 'Log in')

@section('auth-content')
<div class="w-full sm:max-w-md px-8 py-7 bg-white dark:bg-slate-800 shadow-xl shadow-gray-200/50 dark:shadow-slate-950/50 sm:rounded-2xl border border-gray-100 dark:border-slate-700">
    @if (session('status'))
    <div class="mb-4 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 px-4 py-2.5 text-sm font-medium text-emerald-700 dark:text-emerald-300">
        {{ session('status') }}
    </div>
    @endif

    @if ($errors->has('email') && !old('email'))
    <div class="mb-4 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 px-4 py-2.5 text-sm font-medium text-red-700 dark:text-red-300">
        These credentials do not match our records.
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Student ID / Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring focus:ring-brand-teal/20 transition placeholder:text-gray-400 dark:placeholder-slate-500"
                placeholder="you@student.edu"
                required
                autofocus
                autocomplete="username"
            />
            @error('email')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-5">
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Password</label>
            <div class="relative mt-1.5" x-data="{ show: false }">
                <input
                    id="password"
                    :type="show ? 'text' : 'password'"
                    name="password"
                    class="block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white pr-11 focus:border-brand-teal focus:ring focus:ring-brand-teal/20 transition placeholder:text-gray-400 dark:placeholder-slate-500"
                    placeholder="Enter your password"
                    required
                    autocomplete="current-password"
                />
                <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-gray-600 dark:hover:text-slate-300 transition" @click="show = !show">
                    <svg x-show="!show" class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                    <svg x-show="show" class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>
            </div>
            @error('password')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between mt-5">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="rounded border-gray-300 dark:border-slate-600 text-brand-teal focus:ring-brand-teal/30 dark:bg-slate-700" />
                <span class="ms-2 text-sm text-gray-600 dark:text-slate-300">Remember me</span>
            </label>

            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-sm text-brand-teal dark:text-teal-400 hover:text-brand-teal/80 font-medium underline underline-offset-2 transition-colors">
                Forgot password?
            </a>
            @endif
        </div>

        <div class="mt-6">
            <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl bg-brand-teal px-4 py-3 text-sm font-bold text-white shadow-md shadow-brand-teal/20 hover:bg-brand-teal/90 focus:outline-none focus:ring-2 focus:ring-brand-teal/50 transition-all duration-300">
                <svg class="size-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                </svg>
                Log in
            </button>
        </div>
    </form>

    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-200 dark:border-slate-600" />
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="bg-white dark:bg-slate-800 px-4 text-gray-500 dark:text-slate-400">or continue with</span>
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
        Don't have an account?
        <a href="{{ route('register') }}" class="text-brand-indigo dark:text-indigo-400 hover:text-brand-indigo/80 font-semibold underline underline-offset-2 transition-colors">Sign up</a>
    </p>
</div>
@endsection
