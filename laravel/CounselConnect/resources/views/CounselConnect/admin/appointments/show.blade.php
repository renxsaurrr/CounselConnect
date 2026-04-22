@extends('CounselConnect.layouts.admin')

@section('title', 'Appointment Details')
@section('page-title', 'Appointments')

@section('content')

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="{{ route('admin.appointments.index') }}" class="hover:text-blue-600 transition-colors">Appointments</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <span class="text-gray-600 font-medium">Appointment </span>
    </div>

    {{-- ── Flash Message ── --}}
    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-100 text-green-700 text-sm px-4 py-3 rounded-xl">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Layout: stacked on mobile → 3-col on lg ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- ── Left / Main Column ── --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Appointment Card --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">

                {{-- Card Header --}}
                <div class="px-5 sm:px-7 py-5 border-b border-gray-50 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div>
                        {{-- Badges --}}
                        <div class="flex items-center gap-2 mb-3 flex-wrap">
                            @php
                                $concernStyle = match($appointment->concern_type) {
                                    'Mental Health' => 'bg-purple-50 text-purple-700',
                                    'Academic'      => 'bg-blue-50 text-blue-700',
                                    'Career'        => 'bg-orange-50 text-orange-700',
                                    'Personal'      => 'bg-pink-50 text-pink-700',
                                    default         => 'bg-gray-100 text-gray-600',
                                };
                                $statusStyle = match($appointment->status) {
                                    'pending'   => 'bg-yellow-50 text-yellow-700',
                                    'approved'  => 'bg-green-50 text-green-700',
                                    'completed' => 'bg-blue-50 text-blue-700',
                                    'cancelled' => 'bg-red-50 text-red-500',
                                    'rejected'  => 'bg-gray-100 text-gray-500',
                                    default     => 'bg-gray-100 text-gray-500',
                                };
                            @endphp
                            <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $concernStyle }}">
                                {{ $appointment->concern_type }}
                            </span>
                            <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold uppercase tracking-wide {{ $statusStyle }}">
                                {{ $appointment->status }}
                            </span>
                        </div>

                        <h2 class="text-xl font-bold text-gray-900 leading-snug">Counseling Appointment</h2>
                        <p class="text-xs text-gray-400 mt-1">Requested {{ $appointment->created_at->format('F d, Y \a\t g:i A') }}</p>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center gap-2 flex-wrap shrink-0">
                        @if($appointment->status === 'pending')
                            <button type="button" onclick="openApproveModal()"
                                    class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl
                                 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold 
                                 transition-colors cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Approve
                            </button>
                            <button type="button" onclick="openRejectModal()"
                                    class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-gray-200
                             text-gray-400 hover:bg-red-50 hover:text-red-500 hover:border-red-200 text-xs
                              font-semibold transition-colors cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Reject
                            </button>
                        @elseif($appointment->status === 'approved')
                            <button type="button" onclick="openCompleteModal()"
                                    class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold 
                                    transition-colors cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                                </svg>
                                Mark Completed
                            </button>
                            <button type="button" onclick="openCancelModal()"
                                    class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-gray-200 text-gray-400 hover:bg-red-50 hover:text-red-500
                                     hover:border-red-200 text-xs font-semibold transition-colors cursor-pointer">
                                Cancel Appointment
                            </button>
                        @endif
                    </div>

                    {{-- Hidden forms (submitted by modals) --}}
                    <form id="form-approve" method="POST" action="{{ route('admin.appointments.approve', $appointment) }}" class="hidden">
                        @csrf @method('PATCH')
                    </form>
                    <form id="form-complete" method="POST" action="{{ route('admin.appointments.complete', $appointment) }}" class="hidden">
                        @csrf @method('PATCH')
                    </form>
                    <form id="form-cancel" method="POST" action="{{ route('admin.appointments.cancel', $appointment) }}" class="hidden">
                        @csrf @method('PATCH')
                    </form>
                </div>

                {{-- Info Grid: 1 col mobile → 2 col sm+ --}}
                <div class="px-5 sm:px-7 py-5 grid grid-cols-1 sm:grid-cols-2 gap-5">

                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Preferred Date</p>
                        <p class="text-sm font-semibold text-gray-800">{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('F d, Y') }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Preferred Time</p>
                        <p class="text-sm font-semibold text-gray-800">{{ \Carbon\Carbon::parse($appointment->preferred_time)->format('g:i A') }}</p>
                    </div>

                    @if($appointment->scheduled_at)
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Scheduled At</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $appointment->scheduled_at->format('F d, Y \a\t g:i A') }}</p>
                        </div>
                    @endif

                    @if($appointment->rejection_reason)
                        <div class="col-span-full">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Rejection Reason</p>
                            <p class="text-sm text-red-600 bg-red-50 px-3 py-2 rounded-xl">{{ $appointment->rejection_reason }}</p>
                        </div>
                    @endif

                    @if($appointment->notes)
                        <div class="col-span-full">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Student Notes</p>
                            <p class="text-sm text-gray-700 bg-gray-50 px-4 py-3 rounded-xl leading-relaxed">{{ $appointment->notes }}</p>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Session Record (if exists) --}}
            @if($appointment->sessionRecord)
                <div class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-6">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <h3 class="text-sm font-semibold text-gray-900">Session Record</h3>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Session Notes</p>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $appointment->sessionRecord->session_notes }}</p>
                        </div>
                        @if($appointment->sessionRecord->intervention)
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Intervention</p>
                                <p class="text-sm text-gray-700">{{ $appointment->sessionRecord->intervention }}</p>
                            </div>
                        @endif
                        <div class="flex flex-wrap items-center gap-4 pt-1">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full {{ $appointment->sessionRecord->follow_up_needed ? 'bg-yellow-400' : 'bg-gray-200' }}"></span>
                                <span class="text-xs text-gray-500">Follow-up {{ $appointment->sessionRecord->follow_up_needed ? 'required' : 'not required' }}</span>
                            </div>
                            @if($appointment->sessionRecord->next_session_date)
                                <span class="text-xs text-gray-500">Next: {{ \Carbon\Carbon::parse($appointment->sessionRecord->next_session_date)->format('M d, Y') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

        </div>

        {{-- ── Right Column: Parties ── --}}
        <div class="space-y-4">

            {{-- Student Card --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Student</p>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-bold shrink-0">
                        {{ strtoupper(substr($appointment->student?->name ?? 'S', 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $appointment->student?->name ?? '—' }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $appointment->student?->email ?? '—' }}</p>
                    </div>
                </div>
                @if($appointment->student?->studentProfile)
                    <div class="space-y-2 border-t border-gray-50 pt-3">
                        <div class="flex justify-between gap-2">
                            <span class="text-xs text-gray-400">Student ID</span>
                            <span class="text-xs font-medium text-gray-700">{{ $appointment->student->studentProfile->student_id ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between gap-2">
                            <span class="text-xs text-gray-400">Department</span>
                            <span class="text-xs font-medium text-gray-700 text-right">{{ $appointment->student->studentProfile->department ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between gap-2">
                            <span class="text-xs text-gray-400">Year Level</span>
                            <span class="text-xs font-medium text-gray-700">{{ $appointment->student->studentProfile->year_level ?? '—' }}</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Counselor Card --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Assigned Counselor</p>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold shrink-0">
                        {{ strtoupper(substr($appointment->counselor?->name ?? 'C', 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $appointment->counselor?->name ?? '—' }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $appointment->counselor?->email ?? '—' }}</p>
                    </div>
                </div>
                @if($appointment->counselor?->counselorProfile)
                    <div class="space-y-2 border-t border-gray-50 pt-3">
                        <div class="flex justify-between gap-2">
                            <span class="text-xs text-gray-400">Specialization</span>
                            <span class="text-xs font-medium text-gray-700 text-right">{{ $appointment->counselor->counselorProfile->specialization ?? '—' }}</span>
                        </div>
                        <div class="flex justify-between gap-2">
                            <span class="text-xs text-gray-400">Office</span>
                            <span class="text-xs font-medium text-gray-700 text-right">{{ $appointment->counselor->counselorProfile->office_location ?? '—' }}</span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Schedule Card --}}
            @if($appointment->schedule)
                <div class="bg-white rounded-2xl border border-gray-100 p-5">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Schedule Slot</p>
                    <div class="space-y-2">
                        <div class="flex justify-between gap-2">
                            <span class="text-xs text-gray-400">Day</span>
                            <span class="text-xs font-medium text-gray-700">{{ $appointment->schedule->day_of_week }}</span>
                        </div>
                        <div class="flex justify-between gap-2">
                            <span class="text-xs text-gray-400">Start Time</span>
                            <span class="text-xs font-medium text-gray-700">{{ \Carbon\Carbon::parse($appointment->schedule->start_time)->format('g:i A') }}</span>
                        </div>
                        <div class="flex justify-between gap-2">
                            <span class="text-xs text-gray-400">End Time</span>
                            <span class="text-xs font-medium text-gray-700">{{ \Carbon\Carbon::parse($appointment->schedule->end_time)->format('g:i A') }}</span>
                        </div>
                        <div class="flex justify-between gap-2">
                            <span class="text-xs text-gray-400">Slot Duration</span>
                            <span class="text-xs font-medium text-gray-700">{{ $appointment->schedule->slot_duration_mins }} mins</span>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- ── Back Link ── --}}
    <div class="mt-5">
        <a href="{{ route('admin.appointments.index') }}"
           class="flex items-center gap-2 text-sm text-gray-400 hover:text-gray-600 transition-colors w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Back to Appointments
        </a>
    </div>

    {{-- ── Approve Modal ── --}}
    <div id="approveBackdrop" class="fixed inset-0 z-50 hidden opacity-0 transition-opacity duration-200 bg-black/40 flex items-center justify-center p-4"
         onclick="if(event.target===this) closeApproveModal()">
        <div id="approveModal" class="bg-white rounded-2xl border border-gray-100 shadow-xl w-full max-w-sm scale-95 transition-transform duration-200">
            <div class="p-6 text-center">
                <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-900">Approve Appointment?</h3>
                <p class="text-sm text-gray-500 mt-1.5">This will notify the student and counselor that the appointment has been approved.</p>
            </div>
            <div class="flex gap-3 px-6 pb-6">
                <button type="button" onclick="closeApproveModal()"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors cursor-pointer">
                    Cancel
                </button>
                <button type="button" onclick="document.getElementById('form-approve').submit()"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-green-600 hover:bg-green-700 text-white text-sm font-semibold transition-colors cursor-pointer">
                    Yes, Approve
                </button>
            </div>
        </div>
    </div>

    {{-- ── Mark Completed Modal ── --}}
    <div id="completeBackdrop" class="fixed inset-0 z-50 hidden opacity-0 transition-opacity duration-200 bg-black/40 flex items-center justify-center p-4"
         onclick="if(event.target===this) closeCompleteModal()">
        <div id="completeModal" class="bg-white rounded-2xl border border-gray-100 shadow-xl w-full max-w-sm scale-95 transition-transform duration-200">
            <div class="p-6 text-center">
                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-900">Mark as Completed?</h3>
                <p class="text-sm text-gray-500 mt-1.5">This will mark the appointment as completed. This action cannot be undone.</p>
            </div>
            <div class="flex gap-3 px-6 pb-6">
                <button type="button" onclick="closeCompleteModal()"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors cursor-pointer">
                    Cancel
                </button>
                <button type="button" onclick="document.getElementById('form-complete').submit()"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition-colors cursor-pointer">
                    Yes, Complete
                </button>
            </div>
        </div>
    </div>

    {{-- ── Cancel Appointment Modal ── --}}
    <div id="cancelBackdrop" class="fixed inset-0 z-50 hidden opacity-0 transition-opacity duration-200 bg-black/40 flex items-center justify-center p-4"
         onclick="if(event.target===this) closeCancelModal()">
        <div id="cancelModal" class="bg-white rounded-2xl border border-gray-100 shadow-xl w-full max-w-sm scale-95 transition-transform duration-200">
            <div class="p-6 text-center">
                <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-900">Cancel Appointment?</h3>
                <p class="text-sm text-gray-500 mt-1.5">This will cancel the appointment. The student and counselor will be notified.</p>
            </div>
            <div class="flex gap-3 px-6 pb-6">
                <button type="button" onclick="closeCancelModal()"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors cursor-pointer">
                    Go Back
                </button>
                <button type="button" onclick="document.getElementById('form-cancel').submit()"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition-colors cursor-pointer">
                    Yes, Cancel
                </button>
            </div>
        </div>
    </div>

    {{-- ── Reject Modal ── --}}
    <div id="rejectBackdrop" class="fixed inset-0 z-50 hidden opacity-0 transition-opacity duration-200 bg-black/40 flex items-center justify-center p-4">
        <div id="rejectModal" class="bg-white rounded-2xl border border-gray-100 shadow-xl w-full max-w-md scale-95 transition-transform duration-200">
            <div class="px-6 py-5 border-b border-gray-50">
                <h3 class="text-base font-semibold text-gray-900">Reject Appointment</h3>
                <p class="text-sm text-gray-400 mt-0.5">Please provide a reason so the student is informed.</p>
            </div>
            <form method="POST" action="{{ route('admin.appointments.reject', $appointment) }}">
                @csrf @method('PATCH')
                <div class="px-6 py-5">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Rejection Reason</label>
                    <textarea name="rejection_reason" rows="4" required
                              placeholder="e.g. Counselor unavailable on requested date. Please reschedule."
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition resize-none"></textarea>
                </div>
                <div class="px-6 py-4 border-t border-gray-50 flex items-center gap-3">
                    <button type="submit"
                            class="flex-1 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-semibold transition-colors">
                        Confirm Rejection
                    </button>
                    <button type="button" onclick="closeRejectModal()"
                            class="px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // ── Generic modal helpers ────────────────────────────────────
    function openModal(backdropId, modalId) {
        const backdrop = document.getElementById(backdropId);
        const modal    = document.getElementById(modalId);
        backdrop.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            modal.classList.remove('scale-95');
        });
    }
    function closeModal(backdropId, modalId) {
        const backdrop = document.getElementById(backdropId);
        const modal    = document.getElementById(modalId);
        backdrop.classList.add('opacity-0');
        modal.classList.add('scale-95');
        setTimeout(() => backdrop.classList.add('hidden'), 200);
    }

    // ── Approve ──────────────────────────────────────────────────
    function openApproveModal()  { openModal('approveBackdrop',  'approveModal');  }
    function closeApproveModal() { closeModal('approveBackdrop', 'approveModal');  }

    // ── Complete ─────────────────────────────────────────────────
    function openCompleteModal()  { openModal('completeBackdrop',  'completeModal');  }
    function closeCompleteModal() { closeModal('completeBackdrop', 'completeModal');  }

    // ── Cancel appointment ────────────────────────────────────────
    function openCancelModal()  { openModal('cancelBackdrop',  'cancelModal');  }
    function closeCancelModal() { closeModal('cancelBackdrop', 'cancelModal');  }

    // ── Reject ───────────────────────────────────────────────────
    const rejectBackdrop = document.getElementById('rejectBackdrop');
    const rejectModal    = document.getElementById('rejectModal');

    function openRejectModal()  { openModal('rejectBackdrop',  'rejectModal');  }
    function closeRejectModal() { closeModal('rejectBackdrop', 'rejectModal');  }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeApproveModal();
            closeCompleteModal();
            closeCancelModal();
            closeRejectModal();
        }
    });
</script>
@endpush