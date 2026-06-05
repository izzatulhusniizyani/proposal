@extends('app')

@section('body')
<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-surface dark:bg-slate-900">
    <div class="mb-6 text-center">
        <div class="mx-auto flex items-center justify-center">
            <svg width="72" height="72" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg" class="drop-shadow-lg">
                <defs>
                    <linearGradient id="logoGrad" x1="0" y1="0" x2="72" y2="72">
                        <stop offset="0%" stop-color="#0D9488"/>
                        <stop offset="100%" stop-color="#4F46E5"/>
                    </linearGradient>
                </defs>
                <rect width="72" height="72" rx="20" fill="url(#logoGrad)"/>
                <path d="M24 44V30l12-6 12 6v14l-12 6-12-6z" fill="white" opacity="0.95"/>
                <path d="M24 30l12 6 12-6" fill="#0D9488" stroke="white" stroke-width="2"/>
                <path d="M36 36v9" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                <circle cx="36" cy="26" r="3.5" fill="white"/>
                <circle cx="16" cy="42" r="6" fill="#4F46E5" opacity="0.25" stroke="white" stroke-width="1.5"/>
                <circle cx="56" cy="42" r="6" fill="#D97706" opacity="0.25" stroke="white" stroke-width="1.5"/>
                <path d="M14 42a2 2 0 014 0" stroke="white" stroke-width="1.2" opacity="0.6"/>
                <path d="M54 42a2 2 0 014 0" stroke="white" stroke-width="1.2" opacity="0.6"/>
            </svg>
        </div>
        <h1 class="mt-5 text-3xl font-extrabold text-brand-teal dark:text-teal-400 tracking-tight">StudyBuddy</h1>
        <p class="mt-1 text-sm font-semibold text-brand-indigo dark:text-indigo-400">Connect. Collaborate. Succeed Together.</p>
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400 max-w-xs mx-auto">Your campus hub for peer-to-peer academic support and collaboration.</p>
    </div>

    @yield('auth-content')

    <p class="mt-6 text-xs text-gray-400 dark:text-slate-500">BIIT 2305 &mdash; Web Application Development &middot; Section 1</p>
</div>
@endsection
