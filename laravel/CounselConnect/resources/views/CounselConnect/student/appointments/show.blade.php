@extends('CounselConnect.layouts.student')

@section('title', 'Appointment Details')
@section('page-title', 'Appointment Details')

@section('content')

    {{-- ── Back link ── --}}
    <div class="mb-5">
        <a href="{{ route('student.appointments.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Appointments
        </a>
    </div>

    {{-- ── Flash ── --}}
    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-100 text-green-700 text-sm px-4 py-3 rounded-xl">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- On mobile: single column stacked. On lg+: 3/5 + 2/5 side by side. --}}
    <div class="flex flex-col lg:grid lg:grid-cols-5 gap-6 items-start">

        {{-- ── Left: Main Details ── --}}
        <div class="w-full lg:col-span-3 space-y-5">

            {{-- Status + Concern Card --}}
            <section class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-6">
                <div class="flex items-start justify-between mb-5">
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-gray-900">{{ $appointment->concern_type }}</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Appointment #{{ $appointment->id }}</p>
                    </div>
                    @php
                        $statusClasses = [
                            'approved'  => 'bg-green-50 text-green-600',
                            'pending'   => 'bg-yellow-50 text-yellow-600',
                            'completed' => 'bg-blue-50 text-blue-600',
                            'cancelled' => 'bg-red-50 text-red-500',
                            'rejected'  => 'bg-red-50 text-red-500',
                        ];
                        $cls = $statusClasses[$appointment->status] ?? 'bg-gray-50 text-gray-500';
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-semibold {{ $cls }}">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <dt class="text-xs text-gray-400 font-medium mb-1">Preferred Date</dt>
                        <dd class="text-sm font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($appointment->preferred_date)->format('F d, Y') }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <dt class="text-xs text-gray-400 font-medium mb-1">Preferred Time</dt>
                        <dd class="text-sm font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($appointment->preferred_time)->format('g:i A') }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <dt class="text-xs text-gray-400 font-medium mb-1">Scheduled At</dt>
                        <dd class="text-sm font-semibold text-gray-800">
                            @if($appointment->scheduled_at)
                                {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('F d, Y · g:i A') }}
                            @else
                                <span class="text-gray-400 font-normal">Awaiting confirmation</span>
                            @endif
                        </dd>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <dt class="text-xs text-gray-400 font-medium mb-1">Submitted</dt>
                        <dd class="text-sm font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($appointment->created_at)->format('F d, Y') }}
                        </dd>
                    </div>
                </dl>

                @if($appointment->notes)
                    <div class="mt-4 bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-400 font-medium mb-1">Your Notes</p>
                        <p class="text-sm text-gray-700 leading-relaxed">{{ $appointment->notes }}</p>
                    </div>
                @endif

                @if($appointment->rejection_reason)
                    <div class="mt-4 bg-red-50 rounded-xl p-4">
                        <p class="text-xs text-red-400 font-medium mb-1">Rejection Reason</p>
                        <p class="text-sm text-red-700 leading-relaxed">{{ $appointment->rejection_reason }}</p>
                    </div>
                @endif
            </section>

            {{-- Session Record (if exists) --}}
            @if($appointment->sessionRecord)
                <section class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-6">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Session Record</h3>
                    <dl class="space-y-3">
                        @if($appointment->sessionRecord->session_notes)
                            <div>
                                <dt class="text-xs text-gray-400 font-medium mb-1">Session Notes</dt>
                                <dd class="text-sm text-gray-700 leading-relaxed bg-gray-50 rounded-xl p-4">
                                    {{ $appointment->sessionRecord->session_notes }}
                                </dd>
                            </div>
                        @endif
                        @if($appointment->sessionRecord->intervention)
                            <div>
                                <dt class="text-xs text-gray-400 font-medium mb-1">Intervention</dt>
                                <dd class="text-sm text-gray-700 bg-gray-50 rounded-xl p-4">
                                    {{ $appointment->sessionRecord->intervention }}
                                </dd>
                            </div>
                        @endif
                        @if($appointment->sessionRecord->next_session_date)
                            <div class="bg-blue-50 rounded-xl p-4">
                                <dt class="text-xs text-blue-400 font-medium mb-1">Next Session</dt>
                                <dd class="text-sm font-semibold text-blue-700">
                                    {{ \Carbon\Carbon::parse($appointment->sessionRecord->next_session_date)->format('F d, Y') }}
                                </dd>
                            </div>
                        @endif
                    </dl>
                </section>
            @endif

        </div>

        {{-- ── Right: Counselor + Actions ── --}}
        <aside class="w-full lg:col-span-2 space-y-4">

            {{-- Counselor Card --}}
            <section class="bg-white rounded-2xl border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Your Counselor</h3>

                @if($appointment->counselor)
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-lg shrink-0 overflow-hidden">
                            @if($appointment->counselor->counselorProfile?->profile_picture)
                                <img src="{{ asset('storage/' . $appointment->counselor->counselorProfile->profile_picture) }}"
                                     alt="{{ $appointment->counselor->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($appointment->counselor->name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $appointment->counselor->name }}</p>
                            <p class="text-xs text-blue-500 font-medium mt-0.5">{{ $appointment->counselor->counselorProfile?->specialization ?? 'Counselor' }}</p>
                            @if($appointment->counselor->counselorProfile?->office_location)
                                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    {{ $appointment->counselor->counselorProfile->office_location }}
                                </p>
                            @endif
                        </div>
                    </div>
                @else
                    <p class="text-sm text-gray-400">No counselor assigned yet.</p>
                @endif
            </section>

            {{-- Cancel Action --}}
            @if(in_array($appointment->status, ['pending', 'approved']))
                <section class="bg-white rounded-2xl border border-gray-100 p-5">
                    <h3 class="text-sm font-semibold text-gray-900 mb-2">Cancel Appointment</h3>
                    <p class="text-xs text-gray-400 mb-4 leading-relaxed">Once cancelled, you will need to book a new appointment. This action cannot be undone.</p>

                    <form id="cancel-appointment-form" method="POST" action="{{ route('student.appointments.destroy', $appointment) }}">
                        @csrf
                        @method('DELETE')
                    </form>

                    <button type="button" onclick="document.getElementById('cancel-modal').classList.remove('hidden')"
                            class="w-full flex items-center justify-center gap-2 bg-red-50 hover:bg-red-100 text-red-500 text-sm font-medium py-2.5 rounded-xl 
                            transition-colors cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancel Appointment
                    </button>
                </section>
            @endif

        </aside>
    </div>

    {{-- ── Cancel Confirmation Modal ── --}}
    @if(in_array($appointment->status, ['pending', 'approved']))
        <div id="cancel-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
            <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm"
                 onclick="document.getElementById('cancel-modal').classList.add('hidden')"></div>

            <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
                <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>

                <h3 class="text-base font-bold text-gray-900 text-center mb-1">Cancel Appointment?</h3>
                <p class="text-sm text-gray-500 text-center leading-relaxed mb-6">
                    This action cannot be undone. You'll need to book a new appointment if you change your mind.
                </p>

                <div class="flex gap-3">
                    <button type="button"
                            onclick="document.getElementById('cancel-modal').classList.add('hidden')"
                            class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-100 
                            transition-colors cursor-pointer">
                        Keep Appointment
                    </button>
                    <button type="button"
                            onclick="document.getElementById('cancel-appointment-form').submit()"
                            class="flex-1 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-medium 
                            transition-colors cursor-pointer">
                        Yes, Cancel
                    </button>
                </div>
            </div>
        </div>
    @endif

@endsection