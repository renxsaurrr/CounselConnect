@extends('CounselConnect.layouts.student')

@section('title', 'Session Details')
@section('page-title', 'Sessions')

@section('content')

    {{-- ── Back link ── --}}
    <div class="mb-5">
        <a href="{{ route('student.sessions.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Sessions
        </a>
    </div>

    @php
        $appointment = $session->appointment;
        $counselor   = $appointment?->counselor;
        $date        = $appointment?->scheduled_at ?? $appointment?->preferred_date;
    @endphp

    {{-- ── Main Grid: stacks on mobile, 5-col on large screens ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-start">

        {{-- ── Left: Session Details ── --}}
        <div class="lg:col-span-3 space-y-5">

            {{-- Main session card --}}
            <section class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-6">
                <div class="flex flex-wrap items-start justify-between gap-3 mb-5">
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">
                            {{ $appointment?->concern_type ?? 'Counseling Session' }}
                        </h2>
                        <p class="text-xs text-gray-400 mt-0.5">
                            Session #{{ $session->id }} &middot;
                            {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
                        </p>
                    </div>
                    @if($session->follow_up_needed)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-semibold bg-yellow-50 text-yellow-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Follow Up Needed
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-semibold bg-green-50 text-green-600">
                            Completed
                        </span>
                    @endif
                </div>

                {{-- Session Notes --}}
                @if($session->session_notes)
                    <div class="mb-4">
                        <p class="text-xs text-gray-400 font-medium mb-1.5">Session Notes</p>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $session->session_notes }}</p>
                        </div>
                    </div>
                @endif

                {{-- Intervention --}}
                @if($session->intervention)
                    <div class="mb-4">
                        <p class="text-xs text-gray-400 font-medium mb-1.5">Intervention Used</p>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-sm text-gray-700">{{ $session->intervention }}</p>
                        </div>
                    </div>
                @endif

                {{-- Next Session Date --}}
                @if($session->next_session_date)
                    <div class="bg-blue-50 rounded-xl p-4 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-blue-400 font-medium">Next Session Scheduled</p>
                            <p class="text-sm font-semibold text-blue-700">
                                {{ \Carbon\Carbon::parse($session->next_session_date)->format('F d, Y') }}
                            </p>
                        </div>
                    </div>
                @endif
            </section>

            {{-- Related Appointment --}}
            @if($appointment)
                <section class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-6">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Related Appointment</h3>

                    {{-- Stat grid: stacked on xs, 2-col on sm+ --}}
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <dt class="text-xs text-gray-400 font-medium mb-1">Concern Type</dt>
                            <dd class="text-sm font-semibold text-gray-800">{{ $appointment->concern_type }}</dd>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <dt class="text-xs text-gray-400 font-medium mb-1">Status</dt>
                            <dd class="text-sm font-semibold text-gray-800">{{ ucfirst($appointment->status) }}</dd>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <dt class="text-xs text-gray-400 font-medium mb-1">Scheduled At</dt>
                            <dd class="text-sm font-semibold text-gray-800">
                                @if($appointment->scheduled_at)
                                    {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('M d, Y · g:i A') }}
                                @else
                                    <span class="text-gray-400 font-normal">—</span>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <dt class="text-xs text-gray-400 font-medium mb-1">Appointment #</dt>
                            <dd class="text-sm font-semibold text-gray-800">#{{ $appointment->id }}</dd>
                        </div>
                    </dl>

                    @if($appointment->notes)
                        <div class="mt-3 bg-gray-50 rounded-xl p-4">
                            <p class="text-xs text-gray-400 font-medium mb-1">Your Notes</p>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $appointment->notes }}</p>
                        </div>
                    @endif
                    <div class="mt-4">
                        <a href="{{ route('student.appointments.show', $appointment) }}"
                           class="text-xs text-blue-500 hover:text-blue-700 font-medium">
                            View full appointment details →
                        </a>
                    </div>
                </section>
            @endif

        </div>

        {{-- ── Right: Counselor ── --}}
        <aside class="lg:col-span-2 space-y-4">

            {{-- Counselor Card --}}
            <section class="bg-white rounded-2xl border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Your Counselor</h3>
                @if($counselor)
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-lg shrink-0 overflow-hidden">
                            @if($counselor->counselorProfile?->profile_picture)
                                <img src="{{ asset('storage/' . $counselor->counselorProfile->profile_picture) }}"
                                     alt="{{ $counselor->name }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($counselor->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-900">{{ $counselor->name }}</p>
                            <p class="text-xs text-blue-500 font-medium mt-0.5">{{ $counselor->counselorProfile?->specialization ?? 'Counselor' }}</p>
                            @if($counselor->counselorProfile?->office_location)
                                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $counselor->counselorProfile->office_location }}
                                </p>
                            @endif
                            @if($counselor->counselorProfile?->contact_number)
                                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    {{ $counselor->counselorProfile->contact_number }}
                                </p>
                            @endif
                        </div>
                    </div>
                @else
                    <p class="text-sm text-gray-400">No counselor assigned.</p>
                @endif
            </section>

            {{-- Session meta --}}
            <section class="bg-white rounded-2xl border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Session Info</h3>
                <dl class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <dt class="text-xs text-gray-400">Recorded</dt>
                        <dd class="text-xs font-medium text-gray-700">
                            {{ \Carbon\Carbon::parse($session->created_at)->format('M d, Y') }}
                        </dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-xs text-gray-400">Follow-up</dt>
                        <dd class="text-xs font-medium {{ $session->follow_up_needed ? 'text-yellow-600' : 'text-green-600' }}">
                            {{ $session->follow_up_needed ? 'Required' : 'Not required' }}
                        </dd>
                    </div>
                    @if($session->next_session_date)
                        <div class="flex items-center justify-between">
                            <dt class="text-xs text-gray-400">Next session</dt>
                            <dd class="text-xs font-medium text-blue-600">
                                {{ \Carbon\Carbon::parse($session->next_session_date)->format('M d, Y') }}
                            </dd>
                        </div>
                    @endif
                </dl>
            </section>

        </aside>
    </div>

@endsection