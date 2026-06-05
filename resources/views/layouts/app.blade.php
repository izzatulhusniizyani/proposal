@extends('app')

@section('body')
<div x-data="darkMode()" class="min-h-screen bg-surface dark:bg-slate-900">
    <nav class="bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <svg width="40" height="40" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="logoSmall" x1="0" y1="0" x2="72" y2="72">
                                    <stop offset="0%" stop-color="#0D9488"/>
                                    <stop offset="100%" stop-color="#4F46E5"/>
                                </linearGradient>
                            </defs>
                            <rect width="72" height="72" rx="20" fill="url(#logoSmall)"/>
                            <path d="M24 44V30l12-6 12 6v14l-12 6-12-6z" fill="white" opacity="0.95"/>
                            <path d="M24 30l12 6 12-6" fill="#0D9488" stroke="white" stroke-width="2"/>
                            <path d="M36 36v9" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                            <circle cx="36" cy="26" r="3.5" fill="white"/>
                            <circle cx="16" cy="42" r="6" fill="#4F46E5" opacity="0.25" stroke="white" stroke-width="1.5"/>
                            <circle cx="56" cy="42" r="6" fill="#D97706" opacity="0.25" stroke="white" stroke-width="1.5"/>
                        </svg>
                        <span class="text-xl font-extrabold text-brand-teal dark:text-teal-400 tracking-tight hidden sm:block">StudyBuddy</span>
                    </a>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                    <button
                        class="relative inline-flex items-center justify-center w-10 h-10 rounded-xl bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-slate-300 hover:bg-gray-200 dark:hover:bg-slate-600 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-brand-teal/40"
                        @click="toggle"
                        :title="dark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
                    >
                        <svg x-show="!dark" class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                        <svg x-show="dark" class="size-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                        </svg>
                    </button>

                    <div class="ms-3 relative" x-data="{ open: false }">
                        <button
                            class="flex items-center gap-2 px-4 py-2 border border-gray-200 dark:border-slate-600 text-sm leading-4 font-medium rounded-xl text-gray-600 dark:text-slate-300 bg-white dark:bg-slate-700 hover:bg-gray-50 dark:hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-brand-teal/30 transition"
                            @click="open = !open"
                            @click.away="open = false"
                        >
                            <span class="size-7 rounded-full bg-brand-teal/10 dark:bg-teal-900/40 flex items-center justify-center text-brand-teal dark:text-teal-400 font-bold text-xs">{{ auth()->user()->name[0] }}</span>
                            {{ auth()->user()->name }}
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div
                            x-show="open"
                            class="absolute right-0 mt-2 w-48 rounded-xl bg-white dark:bg-slate-800 shadow-lg ring-1 ring-gray-200 dark:ring-slate-700 border border-gray-100 dark:border-slate-700 py-1 z-50"
                            x-cloak
                        >
                            <div class="px-4 py-2 text-xs text-gray-400 uppercase tracking-wider font-semibold">Manage Account</div>
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition">{{ __('Profile') }}</a>
                            <div class="border-t border-gray-200 dark:border-slate-700 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-50 dark:hover:bg-slate-700 transition">Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:hidden">
                    <button
                        class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 dark:text-slate-300 hover:text-gray-500 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-slate-700 transition"
                        @click="toggle"
                    >
                        <svg x-show="!dark" class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                        <svg x-show="dark" class="size-5 text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                        </svg>
                    </button>
                    <div x-data="{ mobileOpen: false }" class="relative">
                        <button class="inline-flex items-center justify-center p-2 rounded-xl text-gray-400 dark:text-slate-300 hover:text-gray-500 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-slate-700 transition" @click="mobileOpen = !mobileOpen">
                            <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <div x-show="mobileOpen" @click.away="mobileOpen = false" class="absolute right-0 mt-2 w-56 rounded-xl bg-white dark:bg-slate-800 shadow-lg ring-1 ring-gray-200 dark:ring-slate-700 border border-gray-100 dark:border-slate-700 py-2 z-50" x-cloak>
                            <div class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-slate-300">{{ auth()->user()->name }}</div>
                            <div class="px-4 py-1 text-xs text-gray-400">{{ auth()->user()->email }}</div>
                            <div class="border-t border-gray-200 dark:border-slate-700 my-2"></div>
                            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition">Profile</a>
                            <div class="border-t border-gray-200 dark:border-slate-700 my-2"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-50 dark:hover:bg-slate-700 transition">Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    @if (session('success') || session('error'))
    <div class="fixed top-4 right-4 z-50 max-w-sm" x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-cloak>
        @if (session('success'))
        <div class="rounded-2xl bg-white dark:bg-slate-800 border border-emerald-200 dark:border-emerald-800 shadow-lg px-5 py-4 flex items-start gap-3 animate-slide-in">
            <div class="size-9 rounded-full bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center shrink-0">
                <svg class="size-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
            </div>
            <p class="text-sm font-medium text-gray-800 dark:text-slate-200 pt-1">{{ session('success') }}</p>
            <button class="ml-auto shrink-0 text-gray-400 hover:text-gray-600 dark:hover:text-slate-300" @click="show = false">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>
        @endif
        @if (session('error'))
        <div class="rounded-2xl bg-white dark:bg-slate-800 border border-red-200 dark:border-red-800 shadow-lg px-5 py-4 flex items-start gap-3 mt-3">
            <div class="size-9 rounded-full bg-red-100 dark:bg-red-900/40 flex items-center justify-center shrink-0">
                <svg class="size-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
            </div>
            <p class="text-sm font-medium text-gray-800 dark:text-slate-200 pt-1">{{ session('error') }}</p>
            <button class="ml-auto shrink-0 text-gray-400 hover:text-gray-600 dark:hover:text-slate-300" @click="show = false">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
            </button>
        </div>
        @endif
    </div>
    @endif

    @if (View::hasSection('header'))
    <header class="bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 shadow-sm">
        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
            @yield('header')
        </div>
    </header>
    @endif

    <main>
        @yield('content')
    </main>
</div>
@endsection
