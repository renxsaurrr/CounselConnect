@extends('CounselConnect.layouts.student')

@section('title', 'My Sessions')
@section('page-title', 'Sessions')

@section('content')

    {{-- ── Page Header: wraps on small screens ── --}}
    <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">My Sessions</h2>
            <p class="text-sm text-gray-500 mt-0.5">Review your journey and progress.</p>
        </div>
        <a href="{{ route('student.appointments.create') }}"
           class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-colors whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Request New Session
        </a>
    </div>

    {{-- ── Stats Banner: stacks on mobile, 3-col on sm+ ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

        {{-- Reflective Space card: full-width on mobile, spans 2 cols on sm+ --}}
        <div class="sm:col-span-2 bg-white rounded-2xl border border-gray-100 p-6 flex flex-wrap items-center gap-6">
            <div class="flex-1 min-w-0">
                <h3 class="text-base font-bold text-gray-900">Reflective Space</h3>
                <p class="text-sm text-gray-400 mt-1 leading-relaxed max-w-xs">
                    Your progress is more than just data points. Each session represents a step toward your well-being.
                </p>
            </div>
            <div class="flex items-center gap-8 shrink-0">
                <div class="text-center">
                    <p class="text-3xl font-bold text-blue-600">{{ $totalSessions }}</p>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mt-0.5">Sessions</p>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-bold text-blue-600">{{ $totalMonths }}</p>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mt-0.5">Months</p>
                </div>
            </div>
        </div>

        {{-- Upcoming Milestone card --}}
        <div class="bg-blue-600 rounded-2xl p-6 flex flex-col justify-between min-h-[140px]">
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center mb-3">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 3l14 9-14 9V3z"/>
                </svg>
            </div>
            @if($nextSession)
                <div>
                    <p class="text-xs text-blue-200 font-medium uppercase tracking-wide">Upcoming Milestone</p>
                    <p class="text-white text-sm font-semibold mt-1 leading-snug">
                        Next review scheduled for<br>
                        {{ \Carbon\Carbon::parse($nextSession)->format('F d, Y') }}
                    </p>
                </div>
            @else
                <div>
                    <p class="text-xs text-blue-200 font-medium uppercase tracking-wide">Upcoming Milestone</p>
                    <p class="text-white text-sm font-semibold mt-1 leading-snug">No upcoming sessions scheduled</p>
                </div>
            @endif
        </div>

    </div>

    {{-- ── Session Records List ── --}}
    @if($sessions->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 py-20 text-center">
            <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p class="text-sm font-medium text-gray-400">No sessions recorded yet</p>
            <a href="{{ route('student.appointments.create') }}" class="text-xs text-blue-500 hover:underline mt-1 inline-block">Book your first appointment</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($sessions as $session)
                @php
                    $appointment = $session->appointment;
                    $counselor   = $appointment?->counselor;
                    $date        = $appointment?->scheduled_at ?? $appointment?->preferred_date;
                @endphp
                <article class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-6 hover:border-blue-100 transition-colors">
                    <div class="flex gap-4 sm:gap-6 items-start">

                        {{-- Date column --}}
                        <div class="shrink-0 text-center w-10 sm:w-12">
                            <p class="text-xs font-semibold text-gray-400 uppercase">
                                {{ \Carbon\Carbon::parse($date)->format('M') }}
                            </p>
                            <p class="text-xl sm:text-2xl font-bold text-gray-900 leading-none">
                                {{ \Carbon\Carbon::parse($date)->format('d') }}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ \Carbon\Carbon::parse($date)->format('Y') }}
                            </p>
                        </div>

                        {{-- Divider --}}
                        <div class="w-px bg-gray-100 self-stretch shrink-0"></div>

                        {{-- Main content --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="text-sm sm:text-base font-semibold text-gray-900">
                                        {{ $appointment?->concern_type ?? 'Counseling Session' }}
                                    </h3>
                                    @if($session->follow_up_needed)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-lg bg-yellow-50 text-yellow-600 text-xs font-medium">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Follow Up Needed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg bg-green-50 text-green-600 text-xs font-medium">
                                            Completed
                                        </span>
                                    @endif
                                </div>

                                {{-- Actions --}}
                                <div class="flex items-center gap-2 shrink-0">
                                    <a href="{{ route('student.sessions.show', $session) }}"
                                       class="p-1.5 rounded-lg text-gray-300 hover:text-blue-500 hover:bg-blue-50 transition-colors"
                                       title="View details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            {{-- Notes preview --}}
                            @if($session->session_notes)
                                <p class="text-sm text-gray-500 leading-relaxed line-clamp-2 mb-3">
                                    {{ $session->session_notes }}
                                </p>
                            @endif

                            {{-- Footer: counselor + next session --}}
                            <div class="flex flex-wrap items-center gap-4">
                                @if($counselor)
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xs font-semibold overflow-hidden shrink-0">
                                            @if($counselor->counselorProfile?->profile_picture)
                                                <img src="{{ asset('storage/' . $counselor->counselorProfile->profile_picture) }}"
                                                     alt="{{ $counselor->name }}" class="w-full h-full object-cover">
                                            @else
                                                {{ strtoupper(substr($counselor->name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <span class="text-xs text-gray-500 font-medium">{{ $counselor->name }}</span>
                                    </div>
                                @endif

                                @if($session->next_session_date)
                                    <div class="flex items-center gap-1.5 text-xs text-blue-500">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Next: {{ \Carbon\Carbon::parse($session->next_session_date)->format('M d, Y') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($sessions->hasPages())
            <div class="mt-6">
                {{ $sessions->links() }}
            </div>
        @endif
    @endif

@endsection