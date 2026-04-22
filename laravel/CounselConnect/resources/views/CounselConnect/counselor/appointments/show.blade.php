@extends('CounselConnect.layouts.counselor')

@section('title', 'Appointment Details')
@section('page-title', 'Appointments')

@section('content')

{{-- ── Back Link ── --}}
<a href="{{ route('counselor.appointments.index') }}"
   class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 mb-6 transition-colors">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    Back to Appointments
</a>

{{-- ── Flash Message ── --}}
@if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-xl bg-green-50 border border-green-100 text-green-700 text-sm">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

{{-- ── Validation Errors ── --}}
@if($errors->any())
    <div class="mb-5 px-4 py-3 rounded-xl bg-red-50 border border-red-100 text-red-700 text-sm space-y-1">
        @foreach($errors->all() as $error)
            <p class="flex items-center gap-2">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                </svg>
                {{ $error }}
            </p>
        @endforeach
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Left Column: Student Info + Appointment Details ── --}}
    <div class="lg:col-span-1 space-y-5">

        {{-- Student Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-900">Student</h2>
            </div>
            <div class="px-5 py-4 flex items-start gap-4">
                <div class="w-12 h-12 rounded-full bg-blue-600 flex items-center justify-center text-white text-base font-semibold shrink-0 overflow-hidden">
                    @if($appointment->student->studentProfile?->profile_picture)
                        <img src="{{ asset('storage/' . $appointment->student->studentProfile->profile_picture) }}"
                             alt="{{ $appointment->student->name }}"
                             class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($appointment->student->name, 0, 1)) }}
                    @endif
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-gray-900 break-words">{{ $appointment->student->name }}</p>
                    <p class="text-xs text-gray-400 mt-0.5 break-all">{{ $appointment->student->email }}</p>
                    @if($appointment->student->studentProfile)
                        <div class="mt-3 space-y-1.5">
                            @if($appointment->student->studentProfile->department)
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <span class="text-xs text-gray-600">{{ $appointment->student->studentProfile->department }}</span>
                                </div>
                            @endif
                            @if($appointment->student->studentProfile->year_level)
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <span class="text-xs text-gray-600">{{ $appointment->student->studentProfile->year_level }}</span>
                                </div>
                            @endif
                            @if($appointment->student->studentProfile->student_id)
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/>
                                    </svg>
                                    <span class="text-xs text-gray-600">ID: {{ $appointment->student->studentProfile->student_id }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            <div class="px-5 pb-4">
                <a href="{{ route('counselor.students.show', $appointment->student) }}"
                   class="flex items-center justify-center gap-2 w-full px-4 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors">
                    View Student Profile
                </a>
            </div>
        </div>

        {{-- Appointment Info Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-900">Appointment Details</h2>
            </div>
            <div class="px-5 py-4 space-y-4">

                {{-- Status --}}
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Status</p>
                    @php
                        $statusColors = [
                            'pending'   => 'bg-amber-50 text-amber-700',
                            'approved'  => 'bg-blue-50 text-blue-700',
                            'completed' => 'bg-green-50 text-green-700',
                            'rejected'  => 'bg-red-50 text-red-500',
                            'cancelled' => 'bg-gray-100 text-gray-500',
                        ];
                    @endphp
                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium
                                 {{ $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-500' }}">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>

                {{-- Concern Type --}}
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Concern Type</p>
                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                        {{ ucfirst(str_replace('_', ' ', $appointment->concern_type)) }}
                    </span>
                </div>

                {{-- Preferred Date --}}
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Student's Preferred Date</p>
                    <p class="text-sm font-medium text-gray-800">
                        {{ \Carbon\Carbon::parse($appointment->preferred_date)->format('l, F d, Y') }}
                    </p>
                </div>

                {{-- Preferred Time --}}
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Student's Preferred Time</p>
                    <p class="text-sm font-medium text-gray-800">
                        {{ \Carbon\Carbon::parse($appointment->preferred_time)->format('g:i A') }}
                    </p>
                </div>

                {{-- Confirmed Schedule (if approved) --}}
                @if($appointment->scheduled_at)
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Confirmed Schedule</p>
                        <p class="text-sm font-medium text-gray-800">
                            {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('F d, Y — g:i A') }}
                        </p>
                    </div>
                @endif

                {{-- Schedule Slot --}}
                @if($appointment->schedule)
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Schedule Slot</p>
                        <p class="text-sm font-medium text-gray-800">
                            {{ $appointment->schedule->day_of_week }},
                            {{ \Carbon\Carbon::parse($appointment->schedule->start_time)->format('g:i A') }}–{{ \Carbon\Carbon::parse($appointment->schedule->end_time)->format('g:i A') }}
                        </p>
                    </div>
                @endif

                {{-- Submitted --}}
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Submitted</p>
                    <p class="text-sm text-gray-600">{{ $appointment->created_at->format('M d, Y — g:i A') }}</p>
                </div>

                {{-- Rejection Reason --}}
                @if($appointment->rejection_reason)
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Rejection Reason</p>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $appointment->rejection_reason }}</p>
                    </div>
                @endif

            </div>
        </div>

    </div>

    {{-- ── Right Column: Notes + Actions + Session Record ── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Student Notes --}}
        @if($appointment->notes)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-900">Student's Notes</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Message provided when booking</p>
                </div>
                <div class="px-5 py-4">
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $appointment->notes }}</p>
                </div>
            </div>
        @endif

        {{-- ── Approve / Reject Action Cards ── --}}
        @if($appointment->isPending())
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 items-start">

                {{-- ════ APPROVE CARD ════ --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-900">Approve Appointment</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Confirm or reschedule the session.</p>
                    </div>
                    <div class="px-5 py-4 space-y-3">

                        {{-- ── Option 1: Accept as Requested ── --}}
                        @if($canAcceptAsRequested)
                            <div class="rounded-xl border border-green-200 bg-green-50 p-4">
                                <div class="flex items-start gap-3 mb-3">
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-green-800">Accept as Requested</p>
                                        <p class="text-xs text-green-700 mt-0.5">
                                            {{ \Carbon\Carbon::parse($appointment->preferred_date)->format('l, M d, Y') }}
                                            at {{ \Carbon\Carbon::parse($appointment->preferred_time)->format('g:i A') }}
                                        </p>
                                        <p class="text-xs text-green-500 mt-1">Aligns with your schedule slot</p>
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('counselor.appointments.approve', $appointment) }}">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="mode" value="accept">
                                    <button type="submit"
                                            class="w-full px-4 py-2.5 rounded-xl bg-green-600 text-white text-sm font-semibold hover:bg-green-700 transition-colors cursor-pointer">
                                        Confirm This Schedule
                                    </button>
                                </form>
                            </div>
                        @else
                            {{-- Preferred time is outside the counselor's slots — notice --}}
                            <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 flex items-start gap-3">
                                <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                                </svg>
                                <div>
                                    <p class="text-xs font-semibold text-amber-800">Student's preferred time is outside your slots</p>
                                    <p class="text-xs text-amber-600 mt-0.5">
                                        Requested: {{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }}
                                        at {{ \Carbon\Carbon::parse($appointment->preferred_time)->format('g:i A') }}.
                                        Please propose an available time below.
                                    </p>
                                </div>
                            </div>
                        @endif

                        {{-- ── Option 2: Propose a Different Time ── --}}

                        {{-- Toggle button — only shown when accept-as-requested is available --}}
                        @if($canAcceptAsRequested)
                            <button type="button"
                                    id="propose-toggle"
                                    onclick="togglePropose()"
                                    class="w-full flex items-center justify-between px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-600 font-medium hover:bg-gray-50 transition-colors cursor-pointer">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Propose a Different Time
                                </span>
                                <svg id="propose-chevron"
                                     class="w-4 h-4 transition-transform duration-200"
                                     style="transition: transform 0.2s;"
                                     fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        @endif

                        {{-- Propose panel — hidden by default if accept-as-requested is available --}}
                        <div id="propose-panel" class="{{ $canAcceptAsRequested ? 'hidden' : '' }}">
                            <form method="POST"
                                  action="{{ route('counselor.appointments.approve', $appointment) }}"
                                  id="propose-form"
                                  class="rounded-xl border border-gray-200 p-4 space-y-4">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="mode" value="propose">

                                {{-- Step 1: Pick a slot --}}
                                @if($scheduleSlots->isNotEmpty())
                                    <div>
                                        <p class="text-xs font-medium text-gray-700 mb-2">
                                            Step 1 — Select one of your available slots
                                        </p>
                                        <div class="space-y-1.5">
                                            @foreach($scheduleSlots as $slot)
                                                <button type="button"
                                                        class="slot-btn w-full flex items-center justify-between px-3 py-2 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:border-gray-300 hover:bg-gray-50 transition-colors cursor-pointer text-left"
                                                        data-day="{{ $slot->day_of_week }}"
                                                        data-start="{{ $slot->start_time }}"
                                                        data-end="{{ $slot->end_time }}"
                                                        data-duration="{{ $slot->slot_duration_mins }}"
                                                        onclick="selectSlot(this)">
                                                    <span>{{ $slot->day_of_week }}s</span>
                                                    <span>
                                                        {{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }}
                                                        –
                                                        {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}
                                                    </span>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- Step 2: Pick a date --}}
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                        Step 2 — Proposed Date
                                        <span id="day-hint" class="text-gray-400 font-normal"></span>
                                    </label>
                                    <input type="date"
                                           name="proposed_date"
                                           id="proposed-date"
                                           disabled
                                           min="{{ date('Y-m-d') }}"
                                           value="{{ old('proposed_date') }}"
                                           onchange="validateDay()"
                                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-800
                                                  focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition
                                                  disabled:opacity-40 disabled:cursor-not-allowed">
                                    <p id="day-mismatch-msg" class="text-xs text-red-500 mt-1 hidden"></p>
                                    @error('proposed_date')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Step 3: Pick a time --}}
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1.5">
                                        Step 3 — Proposed Time
                                    </label>
                                    <select name="proposed_time"
                                            id="proposed-time"
                                            disabled
                                            onchange="updateSubmitBtn()"
                                            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-800
                                                   focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition
                                                   disabled:opacity-40 disabled:cursor-not-allowed">
                                        <option value="">Select a time...</option>
                                    </select>
                                    @error('proposed_time')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="button"
                                        id="propose-submit"
                                        disabled
                                        onclick="document.getElementById('propose-form').submit()"
                                        class="w-full px-4 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-semibold
                                               hover:bg-blue-700 transition-colors cursor-pointer
                                               disabled:opacity-40 disabled:cursor-not-allowed">
                                    Approve with Proposed Time
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

                {{-- ════ REJECT CARD ════ --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-900">Reject Appointment</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Provide a reason for the student.</p>
                    </div>
                    <form id="reject-form" method="POST"
                          action="{{ route('counselor.appointments.reject', $appointment) }}"
                          class="px-5 py-4 space-y-4">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Rejection Reason</label>
                            <textarea name="rejection_reason" rows="4"
                                      placeholder="Explain why this appointment is being declined..."
                                      class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-800 resize-none
                                             focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">{{ old('rejection_reason') }}</textarea>
                            @error('rejection_reason')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="button"
                                onclick="document.getElementById('modal-reject').classList.remove('hidden')"
                                class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl border border-red-200 text-red-600 text-sm font-medium hover:bg-red-50 transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reject Appointment
                        </button>
                    </form>
                </div>

            </div>
        @endif

        {{-- ── Mark as Completed ── --}}
        @if($appointment->isApproved())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">Mark as Completed</h3>
                            <p class="text-xs text-gray-400 mt-0.5">
                                Once completed, you'll be redirected to create a session record.
                            </p>
                        </div>
                        @if($appointment->scheduled_at)
                            <span class="text-xs text-gray-500 shrink-0">
                                Scheduled: {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('M d, Y — g:i A') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="px-5 py-4">
                    <form id="complete-form" method="POST" action="{{ route('counselor.appointments.complete', $appointment) }}">
                        @csrf
                        @method('PATCH')
                        <button type="button"
                                onclick="document.getElementById('modal-complete').classList.remove('hidden')"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-green-600 text-white text-sm font-medium hover:bg-green-700 transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Mark as Completed & Add Session Notes
                        </button>
                    </form>
                </div>
            </div>
        @endif

        {{-- ── Session Record ── --}}
        @if($appointment->sessionRecord)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <h3 class="text-sm font-semibold text-gray-900">Session Record</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Notes recorded after the session</p>
                    </div>
                    <a href="{{ route('counselor.sessions.show', $appointment->sessionRecord) }}"
                       class="text-xs text-blue-600 font-medium hover:underline shrink-0">
                        View full record →
                    </a>
                </div>
                <div class="px-5 py-4 space-y-4">

                    @if($appointment->sessionRecord->session_notes)
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1.5">Session Notes</p>
                            <p class="text-sm text-gray-700 leading-relaxed">
                                {{ \Illuminate\Support\Str::limit($appointment->sessionRecord->session_notes, 300) }}
                            </p>
                        </div>
                    @endif

                    @if($appointment->sessionRecord->intervention)
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1.5">Intervention</p>
                            <p class="text-sm text-gray-700">{{ $appointment->sessionRecord->intervention }}</p>
                        </div>
                    @endif

                    <div class="flex flex-wrap items-start gap-x-6 gap-y-3">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Follow-up Needed</p>
                            @if($appointment->sessionRecord->follow_up_needed)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>Yes
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>No
                                </span>
                            @endif
                        </div>
                        @if($appointment->sessionRecord->next_session_date)
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Next Session</p>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ \Carbon\Carbon::parse($appointment->sessionRecord->next_session_date)->format('M d, Y') }}
                                </p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        @endif

        {{-- No session record for closed appointments --}}
        @if(in_array($appointment->status, ['completed', 'rejected', 'cancelled']) && !$appointment->sessionRecord)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-8 text-center">
                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-sm text-gray-500">No session record for this appointment.</p>
            </div>
        @endif

    </div>

</div>

{{-- ══ Modal: Mark as Completed ══ --}}
<div id="modal-complete"
     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
     onclick="if(event.target===this) this.classList.add('hidden')">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 z-10">
        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-green-50 mx-auto mb-4">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h3 class="text-base font-semibold text-gray-900 text-center">Mark as Completed?</h3>
        <p class="text-sm text-gray-500 text-center mt-1.5">
            This will mark the appointment as completed and redirect you to add session notes.
        </p>
        <div class="flex gap-3 mt-6">
            <button type="button"
                    onclick="document.getElementById('modal-complete').classList.add('hidden')"
                    class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors cursor-pointer">
                Cancel
            </button>
            <button type="button"
                    onclick="document.getElementById('complete-form').submit()"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-green-600 text-white text-sm font-medium hover:bg-green-700 transition-colors cursor-pointer">
                Yes, Complete
            </button>
        </div>
    </div>
</div>

{{-- ══ Modal: Reject Appointment ══ --}}
<div id="modal-reject"
     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
     onclick="if(event.target===this) this.classList.add('hidden')">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 z-10">
        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-50 mx-auto mb-4">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>
        <h3 class="text-base font-semibold text-gray-900 text-center">Reject this Appointment?</h3>
        <p class="text-sm text-gray-500 text-center mt-1.5">
            The student will be notified of the rejection along with your provided reason.
        </p>
        <div class="flex gap-3 mt-6">
            <button type="button"
                    onclick="document.getElementById('modal-reject').classList.add('hidden')"
                    class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">
                Cancel
            </button>
            <button type="button"
                    onclick="document.getElementById('reject-form').submit()"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-red-600 text-white text-sm font-medium hover:bg-red-700 transition-colors cursor-pointer">
                Yes, Reject
            </button>
        </div>
    </div>
</div>

{{-- ══ Vanilla JS: Propose a Different Time slot picker ══ --}}
<script>
    // ── Shared state ─────────────────────────────────────────────
    var selectedDay      = '';
    var selectedStart    = '';
    var selectedEnd      = '';
    var selectedDuration = 30;

    // ── Toggle the propose panel open / closed ───────────────────
    function togglePropose() {
        var panel   = document.getElementById('propose-panel');
        var chevron = document.getElementById('propose-chevron');

        if (panel.classList.contains('hidden')) {
            panel.classList.remove('hidden');
            chevron.style.transform = 'rotate(180deg)';
        } else {
            panel.classList.add('hidden');
            chevron.style.transform = '';
        }
    }

    // ── Called when a slot button is clicked ─────────────────────
    function selectSlot(btn) {
        selectedDay      = btn.dataset.day;
        selectedStart    = btn.dataset.start;
        selectedEnd      = btn.dataset.end;
        selectedDuration = parseInt(btn.dataset.duration) || 30;

        // Highlight selected slot, clear others
        document.querySelectorAll('.slot-btn').forEach(function(b) {
            b.classList.remove('border-blue-400', 'bg-blue-50', 'text-blue-700');
            b.classList.add('border-gray-200', 'text-gray-600');
        });
        btn.classList.remove('border-gray-200', 'text-gray-600');
        btn.classList.add('border-blue-400', 'bg-blue-50', 'text-blue-700');

        // Show the day constraint hint
        document.getElementById('day-hint').textContent = '(must be a ' + selectedDay + ')';

        // Enable date picker and reset it
        var dateInput = document.getElementById('proposed-date');
        dateInput.disabled = false;
        dateInput.value    = '';

        // Hide mismatch message
        var mismatchMsg = document.getElementById('day-mismatch-msg');
        mismatchMsg.classList.add('hidden');
        mismatchMsg.textContent = '';

        // Reset time select
        resetTimeSelect();
        updateSubmitBtn();
    }

    // ── Validate picked date is the right day-of-week ────────────
    function validateDay() {
        var dateInput = document.getElementById('proposed-date');
        var val = dateInput.value;
        if (!val || !selectedDay) return;

        var dayNames = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        var picked   = new Date(val + 'T00:00:00');
        var pickedDay = dayNames[picked.getDay()];

        var mismatchMsg = document.getElementById('day-mismatch-msg');

        if (pickedDay.toLowerCase() !== selectedDay.toLowerCase()) {
            mismatchMsg.textContent = "That's a " + pickedDay + ". Please pick a " + selectedDay + ".";
            mismatchMsg.classList.remove('hidden');
            dateInput.value = '';
            resetTimeSelect();
        } else {
            mismatchMsg.classList.add('hidden');
            mismatchMsg.textContent = '';
            buildTimeSelect(selectedStart, selectedEnd, selectedDuration);
        }

        updateSubmitBtn();
    }

    // ── Build time options from slot start → end ─────────────────
    function buildTimeSelect(start, end, step) {
        step = (step > 0) ? step : 30;

        var select = document.getElementById('proposed-time');
        select.innerHTML = '<option value="">Select a time...</option>';
        select.disabled  = false;

        function toMins(t) {
            var parts = t.split(':');
            return parseInt(parts[0]) * 60 + parseInt(parts[1]);
        }

        function fmt(mins) {
            var h    = Math.floor(mins / 60);
            var m    = mins % 60;
            var ampm = h >= 12 ? 'PM' : 'AM';
            var h12  = h % 12 || 12;
            return {
                value: String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0'),
                label: h12 + ':' + String(m).padStart(2, '0') + ' ' + ampm
            };
        }

        var cur     = toMins(start);
        var endMins = toMins(end);

        while (cur < endMins) {
            var t   = fmt(cur);
            var opt = document.createElement('option');
            opt.value       = t.value;
            opt.textContent = t.label;
            select.appendChild(opt);
            cur += step;
        }

        // Restore old value after a validation redirect
        var oldTime = '{{ old('proposed_time') }}';
        if (oldTime) select.value = oldTime;

        updateSubmitBtn();
    }

    // ── Reset and disable the time dropdown ──────────────────────
    function resetTimeSelect() {
        var select = document.getElementById('proposed-time');
        select.innerHTML = '<option value="">Select a time...</option>';
        select.disabled  = true;
    }

    // ── Enable submit only when date + time are both set ─────────
    function updateSubmitBtn() {
        var date     = document.getElementById('proposed-date').value;
        var time     = document.getElementById('proposed-time').value;
        var mismatch = !document.getElementById('day-mismatch-msg').classList.contains('hidden');
        var btn      = document.getElementById('propose-submit');
        if (btn) btn.disabled = !(date && time && !mismatch);
    }

    // ── On page load: restore panel if there were validation errors ─
    document.addEventListener('DOMContentLoaded', function() {
        var oldDate = '{{ old('proposed_date') }}';
        var oldTime = '{{ old('proposed_time') }}';

        if (oldDate || oldTime) {
            var panel = document.getElementById('propose-panel');
            if (panel) panel.classList.remove('hidden');
            var chevron = document.getElementById('propose-chevron');
            if (chevron) chevron.style.transform = 'rotate(180deg)';
        }
    });
</script>

@endsection