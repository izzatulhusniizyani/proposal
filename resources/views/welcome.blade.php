<x-app>
    <div class="min-h-screen flex flex-col bg-surface dark:bg-slate-900">
        <nav class="bg-white dark:bg-slate-800 border-b border-gray-200 dark:border-slate-700 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center gap-3">
                        <svg width="36" height="36" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="welcomeLogo" x1="0" y1="0" x2="72" y2="72">
                                    <stop offset="0%" stop-color="#0D9488"/>
                                    <stop offset="100%" stop-color="#4F46E5"/>
                                </linearGradient>
                            </defs>
                            <rect width="72" height="72" rx="20" fill="url(#welcomeLogo)"/>
                            <path d="M24 44V30l12-6 12 6v14l-12 6-12-6z" fill="white" opacity="0.95"/>
                            <path d="M24 30l12 6 12-6" fill="#0D9488" stroke="white" stroke-width="2"/>
                            <path d="M36 36v9" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                            <circle cx="36" cy="26" r="3.5" fill="white"/>
                        </svg>
                        <span class="text-xl font-extrabold text-brand-teal dark:text-teal-400 tracking-tight">StudyBuddy</span>
                    </div>
                    <div class="flex items-center gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="rounded-xl bg-brand-teal px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-brand-teal/20 hover:bg-brand-teal/90 transition-all duration-300">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-xl px-5 py-2.5 text-sm font-semibold text-gray-600 dark:text-slate-300 hover:text-gray-800 dark:hover:text-white transition">Log in</a>
                            <a href="{{ route('register') }}" class="rounded-xl bg-brand-teal px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-brand-teal/20 hover:bg-brand-teal/90 transition-all duration-300">Sign up</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
                <div class="text-center max-w-3xl mx-auto">
                    <div class="flex justify-center mb-8">
                        <svg width="96" height="96" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg" class="drop-shadow-xl">
                            <defs>
                                <linearGradient id="heroLogo" x1="0" y1="0" x2="72" y2="72">
                                    <stop offset="0%" stop-color="#0D9488"/>
                                    <stop offset="100%" stop-color="#4F46E5"/>
                                </linearGradient>
                            </defs>
                            <rect width="72" height="72" rx="20" fill="url(#heroLogo)"/>
                            <path d="M24 44V30l12-6 12 6v14l-12 6-12-6z" fill="white" opacity="0.95"/>
                            <path d="M24 30l12 6 12-6" fill="#0D9488" stroke="white" stroke-width="2"/>
                            <path d="M36 36v9" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
                            <circle cx="36" cy="26" r="3.5" fill="white"/>
                            <circle cx="16" cy="42" r="7" fill="#4F46E5" opacity="0.3" stroke="white" stroke-width="1.5"/>
                            <circle cx="56" cy="42" r="7" fill="#D97706" opacity="0.3" stroke="white" stroke-width="1.5"/>
                            <path d="M14 42a2 2 0 014 0" stroke="white" stroke-width="1.2" opacity="0.6"/>
                            <path d="M54 42a2 2 0 014 0" stroke="white" stroke-width="1.2" opacity="0.6"/>
                        </svg>
                    </div>
                    <h1 class="text-4xl sm:text-6xl font-extrabold text-gray-900 dark:text-white tracking-tight leading-tight">
                        Connect. <span class="text-brand-teal">Collaborate.</span><br>
                        <span class="text-brand-indigo">Succeed Together.</span>
                    </h1>
                    <p class="mt-6 text-lg sm:text-xl text-gray-500 dark:text-slate-400 max-w-xl mx-auto leading-relaxed">
                        Your campus hub for peer-to-peer academic study groups, help requests, and collaborative learning. Find your study crew today.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="rounded-xl bg-brand-teal px-8 py-3.5 text-base font-bold text-white shadow-lg shadow-brand-teal/30 hover:bg-brand-teal/90 hover:shadow-xl transition-all duration-300">Go to Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="rounded-xl bg-brand-teal px-8 py-3.5 text-base font-bold text-white shadow-lg shadow-brand-teal/30 hover:bg-brand-teal/90 hover:shadow-xl transition-all duration-300">Get Started Free</a>
                            <a href="{{ route('login') }}" class="rounded-xl border-2 border-gray-200 dark:border-slate-600 px-8 py-3.5 text-base font-bold text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-800 transition-all duration-300">Log in</a>
                        @endauth
                    </div>
                </div>

                <div class="mt-24 grid gap-8 md:grid-cols-3">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 text-center hover:shadow-md transition-all duration-300">
                        <div class="size-14 rounded-xl bg-brand-teal/10 dark:bg-teal-900/30 flex items-center justify-center mx-auto mb-4">
                            <svg class="size-7 text-brand-teal dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" /></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Study Groups</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-slate-400">Create or join peer study sessions for any course. Collaborate in real-time with group chat and shared materials.</p>
                    </div>
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 text-center hover:shadow-md transition-all duration-300">
                        <div class="size-14 rounded-xl bg-brand-amber/10 dark:bg-amber-900/30 flex items-center justify-center mx-auto mb-4">
                            <svg class="size-7 text-brand-amber dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" /></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Peer Help</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-slate-400">Stuck on a problem? Post a help request with screenshots and get answers from your fellow students.</p>
                    </div>
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 text-center hover:shadow-md transition-all duration-300">
                        <div class="size-14 rounded-xl bg-brand-indigo/10 dark:bg-indigo-900/30 flex items-center justify-center mx-auto mb-4">
                            <svg class="size-7 text-brand-indigo dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Smart Matching</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-slate-400">AI-powered recommendations match you with study groups and peers based on your courses and interests.</p>
                    </div>
                </div>
            </div>
        </main>

        <footer class="border-t border-gray-200 dark:border-slate-700 bg-white dark:bg-slate-800 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-400 dark:text-slate-500">
                BIIT 2305 &mdash; Web Application Development &middot; Section 1
            </div>
        </footer>
    </div>
</x-app>
