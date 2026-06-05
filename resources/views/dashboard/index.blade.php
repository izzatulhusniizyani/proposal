@extends('layouts.app')

@section('header')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
    <div>
        <h2 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight">Dashboard</h2>
        <p class="text-sm text-gray-500 dark:text-slate-400 mt-0.5">Welcome back, <span class="font-semibold text-brand-teal dark:text-teal-400">{{ auth()->user()->name }}</span>!</p>
    </div>
    <div class="flex items-center gap-3">
        <button class="inline-flex items-center gap-2 rounded-xl bg-brand-amber px-4 py-2.5 text-sm font-bold text-white shadow-md shadow-brand-amber/20 hover:bg-brand-amber/90 hover:shadow-lg transition-all duration-300" @click="window.dispatchEvent(new CustomEvent('open-help-modal'))">
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Post a New Help Request
        </button>
        <div class="flex items-center bg-gray-100 dark:bg-slate-700 rounded-full p-1 shadow-inner">
            <button class="px-4 py-2 rounded-full text-sm font-bold transition-all duration-300 flex items-center gap-2" :class="currentTab === 'learner' ? 'bg-white dark:bg-slate-600 text-brand-teal dark:text-teal-400 shadow-md ring-1 ring-brand-teal/20' : 'text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200'" @click="currentTab = 'learner'">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342" /></svg>
                Learner
            </button>
            <button class="px-4 py-2 rounded-full text-sm font-bold transition-all duration-300 flex items-center gap-2" :class="currentTab === 'host' ? 'bg-white dark:bg-slate-600 text-brand-teal dark:text-teal-400 shadow-md ring-1 ring-brand-teal/20' : 'text-gray-500 dark:text-slate-400 hover:text-gray-700 dark:hover:text-slate-200'" @click="currentTab = 'host'">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
                Host
            </button>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="py-4 space-y-6" x-data="{ showGroupModal: {{ old('location') ? 'true' : 'false' }}, showHelpModal: {{ old('description') ? 'true' : 'false' }}, showAttendance: false, attendanceSession: null }" x-on:open-help-modal.window="showHelpModal = true">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- HERO STATS -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-4 transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-lg bg-brand-teal/10 dark:bg-teal-900/30 flex items-center justify-center">
                        <svg class="size-5 text-brand-teal dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" /></svg>
                    </div>
                    <div><p class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $stats['totalActiveGroups'] }}</p><p class="text-[10px] font-medium text-gray-500 dark:text-slate-400">Active Groups</p></div>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-4 transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-lg bg-brand-indigo/10 dark:bg-indigo-900/30 flex items-center justify-center">
                        <svg class="size-5 text-brand-indigo dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" /></svg>
                    </div>
                    <div><p class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $stats['totalJoinedSessions'] }}</p><p class="text-[10px] font-medium text-gray-500 dark:text-slate-400">Joined Sessions</p></div>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-4 transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-lg bg-brand-amber/10 dark:bg-amber-900/30 flex items-center justify-center">
                        <svg class="size-5 text-brand-amber dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
                    </div>
                    <div><p class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $stats['openHelpRequests'] }}</p><p class="text-[10px] font-medium text-gray-500 dark:text-slate-400">Open Help Requests</p></div>
                </div>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-4 transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-lg bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center">
                        <svg class="size-5 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342" /></svg>
                    </div>
                    <div><p class="text-xl font-extrabold text-gray-900 dark:text-white">{{ $stats['trackedCourses'] }}</p><p class="text-[10px] font-medium text-gray-500 dark:text-slate-400">Tracked Courses</p></div>
                </div>
            </div>
        </div>

        <!-- ==================== LEARNER VIEW ==================== -->
        <div x-show="currentTab === 'learner'" x-cloak x-data="{ search: '' }">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">Study Groups</h3>
                <div class="relative max-w-sm w-full">
                    <svg class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 size-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                    <input x-model="search" type="text" placeholder="Filter by Course Code..." class="block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white bg-white dark:placeholder-slate-400 pl-10 pr-4 py-2.5 text-sm shadow-sm focus:border-brand-teal focus:ring focus:ring-brand-teal/20 transition" />
                </div>
            </div>

            <!-- Study Group Cards -->
            @if (count($studyGroups) === 0)
            <div class="text-center py-16 bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700">
                <svg class="mx-auto size-12 text-gray-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                <p class="mt-4 text-gray-500 dark:text-slate-400 font-medium">No study groups found</p>
                <p class="text-sm text-gray-400 dark:text-slate-500">Try a different course code.</p>
            </div>
            @else
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($studyGroups as $s)
                @php
                    $existingRating = $myRatings->firstWhere('study_group_id', $s->id);
                    $hasJoined = in_array($s->id, $joinedGroupIds);
                    $isCompletedForUser = $s->status === 'completed' && $hasJoined;
                @endphp
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 hover:shadow-lg hover:border-brand-teal/20 dark:hover:border-teal-700 transition-all duration-300 overflow-hidden flex flex-col" x-show="!search || '{{ $s->course_code }}'.toLowerCase().includes(search.toLowerCase())">
                    <div class="px-4 pt-4 pb-2 flex-1">
                        <div class="flex items-start justify-between mb-2">
                            <span class="inline-flex items-center rounded-lg bg-brand-teal/10 dark:bg-teal-900/40 px-2.5 py-1 text-xs font-bold text-brand-teal dark:text-teal-400">{{ $s->course_code }}</span>
                            @php
                                $badge = match(true) {
                                    $s->status === 'completed' => ['label' => 'Completed', 'class' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 ring-purple-200 dark:ring-purple-800'],
                                    $s->available_slots == 0 => ['label' => 'Full', 'class' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 ring-red-200 dark:ring-red-800'],
                                    $s->status === 'in_progress' => ['label' => 'In-Progress', 'class' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 ring-amber-200 dark:ring-amber-800'],
                                    default => ['label' => 'Upcoming', 'class' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 ring-emerald-200 dark:ring-emerald-800'],
                                };
                            @endphp
                            <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold ring-1 ring-inset {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                        </div>
                        <h4 class="text-base font-bold text-gray-900 dark:text-white leading-snug mb-2">{{ $s->topic }}</h4>
                        <div class="space-y-1.5 text-sm text-gray-500 dark:text-slate-400">
                            <div class="flex items-center gap-2">
                                <svg class="size-3.5 text-gray-400 dark:text-slate-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                                <span>{{ $s->location }}</span>
                            </div>
                            @if ($s->date)
                            <div class="flex items-center gap-2">
                                <svg class="size-3.5 text-gray-400 dark:text-slate-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                                <span>{{ \Carbon\Carbon::parse($s->date)->format('D, d M Y') }} {{ $s->time ? 'at ' . $s->time : '' }}</span>
                            </div>
                            @endif
                            <div class="flex items-center gap-2">
                                <svg class="size-3.5 text-gray-400 dark:text-slate-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                                <span>by <strong class="font-medium text-gray-700 dark:text-slate-300">{{ $s->user?->name ?? 'Unknown' }}</strong></span>
                            </div>
                            @if ($s->material_path && $hasJoined)
                            <div>
                                <a href="{{ route('sessions.download', $s->id) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-brand-teal/10 dark:bg-teal-900/40 text-brand-teal dark:text-teal-400 px-3 py-1.5 text-xs font-bold hover:bg-brand-teal/20 dark:hover:bg-teal-900/60 transition">
                                    <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                                    Download Study Materials
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Participants bar -->
                    <div class="px-4 pb-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="flex gap-0.5">
                                    @for ($i = 1; $i <= $s->participant_limit; $i++)
                                    <span class="block size-2 rounded-full transition-all duration-300 {{ $i <= $s->joined_count ? 'bg-brand-teal dark:bg-teal-500' : 'bg-gray-200 dark:bg-slate-600' }}"></span>
                                    @endfor
                                </div>
                                <span class="text-xs font-semibold text-gray-500 dark:text-slate-400">{{ $s->joined_count }}/{{ $s->participant_limit }} joined</span>
                            </div>
                        </div>

                        <!-- RATING WIDGET for completed joined sessions -->
                        @if ($isCompletedForUser)
                        <div class="mt-2 pt-2 border-t border-gray-100 dark:border-slate-700">
                            <div x-data="{ showRatingModal: false, ratingVal: {{ $existingRating->rating_stars ?? 5 }} }">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-gray-600 dark:text-slate-300">Rate Session</span>
                                    @if (!$existingRating)
                                    <button class="text-xs font-bold text-brand-amber hover:text-brand-amber/80 transition" @click="showRatingModal = true">Rate Now</button>
                                    @else
                                    <div class="flex items-center gap-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                        <svg class="size-3.5 {{ $i <= $existingRating->rating_stars ? 'text-amber-400' : 'text-gray-200 dark:text-slate-600' }}" fill="currentColor" viewBox="0 0 24 24"><path d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" /></svg>
                                        @endfor
                                    </div>
                                    @endif
                                </div>

                                <!-- Rating Modal -->
                                <div x-show="showRatingModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" x-cloak @keydown.escape.window="showRatingModal = false">
                                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-100 dark:border-slate-700 p-5 max-w-sm w-full mx-4" @click.away="showRatingModal = false">
                                        <div class="flex items-center gap-2 mb-4">
                                            <span class="size-7 rounded-lg bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center">
                                                <svg class="size-3.5 text-brand-amber dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" /></svg>
                                            </span>
                                            <h3 class="text-base font-bold text-gray-900 dark:text-white">Rate: {{ $s->topic }}</h3>
                                        </div>
                                        <form method="POST" action="{{ route('sessions.rating', $s->id) }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1.5">Your Rating</label>
                                                <div class="flex items-center gap-1">
                                                    <template x-for="star in 5" :key="star">
                                                        <button type="button" class="transition-all duration-150 hover:scale-110" @click="ratingVal = star">
                                                            <svg class="size-7" :class="star <= ratingVal ? 'text-amber-400' : 'text-gray-200 dark:text-slate-600'" fill="currentColor" viewBox="0 0 24 24"><path d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" /></svg>
                                                        </button>
                                                    </template>
                                                    <span class="ml-2 text-xs font-bold text-gray-700 dark:text-slate-300" x-text="ratingVal + '/5'"></span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="rating_stars" x-model="ratingVal">
                                            <div class="mb-3">
                                                <label for="feedback_text_{{ $s->id }}" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Feedback (optional)</label>
                                                <textarea id="feedback_text_{{ $s->id }}" name="feedback_text" class="mt-1 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white shadow-sm focus:border-brand-amber focus:ring-brand-amber/20 text-sm" placeholder="Share your thoughts..." rows="2"></textarea>
                                            </div>
                                            <div class="flex justify-end gap-2">
                                                <button type="button" class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition" @click="showRatingModal = false">Cancel</button>
                                                <button type="submit" class="px-5 py-2 rounded-xl bg-brand-amber text-sm font-bold text-white shadow-md shadow-brand-amber/20 hover:bg-brand-amber/90 transition-all duration-300">Submit Rating</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- GROUP CHAT PANEL for joined users -->
                        @if ($hasJoined)
                        <div x-data="{ chatOpen: false }" class="mt-2 pt-2 border-t border-gray-100 dark:border-slate-700">
                            <button @click="chatOpen = !chatOpen" class="flex items-center gap-2 text-xs font-semibold text-brand-teal dark:text-teal-400 hover:text-brand-teal/80 transition w-full">
                                <svg class="size-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" /></svg>
                                <span>Chat ({{ count($s->chatMessages) }})</span>
                                <svg class="size-3 ml-auto transition-transform" :class="chatOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                            </button>
                            <div x-show="chatOpen" class="mt-1.5 border border-gray-100 dark:border-slate-700 rounded-xl overflow-hidden" x-cloak>
                                <div class="max-h-36 overflow-y-auto p-2.5 space-y-1.5 bg-gray-50 dark:bg-slate-700/50">
                                    @forelse ($s->chatMessages->take(20) as $msg)
                                    <div class="text-xs">
                                        <div class="flex items-center justify-between">
                                            <strong class="text-gray-700 dark:text-slate-300">{{ $msg->student_name }}</strong>
                                            <span class="text-[9px] text-gray-400 dark:text-slate-500">{{ $msg->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-gray-600 dark:text-slate-400 mt-0.5">{{ $msg->message_text }}</p>
                                    </div>
                                    @empty
                                    <p class="text-xs text-gray-400 dark:text-slate-500 text-center py-3">No messages yet. Start the conversation!</p>
                                    @endforelse
                                </div>
                                @if (count($s->chatMessages) > 20)
                                <div class="px-2.5 py-1.5 bg-white dark:bg-slate-800 border-t border-gray-100 dark:border-slate-700 text-center">
                                    <a href="#" class="text-[10px] font-semibold text-brand-teal dark:text-teal-400 hover:text-brand-teal/80 transition">View all messages</a>
                                </div>
                                @endif
                                <form method="POST" action="{{ route('sessions.chat', $s->id) }}" class="flex gap-1.5 p-2 bg-white dark:bg-slate-800 border-t border-gray-100 dark:border-slate-700">
                                    @csrf
                                    <input type="text" name="message_text" placeholder="Type a message..." required class="flex-1 rounded-lg border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white text-xs px-2.5 py-1.5 focus:border-brand-teal focus:ring-brand-teal/20" />
                                    <button type="submit" class="rounded-lg bg-brand-teal text-white px-3 py-1.5 text-xs font-bold hover:bg-brand-teal/90 transition shrink-0">Send</button>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Join button -->
                    <div class="px-4 pb-4">
                        <form method="POST" action="{{ route('sessions.join', $s->id) }}">
                            @csrf
                            <button type="submit" class="w-full rounded-xl px-4 py-2.5 text-sm font-bold shadow-sm transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed {{ $s->available_slots > 0 && $s->status !== 'completed' ? 'bg-brand-teal text-white shadow-brand-teal/20 hover:bg-brand-teal/90 hover:shadow-md' : 'bg-gray-100 dark:bg-slate-600 text-gray-400 dark:text-slate-500' }}" @if ($s->available_slots == 0 || $s->status === 'completed') disabled @endif>
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" /></svg>
                                    {{ $s->status === 'completed' ? 'Ended' : ($s->available_slots == 0 ? 'Full' : ($hasJoined ? 'Joined' : 'Join Group')) }}
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- ==================== HOST VIEW ==================== -->
        <div x-show="currentTab === 'host'" x-cloak>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">Your Hosted Groups</h3>
                <button class="inline-flex items-center gap-2 rounded-xl bg-brand-teal px-4 py-2.5 text-sm font-bold text-white shadow-md shadow-brand-teal/20 hover:bg-brand-teal/90 hover:shadow-lg transition-all duration-300" @click="showGroupModal = true">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Host a New Study Group
                </button>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 dark:divide-slate-700">
                        <thead>
                            <tr class="bg-gray-50/80 dark:bg-slate-700/80">
                                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Course</th>
                                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Topic</th>
                                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Date / Time</th>
                                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Location</th>
                                <th class="px-5 py-3 text-left text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                                <th class="px-5 py-3 text-right text-xs font-bold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-slate-700/50">
                            @forelse ($myGroups as $s)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition-colors duration-150">
                                <td class="px-5 py-3 whitespace-nowrap"><span class="inline-flex items-center rounded-lg bg-brand-teal/10 dark:bg-teal-900/40 px-2 py-1 text-xs font-bold text-brand-teal dark:text-teal-400">{{ $s->course_code }}</span></td>
                                <td class="px-5 py-3 whitespace-nowrap text-sm font-semibold text-gray-700 dark:text-slate-300 max-w-[180px] truncate">{{ $s->topic }}</td>
                                <td class="px-5 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">
                                    @if ($s->date)
                                    {{ \Carbon\Carbon::parse($s->date)->format('D, d M Y') }}
                                    @if ($s->time)<br><span class="text-xs">{{ $s->time }}</span>@endif
                                    @else <span class="text-gray-400 dark:text-slate-500">&mdash;</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400 max-w-[160px] truncate">{{ $s->location }}</td>
                                <td class="px-5 py-3 whitespace-nowrap">
                                    @php
                                        $hostBadge = match(true) {
                                            $s->status === 'completed' => ['label' => 'Completed', 'class' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 ring-purple-200 dark:ring-purple-800'],
                                            $s->available_slots == 0 => ['label' => 'Full', 'class' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 ring-red-200 dark:ring-red-800'],
                                            $s->status === 'in_progress' => ['label' => 'In-Progress', 'class' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 ring-amber-200 dark:ring-amber-800'],
                                            default => ['label' => 'Upcoming', 'class' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 ring-emerald-200 dark:ring-emerald-800'],
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold ring-1 ring-inset {{ $hostBadge['class'] }}">{{ $hostBadge['label'] }}</span>
                                </td>
                                <td class="px-5 py-3 whitespace-nowrap text-right text-sm">
                                    <div x-data="{ showEditModal: false }">
                                        <button class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs font-bold text-brand-indigo dark:text-indigo-400 hover:bg-brand-indigo/5 dark:hover:bg-indigo-900/20 transition" @click="showEditModal = true">
                                            <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" /></svg>
                                            Edit
                                        </button>

                                        <!-- Inline Edit Session Modal -->
                                        <div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" x-cloak>
                                            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-100 dark:border-slate-700 p-6 max-w-lg w-full mx-4 max-h-[90vh] overflow-y-auto" @click.away="showEditModal = false">
                                                <div class="flex items-center gap-3 mb-6">
                                                    <span class="size-8 rounded-lg bg-brand-teal/10 dark:bg-teal-900/40 flex items-center justify-center"><svg class="size-4 text-brand-teal dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" /></svg></span>
                                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Edit Study Group</h3>
                                                </div>
                                                <form method="POST" action="{{ route('sessions.update', $s->id) }}" enctype="multipart/form-data" class="space-y-4">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <div>
                                                            <label for="edit_course_code_{{ $s->id }}" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Course Code</label>
                                                            <input id="edit_course_code_{{ $s->id }}" type="text" name="course_code" value="{{ $s->course_code }}" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring-brand-teal/20 transition" required />
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label for="edit_topic_{{ $s->id }}" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Topic / Description</label>
                                                        <input id="edit_topic_{{ $s->id }}" type="text" name="topic" value="{{ $s->topic }}" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring-brand-teal/20 transition" required />
                                                    </div>
                                                    <div>
                                                        <label for="edit_location_{{ $s->id }}" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Campus Location</label>
                                                        <select id="edit_location_{{ $s->id }}" name="location" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white shadow-sm focus:border-brand-teal focus:ring-brand-teal/20 text-sm" required>
                                                            <option value="" disabled>Select a campus zone...</option>
                                                            @foreach (['Main Library', 'Kulliyyah Hub', 'Central Complex Cafe', 'Virtual/Online'] as $loc)
                                                            <option value="{{ $loc }}" {{ $s->location === $loc ? 'selected' : '' }}>{{ $loc }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <div>
                                                            <label for="edit_date_{{ $s->id }}" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Date</label>
                                                            <input id="edit_date_{{ $s->id }}" type="date" name="date" value="{{ $s->date }}" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring-brand-teal/20 transition" required />
                                                        </div>
                                                        <div>
                                                            <label for="edit_time_{{ $s->id }}" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Time</label>
                                                            <input id="edit_time_{{ $s->id }}" type="time" name="time" value="{{ $s->time }}" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring-brand-teal/20 transition" required />
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label for="edit_participant_limit_{{ $s->id }}" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Participant Limit</label>
                                                        <input id="edit_participant_limit_{{ $s->id }}" type="number" name="participant_limit" value="{{ $s->participant_limit }}" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring-brand-teal/20 transition" min="1" max="100" required />
                                                    </div>
                                                    <div>
                                                        <label for="edit_material_{{ $s->id }}" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Study Materials (PDF, Document, Image)</label>
                                                        <input id="edit_material_{{ $s->id }}" type="file" name="material" accept=".pdf,.doc,.docx,.ppt,.pptx,.png,.jpg,.jpeg,.webp" class="mt-1.5 block w-full text-sm text-gray-500 dark:text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-teal/10 dark:file:bg-teal-900/40 file:text-brand-teal dark:file:text-teal-400 hover:file:bg-brand-teal/20 dark:hover:file:bg-teal-900/60 transition file:cursor-pointer cursor-pointer" />
                                                        @if ($s->material_path)
                                                        <p class="mt-1.5 text-xs text-gray-400 dark:text-slate-500">Current file: {{ basename($s->material_path) }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="flex justify-end gap-3 pt-2">
                                                        <button type="button" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition" @click="showEditModal = false">Cancel</button>
                                                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-teal text-sm font-bold text-white shadow-md shadow-brand-teal/20 hover:bg-brand-teal/90 transition-all duration-300">Update Group</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($s->status !== 'completed')
                                    <form method="POST" action="{{ route('sessions.completed', $s->id) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs font-bold text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition ml-1" onclick="return confirm('Mark &quot;{{ $s->topic }}&quot; as completed?')">
                                            <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                                            Complete
                                        </button>
                                    </form>
                                    @endif

                                    <form method="POST" action="{{ route('sessions.destroy', $s->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs font-bold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition ml-1" onclick="return confirm('Delete &quot;{{ $s->topic }}&quot;?')">
                                            <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="px-5 py-12 text-center text-gray-500 dark:text-slate-400">
                                <svg class="mx-auto size-10 text-gray-300 dark:text-slate-600 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
                                <p class="font-semibold">No groups yet</p>
                                <p class="text-sm mt-1">Click "Host a New Study Group" to get started.</p>
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ATTENDANCE CHECKLIST -->
            @php
                $activeSessions = $myGroups->filter(fn($s) => $s->status !== 'completed' && $s->status !== 'full');
            @endphp
            @if (count($activeSessions) > 0)
            <div class="mt-6 space-y-4">
                <h3 class="text-base font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    <svg class="size-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    Manage Attendance
                </h3>
                @foreach ($activeSessions as $s)
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden" x-data="{ showAttendance: false, checks: {} }">
                    <div class="px-5 py-3 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between">
                        <div>
                            <span class="inline-flex items-center rounded-lg bg-brand-teal/10 dark:bg-teal-900/40 px-2 py-1 text-xs font-bold text-brand-teal dark:text-teal-400">{{ $s->course_code }}</span>
                            <span class="ml-2 text-sm font-semibold text-gray-700 dark:text-slate-300">{{ $s->topic }}</span>
                        </div>
                        <button class="rounded-lg bg-emerald-600 px-3 py-2 text-xs font-bold text-white hover:bg-emerald-700 transition disabled:opacity-50" @if (!$s->users || count($s->users) === 0) disabled @endif @click="showAttendance = true">
                            @if (!$s->users || count($s->users) === 0) No Joiners @else Take Attendance ({{ count($s->users) }}) @endif
                        </button>
                    </div>
                    <div x-show="showAttendance" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" x-cloak>
                        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-100 dark:border-slate-700 p-6 max-w-lg w-full mx-4" @click.away="showAttendance = false">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="size-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center"><svg class="size-4 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg></span>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Attendance: {{ $s->course_code }} &mdash; {{ $s->topic }}</h3>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-slate-400 mb-4">Toggle switches to mark attendance for each joined student.</p>
                            @if (!$s->users || count($s->users) === 0)
                            <div class="text-center py-8 text-gray-400 dark:text-slate-500">
                                <svg class="mx-auto size-8 mb-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" /></svg>
                                <p class="text-sm font-medium">No students have joined this session yet.</p>
                            </div>
                            @else
                            <form method="POST" action="{{ route('sessions.attendance-bulk', $s->id) }}">
                                @csrf
                                <div class="space-y-2 mb-4">
                                    @foreach ($s->users as $u)
                                    @php
                                        $existingAtt = $myAttendance->firstWhere(fn($a) => $a->study_group_id === $s->id && $a->student_matric === $u->matric_number);
                                    @endphp
                                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-slate-700/50 border border-gray-100 dark:border-slate-600">
                                        <div class="flex items-center gap-3">
                                            <span class="size-8 rounded-full bg-brand-teal/10 dark:bg-teal-900/40 flex items-center justify-center text-brand-teal dark:text-teal-400 font-bold text-xs">{{ $u->name[0] }}</span>
                                            <div>
                                                <p class="text-sm font-semibold text-gray-800 dark:text-slate-200">{{ $u->name }}</p>
                                                <p class="text-xs text-gray-400 dark:text-slate-500">{{ $u->matric_number ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="attendance[{{ $u->matric_number }}]" value="1" class="sr-only peer" {{ $existingAtt && $existingAtt->attended ? 'checked' : '' }} />
                                            <input type="hidden" name="matric_numbers[]" value="{{ $u->matric_number }}" />
                                            <div class="w-11 h-6 bg-gray-200 dark:bg-slate-600 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-emerald-500/30 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-600"></div>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="flex justify-end gap-3">
                                    <button type="button" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition" @click="showAttendance = false">Cancel</button>
                                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-sm font-bold text-white shadow-md shadow-emerald-600/20 hover:bg-emerald-700 transition-all duration-300">Save Attendance</button>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- ==================== HELP WANTED SECTION (always visible) ==================== -->
        <div class="mt-8">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Peer Help Requests</h3>
                    <p class="text-sm text-gray-500 dark:text-slate-400">Browse open requests or post your own.</p>
                </div>
            </div>

            @if (count($helpRequests) === 0)
            <div class="text-center py-16 bg-white dark:bg-slate-800 rounded-2xl border border-gray-100 dark:border-slate-700">
                <svg class="mx-auto size-10 text-gray-300 dark:text-slate-600 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" /></svg>
                <p class="font-semibold text-gray-500 dark:text-slate-400">No help requests yet</p>
                <p class="text-sm text-gray-400 dark:text-slate-500 mt-1">Be the first to post one.</p>
            </div>
            @else
            <div class="grid gap-4 md:grid-cols-2">
                @foreach ($helpRequests as $h)
                @php
                    $helpBadge = match($h->status) {
                        'resolved' => ['label' => 'Resolved', 'class' => 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-slate-300 ring-gray-200 dark:ring-slate-600'],
                        'in_progress' => ['label' => 'In-Progress', 'class' => 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 ring-amber-200 dark:ring-amber-800'],
                        default => ['label' => 'Open', 'class' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 ring-emerald-200 dark:ring-emerald-800'],
                    };
                @endphp
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 hover:shadow-md transition-all duration-300 p-5">
                    <div class="flex items-start justify-between mb-3">
                        <span class="inline-flex items-center rounded-lg bg-brand-amber/10 dark:bg-amber-900/40 px-2.5 py-1 text-xs font-bold text-brand-amber dark:text-amber-400">{{ $h->course_code }}</span>
                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold ring-1 ring-inset {{ $helpBadge['class'] }}">{{ $helpBadge['label'] }}</span>
                    </div>
                    <a href="{{ route('help-requests.show', $h->id) }}" class="block">
                        <h4 class="text-base font-bold text-gray-900 dark:text-white leading-snug mb-2 hover:text-brand-teal dark:hover:text-teal-400 transition-colors">{{ $h->topic }}</h4>
                        <p class="text-sm text-gray-500 dark:text-slate-400 line-clamp-2 mb-3">{{ $h->description }}</p>
                    </a>
                    @if ($h->image_path)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $h->image_path) }}" alt="{{ $h->topic }}" class="rounded-xl max-h-40 w-full object-cover border border-gray-100 dark:border-slate-600" />
                    </div>
                    @endif
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-slate-500">
                            <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" /></svg>
                            <span class="font-medium">{{ $h->response_count }} Peer Responses</span>
                        </div>
                        <div class="flex gap-1.5 items-center">
                            <a href="{{ route('help-requests.show', $h->id) }}" class="rounded-lg px-3 py-1.5 text-xs font-bold bg-brand-teal/10 dark:bg-teal-900/40 text-brand-teal dark:text-teal-400 hover:bg-brand-teal/20 dark:hover:bg-teal-900/60 transition">Respond</a>
                            @if ($h->user_id === auth()->id())
                            <div x-data="{ showEditHelp: false }">
                                <button class="rounded-lg px-2.5 py-1.5 text-xs font-semibold text-brand-indigo dark:text-indigo-400 hover:bg-brand-indigo/5 dark:hover:bg-indigo-900/20 transition" @click="showEditHelp = true">Edit</button>
                                <div x-show="showEditHelp" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" x-cloak>
                                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-100 dark:border-slate-700 p-6 max-w-lg w-full mx-4" @click.away="showEditHelp = false">
                                        <div class="flex items-center gap-3 mb-6">
                                            <span class="size-8 rounded-lg bg-brand-amber/10 dark:bg-amber-900/40 flex items-center justify-center"><svg class="size-4 text-brand-amber dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" /></svg></span>
                                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Edit Help Request</h3>
                                        </div>
                                        <form method="POST" action="{{ route('help-requests.update', $h->id) }}" enctype="multipart/form-data" class="space-y-4">
                                            @csrf
                                            @method('PUT')
                                            <div>
                                                <label for="edit_help_status_{{ $h->id }}" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Status</label>
                                                <select id="edit_help_status_{{ $h->id }}" name="status" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white shadow-sm focus:border-brand-amber focus:ring-brand-amber/20 text-sm" required>
                                                    <option value="open" {{ $h->status === 'open' ? 'selected' : '' }}>Open</option>
                                                    <option value="in_progress" {{ $h->status === 'in_progress' ? 'selected' : '' }}>In-Progress</option>
                                                    <option value="resolved" {{ $h->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="edit_help_code_{{ $h->id }}" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Course Code</label>
                                                <input id="edit_help_code_{{ $h->id }}" type="text" name="course_code" value="{{ $h->course_code }}" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-amber focus:ring-brand-amber/20 transition" required />
                                            </div>
                                            <div>
                                                <label for="edit_help_topic_{{ $h->id }}" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Topic Title</label>
                                                <input id="edit_help_topic_{{ $h->id }}" type="text" name="topic" value="{{ $h->topic }}" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-amber focus:ring-brand-amber/20 transition" required />
                                            </div>
                                            <div>
                                                <label for="edit_help_desc_{{ $h->id }}" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Issue Description</label>
                                                <textarea id="edit_help_desc_{{ $h->id }}" name="description" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white shadow-sm focus:border-brand-amber focus:ring-brand-amber/20 text-sm" rows="4" required>{{ $h->description }}</textarea>
                                            </div>
                                            <div>
                                                <label for="edit_help_image_{{ $h->id }}" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Upload Screenshot / Image (optional)</label>
                                                <input id="edit_help_image_{{ $h->id }}" type="file" name="image" accept="image/*" class="mt-1.5 block w-full text-sm text-gray-500 dark:text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-amber/10 dark:file:bg-amber-900/40 file:text-brand-amber dark:file:text-amber-400 hover:file:bg-brand-amber/20 dark:hover:file:bg-amber-900/60 transition file:cursor-pointer cursor-pointer" />
                                                @if ($h->image_path)
                                                <p class="mt-1.5 text-xs text-gray-400 dark:text-slate-500">Current file: {{ basename($h->image_path) }}</p>
                                                @endif
                                            </div>
                                            <div class="flex justify-end gap-3 pt-2">
                                                <button type="button" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition" @click="showEditHelp = false">Cancel</button>
                                                <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-amber text-sm font-bold text-white shadow-md shadow-brand-amber/20 hover:bg-brand-amber/90 transition-all duration-300">Update Request</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('help-requests.destroy', $h->id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg px-2.5 py-1.5 text-xs font-semibold text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition" onclick="return confirm('Delete help request &quot;{{ $h->topic }}&quot;?')">Delete</button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- ==================== GROUP CREATION MODAL ==================== -->
        <div x-show="showGroupModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" x-cloak>
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-100 dark:border-slate-700 p-6 max-w-lg w-full mx-4 max-h-[90vh] overflow-y-auto" @click.away="showGroupModal = false">
                <div class="flex items-center gap-3 mb-6">
                    <span class="size-8 rounded-lg bg-brand-teal/10 dark:bg-teal-900/40 flex items-center justify-center">
                        <svg class="size-4 text-brand-teal dark:text-teal-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" /></svg>
                    </span>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Host a New Study Group</h3>
                </div>
                <form method="POST" action="{{ route('sessions.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="course_code" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Course Code</label>
                        <input id="course_code" type="text" name="course_code" value="{{ old('course_code') }}" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring-brand-teal/20 transition" placeholder="e.g. INFO 3305" required />
                        @error('course_code')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    </div>
                    <div>
                        <label for="topic" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Topic / Description</label>
                        <input id="topic" type="text" name="topic" value="{{ old('topic') }}" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring-brand-teal/20 transition" placeholder="e.g. Database Normalization & ER Diagrams" required />
                        @error('topic')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Campus Location</label>
                        <select id="location" name="location" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white shadow-sm focus:border-brand-teal focus:ring-brand-teal/20 text-sm" required>
                            <option value="" disabled selected>Select a campus zone...</option>
                            <option value="Main Library">Main Library</option>
                            <option value="Kulliyyah Hub">Kulliyyah Hub</option>
                            <option value="Central Complex Cafe">Central Complex Cafe</option>
                            <option value="Virtual/Online">Virtual/Online</option>
                        </select>
                        @error('location')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Date</label>
                        <input id="date" type="date" name="date" value="{{ old('date') }}" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring-brand-teal/20 transition" required />
                        @error('date')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="time" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Time</label>
                        <input id="time" type="time" name="time" value="{{ old('time') }}" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring-brand-teal/20 transition" required />
                        @error('time')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label for="participant_limit" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Participant Limit</label>
                        <input id="participant_limit" type="number" name="participant_limit" value="{{ old('participant_limit', 6) }}" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-teal focus:ring-brand-teal/20 transition" min="1" max="100" placeholder="e.g. 6" required />
                        @error('participant_limit')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="material" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Share Study Materials (PDF, Document, Image)</label>
                        <input id="material" type="file" name="material" accept=".pdf,.doc,.docx,.ppt,.pptx,.png,.jpg,.jpeg,.webp" class="mt-1.5 block w-full text-sm text-gray-500 dark:text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-teal/10 dark:file:bg-teal-900/40 file:text-brand-teal dark:file:text-teal-400 hover:file:bg-brand-teal/20 dark:hover:file:bg-teal-900/60 transition file:cursor-pointer cursor-pointer" />
                        @error('material')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition" @click="showGroupModal = false">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-teal text-sm font-bold text-white shadow-md shadow-brand-teal/20 hover:bg-brand-teal/90 transition-all duration-300">Create Group</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ==================== HELP REQUEST MODAL ==================== -->
        <div x-show="showHelpModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40" x-cloak>
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-gray-100 dark:border-slate-700 p-6 max-w-lg w-full mx-4" @click.away="showHelpModal = false">
                <div class="flex items-center gap-3 mb-6">
                    <span class="size-8 rounded-lg bg-brand-amber/10 dark:bg-amber-900/40 flex items-center justify-center">
                        <svg class="size-4 text-brand-amber dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" /></svg>
                    </span>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Post a New Help Request</h3>
                </div>
                <form method="POST" action="{{ route('help-requests.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label for="hc_course_code" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Course Code</label>
                        <input id="hc_course_code" type="text" name="course_code" value="{{ old('course_code') }}" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-amber focus:ring-brand-amber/20 transition" placeholder="e.g. MATH 2100" required />
                        @error('course_code')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="hc_topic" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Topic Title</label>
                        <input id="hc_topic" type="text" name="topic" value="{{ old('topic') }}" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:border-brand-amber focus:ring-brand-amber/20 transition" placeholder="e.g. Struggling with Integration by Parts" required />
                        @error('topic')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="hc_desc" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Issue Description</label>
                        <textarea id="hc_desc" name="description" class="mt-1.5 block w-full rounded-xl border-gray-200 dark:border-slate-600 dark:bg-slate-700 dark:text-white shadow-sm focus:border-brand-amber focus:ring-brand-amber/20 text-sm" placeholder="Describe what you need help with..." rows="4" required>{{ old('description') }}</textarea>
                        @error('description')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="hc_image" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Upload Screenshot / Image (optional)</label>
                        <input id="hc_image" type="file" name="image" accept="image/*" class="mt-1.5 block w-full text-sm text-gray-500 dark:text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-amber/10 dark:file:bg-amber-900/40 file:text-brand-amber dark:file:text-amber-400 hover:file:bg-brand-amber/20 dark:hover:file:bg-amber-900/60 transition file:cursor-pointer cursor-pointer" />
                        @error('image')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 dark:text-slate-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition" @click="showHelpModal = false">Cancel</button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-amber text-sm font-bold text-white shadow-md shadow-brand-amber/20 hover:bg-brand-amber/90 transition-all duration-300">Post Request</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection