@extends('CounselConnect.layouts.counselor')

@section('title', 'Session Record')
@section('page-title', 'Sessions')

@section('content')

{{-- ── Back Link ── --}}
<a href="{{ route('counselor.sessions.index') }}"
   class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 mb-6 transition-colors">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    Back to Sessions
</a>

{{-- ── Flash ── --}}
@if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-xl bg-green-50 border border-green-100 text-green-700 text-sm">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

{{-- ── Main Grid ── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- ── Left: Student + Appointment Info ── --}}
    <div class="lg:col-span-1 space-y-5">

        {{-- Student Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 sm:px-6 py-5 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-900">Student</h2>
            </div>
            <div class="px-5 sm:px-6 py-5">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-11 h-11 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                        @if($sessionRecord->student->studentProfile?->profile_picture)
                            <img src="{{ asset('storage/' . $sessionRecord->student->studentProfile->profile_picture) }}"
                                 alt="{{ $sessionRecord->student->name }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($sessionRecord->student->name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $sessionRecord->student->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $sessionRecord->student->email }}</p>
                    </div>
                </div>
                <div class="space-y-2.5">
                    @if($sessionRecord->student->studentProfile?->department)
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-xs text-gray-400 shrink-0">Department</p>
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 truncate max-w-[140px]">
                                {{ $sessionRecord->student->studentProfile->department }}
                            </span>
                        </div>
                    @endif
                    @if($sessionRecord->student->studentProfile?->year_level)
                        <div class="flex items-center justify-between">
                            <p class="text-xs text-gray-400">Year Level</p>
                            <p class="text-sm text-gray-700">{{ $sessionRecord->student->studentProfile->year_level }}</p>
                        </div>
                    @endif
                    @if($sessionRecord->student->studentProfile?->student_id)
                        <div class="flex items-center justify-between">
                            <p class="text-xs text-gray-400">Student ID</p>
                            <p class="text-sm text-gray-700 font-mono">{{ $sessionRecord->student->studentProfile->student_id }}</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="px-5 sm:px-6 pb-5">
                <a href="{{ route('counselor.students.show', $sessionRecord->student) }}"
                   class="flex items-center justify-center gap-2 w-full px-4 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                    View Student Profile
                </a>
            </div>
        </div>

        {{-- Linked Appointment --}}
        @if($sessionRecord->appointment)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 sm:px-6 py-5 border-b border-gray-100">
                    <h2 class="text-base font-semibold text-gray-900">Linked Appointment</h2>
                </div>
                <div class="px-5 sm:px-6 py-5 space-y-3">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Concern</p>
                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                            {{ ucfirst(str_replace('_', ' ', $sessionRecord->appointment->concern_type)) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Preferred Date</p>
                        <p class="text-sm font-medium text-gray-800">
                            {{ \Carbon\Carbon::parse($sessionRecord->appointment->preferred_date)->format('F d, Y') }}
                        </p>
                    </div>
                    @if($sessionRecord->appointment->scheduled_at)
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Scheduled At</p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($sessionRecord->appointment->scheduled_at)->format('M d, Y — g:i A') }}
                            </p>
                        </div>
                    @endif
                </div>
                <div class="px-5 sm:px-6 pb-5">
                    <a href="{{ route('counselor.appointments.show', $sessionRecord->appointment) }}"
                       class="flex items-center justify-center gap-2 w-full px-4 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                        View Appointment
                    </a>
                </div>
            </div>
        @endif

    </div>

    {{-- ── Right: Session Record Details ── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Record Meta Bar --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-4 sm:px-6 py-4">
            {{-- Top row: meta info --}}
            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 mb-4">
                <div>
                    <p class="text-xs text-gray-400">Recorded</p>
                    <p class="text-sm font-medium text-gray-800">{{ $sessionRecord->created_at->format('M d, Y — g:i A') }}</p>
                </div>
                @if($sessionRecord->updated_at->ne($sessionRecord->created_at))
                    <div class="pl-4 border-l border-gray-100">
                        <p class="text-xs text-gray-400">Last Updated</p>
                        <p class="text-sm text-gray-600">{{ $sessionRecord->updated_at->format('M d, Y') }}</p>
                    </div>
                @endif
                <div class="pl-4 border-l border-gray-100">
                    @if($sessionRecord->follow_up_needed)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            Follow-up Needed
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            No Follow-up
                        </span>
                    @endif
                </div>
            </div>
            {{-- Edit button: full width on mobile, auto on larger --}}
            <a href="{{ route('counselor.sessions.edit', $sessionRecord) }}"
               class="inline-flex items-center justify-center gap-1.5 w-full sm:w-auto px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Record
            </a>
        </div>

        {{-- Session Notes --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 sm:px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Session Notes</h3>
            </div>
            <div class="px-5 sm:px-6 py-5">
                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $sessionRecord->session_notes }}</p>
            </div>
        </div>

        {{-- Intervention --}}
        @if($sessionRecord->intervention)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 sm:px-6 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900">Intervention</h3>
                </div>
                <div class="px-5 sm:px-6 py-5">
                    <p class="text-sm text-gray-700">{{ $sessionRecord->intervention }}</p>
                </div>
            </div>
        @endif

        {{-- Follow-up Info --}}
        @if($sessionRecord->follow_up_needed && $sessionRecord->next_session_date)
            <div class="bg-rose-50 border border-rose-100 rounded-2xl px-4 sm:px-6 py-4 flex items-start sm:items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-rose-700">Follow-up Scheduled</p>
                    <p class="text-xs text-rose-500 mt-0.5">
                        Next session on
                        <span class="font-semibold">{{ \Carbon\Carbon::parse($sessionRecord->next_session_date)->format('F d, Y') }}</span>
                        ({{ \Carbon\Carbon::parse($sessionRecord->next_session_date)->diffForHumans() }})
                    </p>
                </div>
            </div>
        @endif

    </div>

</div>

@endsection