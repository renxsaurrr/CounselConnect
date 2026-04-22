@extends('CounselConnect.layouts.admin')

@section('title', 'Session Record')
@section('page-title', 'Sessions')

@section('content')

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="{{ route('admin.sessions.index') }}" class="hover:text-blue-600 transition-colors">Session Records</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
        </svg>
        <span class="text-gray-600 font-medium">Session #{{ $session->id }}</span>
    </div>

    {{-- ── Main grid: stacks on mobile, 3-col on lg ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 max-w-5xl">

        {{-- ── Left: Main Record (full width mobile, 2-col lg) ── --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Record Card --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">

                {{-- Header --}}
                <div class="px-5 sm:px-7 py-5 border-b border-gray-50">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                @if($session->intervention)
                                    <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold bg-purple-50 text-purple-700">
                                        {{ $session->intervention }}
                                    </span>
                                @endif
                                <span class="flex items-center gap-1.5 text-xs {{ $session->follow_up_needed ? 'text-yellow-600' : 'text-gray-400' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $session->follow_up_needed ? 'bg-yellow-500' : 'bg-gray-300' }}"></span>
                                    Follow-up {{ $session->follow_up_needed ? 'Required' : 'Not Required' }}
                                </span>
                            </div>
                            <h2 class="text-lg sm:text-xl font-bold text-gray-900">Session Record</h2>
                            <p class="text-xs text-gray-400 mt-1">Recorded {{ $session->created_at->format('F d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Session Notes --}}
                <div class="px-5 sm:px-7 py-6 space-y-5">

                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Session Notes</p>
                        <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap bg-gray-50 px-4 py-3 rounded-xl">{{ $session->session_notes }}</div>
                    </div>

                    @if($session->intervention)
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Intervention Used</p>
                            <span class="inline-flex px-3 py-1.5 rounded-xl text-sm font-semibold bg-purple-50 text-purple-700">
                                {{ $session->intervention }}
                            </span>
                        </div>
                    @endif

                    {{-- Follow-up + Next Session — stacks on mobile --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Follow-Up Needed</p>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="w-2 h-2 rounded-full {{ $session->follow_up_needed ? 'bg-yellow-500' : 'bg-gray-300' }}"></span>
                                <span class="text-sm font-semibold {{ $session->follow_up_needed ? 'text-yellow-700' : 'text-gray-500' }}">
                                    {{ $session->follow_up_needed ? 'Yes' : 'No' }}
                                </span>
                            </div>
                        </div>

                        @if($session->next_session_date)
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Next Session Date</p>
                                <p class="text-sm font-semibold text-gray-800">
                                    {{ \Carbon\Carbon::parse($session->next_session_date)->format('F d, Y') }}
                                </p>
                            </div>
                        @endif

                    </div>

                </div>
            </div>

            {{-- Linked Appointment --}}
            @if($session->appointment)
                <div class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="text-sm font-semibold text-gray-900">Linked Appointment</h3>
                    </div>
                    {{-- 1 col mobile, 3 col sm --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Concern</p>
                            <p class="text-sm text-gray-700">{{ ucfirst(str_replace('_', ' ', $session->appointment->concern_type)) }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Date</p>
                            <p class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($session->appointment->preferred_date)->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Status</p>
                            <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold bg-blue-50 text-blue-700">
                                {{ ucfirst($session->appointment->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.appointments.show', $session->appointment) }}"
                           class="text-xs font-semibold text-blue-600 hover:text-blue-700 transition-colors">
                            View Appointment →
                        </a>
                    </div>
                </div>
            @endif

        </div>

        {{-- ── Right: People — full width mobile, sidebar lg ── --}}
        <div class="space-y-4">

            {{-- Student --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Student</p>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold shrink-0">
                        {{ strtoupper(substr($session->student?->name ?? 'S', 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $session->student?->name ?? '—' }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $session->student?->email ?? '—' }}</p>
                    </div>
                </div>
                @if($session->student?->studentProfile)
                    <div class="space-y-2 border-t border-gray-50 pt-3">
                        <div class="flex justify-between gap-2">
                            <span class="text-xs text-gray-400 shrink-0">Student ID</span>
                            <span class="text-xs font-medium text-gray-700 text-right">{{ $session->student->studentProfile->student_id ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between gap-2">
                            <span class="text-xs text-gray-400 shrink-0">Department</span>
                            <span class="text-xs font-medium text-gray-700 text-right">{{ $session->student->studentProfile->department ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between gap-2">
                            <span class="text-xs text-gray-400 shrink-0">Year Level</span>
                            <span class="text-xs font-medium text-gray-700 text-right">{{ $session->student->studentProfile->year_level ?? '—' }}</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Counselor --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Counselor</p>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold shrink-0">
                        {{ strtoupper(substr($session->counselor?->name ?? 'C', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $session->counselor?->name ?? '—' }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $session->counselor?->email ?? '—' }}</p>
                    </div>
                </div>
                @if($session->counselor?->counselorProfile)
                    <div class="space-y-2 border-t border-gray-50 pt-3">
                        <div class="flex justify-between gap-2">
                            <span class="text-xs text-gray-400 shrink-0">Specialization</span>
                            <span class="text-xs font-medium text-gray-700 text-right">{{ $session->counselor->counselorProfile->specialization ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between gap-2">
                            <span class="text-xs text-gray-400 shrink-0">Office</span>
                            <span class="text-xs font-medium text-gray-700 text-right">{{ $session->counselor->counselorProfile->office_location ?? '—' }}</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Record Meta --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Record Info</p>
                <div class="space-y-2">
                    <div class="flex justify-between gap-2">
                        <span class="text-xs text-gray-400 shrink-0">Record ID</span>
                        <span class="text-xs font-medium text-gray-700">#{{ $session->id }}</span>
                    </div>
                    <div class="flex justify-between gap-2">
                        <span class="text-xs text-gray-400 shrink-0">Created</span>
                        <span class="text-xs font-medium text-gray-700">{{ $session->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between gap-2">
                        <span class="text-xs text-gray-400 shrink-0">Last Updated</span>
                        <span class="text-xs font-medium text-gray-700">{{ $session->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Back --}}
    <div class="mt-5 max-w-5xl">
        <a href="{{ route('admin.sessions.index') }}"
           class="flex items-center gap-2 text-sm text-gray-400 hover:text-gray-600 transition-colors w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Back to Session Records
        </a>
    </div>

@endsection