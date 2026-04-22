@extends('CounselConnect.layouts.counselor')

@section('title', 'New Session Record')
@section('page-title', 'Sessions')

@section('content')

{{-- ── Exit Confirmation Modal ── --}}
<div id="exit-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" id="exit-modal-backdrop"></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 animate-in">
        <div class="flex items-start gap-4 mb-5">
            <div class="w-10 h-10 rounded-xl bg-yellow-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-gray-900">Discard unsaved changes?</h3>
                <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                    You have unsaved changes. If you leave now, your work will be lost and cannot be recovered.
                </p>
            </div>
        </div>
        <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2 sm:gap-3">
            <button id="exit-modal-stay"
                    class="w-full sm:w-auto px-4 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-100 
                    transition-colors cursor-pointer">
                Stay on page
            </button>
            <a id="exit-modal-leave" href="#"
               class="w-full sm:w-auto text-center px-4 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-medium transition-colors">
                Leave anyway
            </a>
        </div>
    </div>
</div>

{{-- ── Back Link ── --}}
<a href="{{ route('counselor.appointments.show', $appointment) }}"
   data-nav-link
   class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 mb-6 transition-colors">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    Back to Appointment
</a>

{{-- ── Grid ── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    {{-- ── Left: Appointment Summary ── --}}
    <div class="lg:col-span-1 order-2 lg:order-1">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden lg:sticky lg:top-6">

            <div class="px-5 sm:px-6 py-5 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-900">Appointment Summary</h2>
                <p class="text-xs text-gray-400 mt-0.5">This session record will be linked to the appointment below.</p>
            </div>

            <div class="px-5 sm:px-6 py-5 space-y-4">

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                        @if($appointment->student->studentProfile?->profile_picture)
                            <img src="{{ asset('storage/' . $appointment->student->studentProfile->profile_picture) }}"
                                 alt="{{ $appointment->student->name }}" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($appointment->student->name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $appointment->student->name }}</p>
                        <p class="text-xs text-gray-400">{{ $appointment->student->studentProfile?->department ?? '—' }}</p>
                    </div>
                </div>

                <div class="pt-1 space-y-3">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Concern</p>
                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                            {{ ucfirst(str_replace('_', ' ', $appointment->concern_type)) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Appointment Date</p>
                        <p class="text-sm font-medium text-gray-800">
                            {{ \Carbon\Carbon::parse($appointment->preferred_date)->format('F d, Y') }}
                        </p>
                    </div>
                    @if($appointment->scheduled_at)
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Scheduled At</p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('F d, Y — g:i A') }}
                            </p>
                        </div>
                    @endif
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Status</p>
                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                            Completed
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ── Right: Create Form ── --}}
    <div class="lg:col-span-2 order-1 lg:order-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-5 sm:px-6 py-5 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-900">New Session Record</h2>
                <p class="text-xs text-gray-400 mt-0.5">Document the session outcomes. This record is permanent and cannot be deleted.</p>
            </div>

            <form id="session-form" method="POST" action="{{ route('counselor.sessions.store') }}" class="px-4 sm:px-6 py-5 space-y-5">
                @csrf
                <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">

                {{-- Session Notes --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Session Notes <span class="text-red-400">*</span>
                    </label>
                    <textarea name="session_notes" rows="6"
                              placeholder="Describe what was discussed during the session, the student's concerns, and any observations..."
                              class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-800 resize-none
                                     focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition
                                     @error('session_notes') border-red-300 @enderror">{{ old('session_notes') }}</textarea>
                    @error('session_notes')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Intervention --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Intervention <span class="text-gray-400 font-normal">(optional)</span>
                    </label>
                    <input type="text" name="intervention" value="{{ old('intervention') }}"
                           placeholder="e.g. Cognitive Behavioral Therapy, Referral to specialist..."
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-800
                                  focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition
                                  @error('intervention') border-red-300 @enderror">
                    @error('intervention')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Follow-up Toggle --}}
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                    <div class="flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-800">Follow-up Needed</p>
                            <p class="text-xs text-gray-400 mt-0.5">Enable to set a follow-up date for the next session.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer shrink-0">
                            <input type="hidden" name="follow_up_needed" value="0">
                            <input type="checkbox" name="follow_up_needed" value="1" id="follow_up_toggle"
                                   class="sr-only peer" {{ old('follow_up_needed') ? 'checked' : '' }}>
                            <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-100
                                        rounded-full peer peer-checked:bg-blue-600 transition-colors
                                        after:content-[''] after:absolute after:top-0.5 after:left-0.5
                                        after:bg-white after:rounded-full after:h-4 after:w-4
                                        after:transition-all peer-checked:after:translate-x-5"></div>
                        </label>
                    </div>
                    <div id="next-session-field" class="{{ old('follow_up_needed') ? '' : 'hidden' }} mt-4 pt-4 border-t border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Next Session Date <span class="text-red-400">*</span>
                        </label>
                        <input type="date" name="next_session_date"
                               value="{{ old('next_session_date') }}"
                               min="{{ now()->addDay()->format('Y-m-d') }}"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-800
                                      focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition
                                      @error('next_session_date') border-red-300 @enderror">
                        @error('next_session_date')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2 sm:gap-3 pt-2">
                    <a href="{{ route('counselor.appointments.show', $appointment) }}"
                       data-nav-link
                       class="w-full sm:w-auto text-center px-4 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="w-full sm:w-auto px-5 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 
                            transition-colors cursor-pointer">
                        Save Session Record
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {

        // ── Follow-up toggle ─────────────────────────────────────
        const toggle    = document.getElementById('follow_up_toggle');
        const dateField = document.getElementById('next-session-field');
        toggle.addEventListener('change', () => {
            dateField.classList.toggle('hidden', !toggle.checked);
        });

        // ── Exit modal ───────────────────────────────────────────
        // Always warn — no dirty tracking needed on create
        let submitting = false;
        document.getElementById('session-form').addEventListener('submit', () => {
            submitting = true;
        });

        const exitModal    = document.getElementById('exit-modal');
        const leaveBtn     = document.getElementById('exit-modal-leave');
        const stayBtn      = document.getElementById('exit-modal-stay');
        const exitBackdrop = document.getElementById('exit-modal-backdrop');

        function showExitModal(destination) {
            leaveBtn.href = destination;
            exitModal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function hideExitModal() {
            exitModal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        stayBtn.addEventListener('click', hideExitModal);
        exitBackdrop.addEventListener('click', hideExitModal);

        // Intercept all nav links (back link, cancel, sidebar)
        const allNavLinks = [
            ...document.querySelectorAll('[data-nav-link]'),
            ...document.querySelectorAll('aside nav a, aside .px-4 a'),
        ];

        allNavLinks.forEach(link => {
            link.addEventListener('click', e => {
                if (submitting) return;
                e.preventDefault();
                showExitModal(link.href);
            });
        });

        // Also catch browser back/forward
        window.addEventListener('beforeunload', e => {
            if (submitting) return;
            e.preventDefault();
            e.returnValue = '';
        });
    });
</script>
@endpush