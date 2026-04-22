@extends('CounselConnect.layouts.counselor')

@section('title', 'Edit Session Record')
@section('page-title', 'Sessions')

@section('content')

{{-- ── Exit Confirmation Modal ── --}}
<div id="exit-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" id="exit-modal-backdrop"></div>

    {{-- Dialog --}}
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6">
        <div class="flex items-start gap-4 mb-5">
            <div class="w-10 h-10 rounded-xl bg-yellow-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-gray-900">Discard unsaved changes?</h3>
                <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                    You have unsaved changes. If you leave now, your edits will be lost and cannot be recovered.
                </p>
            </div>
        </div>
        <div class="flex items-center justify-end gap-3">
            <button id="exit-modal-stay"
                    class="px-4 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-100
                     transition-colors cursor-pointer">
                Stay on page
            </button>
            <a id="exit-modal-leave" href="#"
               class="px-4 py-2 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-medium transition-colors">
                Leave anyway
            </a>
        </div>
    </div>
</div>

{{-- ── Back Link ── --}}
<a href="{{ route('counselor.sessions.show', $sessionRecord) }}"
   data-nav-link
   class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 mb-6 transition-colors">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    Back to Record
</a>

{{-- ── Responsive Grid: stacks on mobile, 3-col on lg ── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Left: Context Summary ── --}}
    <div class="lg:col-span-1 order-2 lg:order-1">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden lg:sticky lg:top-6">

            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-900">Record Context</h2>
                <p class="text-xs text-gray-400 mt-0.5">Session records are permanent — edits are logged.</p>
            </div>

            <div class="px-6 py-5 space-y-4">

                {{-- Student --}}
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                        @if($sessionRecord->student->studentProfile?->profile_picture)
                            <img src="{{ asset('storage/' . $sessionRecord->student->studentProfile->profile_picture) }}"
                                 alt="{{ $sessionRecord->student->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($sessionRecord->student->name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $sessionRecord->student->name }}</p>
                        <p class="text-xs text-gray-400">{{ $sessionRecord->student->studentProfile?->department ?? '—' }}</p>
                    </div>
                </div>

                @if($sessionRecord->appointment)
                    <div class="pt-1 space-y-3">
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Concern</p>
                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                {{ ucfirst(str_replace('_', ' ', $sessionRecord->appointment->concern_type)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Session Date</p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($sessionRecord->appointment->preferred_date)->format('F d, Y') }}
                            </p>
                        </div>
                    </div>
                @endif

                <div class="pt-1">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-0.5">Originally Recorded</p>
                    <p class="text-sm text-gray-600">{{ $sessionRecord->created_at->format('M d, Y — g:i A') }}</p>
                </div>

            </div>
        </div>
    </div>

    {{-- ── Right: Edit Form ── --}}
    <div class="lg:col-span-2 order-1 lg:order-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-900">Edit Session Record</h2>
                <p class="text-xs text-gray-400 mt-0.5">Update the session notes, intervention, or follow-up details.</p>
            </div>

            <form id="session-form" method="POST" action="{{ route('counselor.sessions.update', $sessionRecord) }}" class="px-4 sm:px-6 py-5 space-y-5">
                @csrf
                @method('PATCH')

                {{-- Session Notes --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Session Notes
                        <span class="text-red-400">*</span>
                    </label>
                    <textarea name="session_notes" rows="7"
                              placeholder="Describe what was discussed during the session..."
                              class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-800 resize-none
                                     focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition
                                     @error('session_notes') border-red-300 @enderror">{{ old('session_notes', $sessionRecord->session_notes) }}</textarea>
                    @error('session_notes')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Intervention --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Intervention
                        <span class="text-gray-400 font-normal">(optional)</span>
                    </label>
                    <input type="text" name="intervention"
                           value="{{ old('intervention', $sessionRecord->intervention) }}"
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
                                   class="sr-only peer"
                                   {{ old('follow_up_needed', $sessionRecord->follow_up_needed) ? 'checked' : '' }}>
                            <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-100
                                        rounded-full peer peer-checked:bg-blue-600 transition-colors
                                        after:content-[''] after:absolute after:top-0.5 after:left-0.5
                                        after:bg-white after:rounded-full after:h-4 after:w-4
                                        after:transition-all peer-checked:after:translate-x-5"></div>
                        </label>
                    </div>

                    <div id="next-session-field"
                         class="{{ old('follow_up_needed', $sessionRecord->follow_up_needed) ? '' : 'hidden' }} mt-4 pt-4 border-t border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Next Session Date
                            <span class="text-red-400">*</span>
                        </label>
                        <input type="date" name="next_session_date"
                               value="{{ old('next_session_date', $sessionRecord->next_session_date?->format('Y-m-d')) }}"
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
                <div class="flex flex-wrap items-center justify-end gap-3 pt-2">
                    <a href="{{ route('counselor.sessions.show', $sessionRecord) }}"
                       data-nav-link
                       class="px-4 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-5 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition-colors cursor-pointer">
                        Save Changes
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

        // ── Follow-up toggle ──────────────────────────────────────
        const toggle    = document.getElementById('follow_up_toggle');
        const dateField = document.getElementById('next-session-field');
        toggle.addEventListener('change', () => {
            dateField.classList.toggle('hidden', !toggle.checked);
        });

        // ── Dirty tracking ────────────────────────────────────────
        let formDirty = false;
        const form    = document.getElementById('session-form');

        form.querySelectorAll('input, textarea, select').forEach(input => {
            input.addEventListener('change', () => formDirty = true);
            input.addEventListener('input',  () => formDirty = true);
        });

        // Clear dirty flag on legitimate submit
        form.addEventListener('submit', () => formDirty = false);

        // ── Exit modal logic ──────────────────────────────────────
        const modal    = document.getElementById('exit-modal');
        const leaveBtn = document.getElementById('exit-modal-leave');
        const stayBtn  = document.getElementById('exit-modal-stay');
        const backdrop = document.getElementById('exit-modal-backdrop');

        function showExitModal(destination) {
            leaveBtn.href = destination;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function hideExitModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }

        stayBtn.addEventListener('click', hideExitModal);
        backdrop.addEventListener('click', hideExitModal);

        // Intercept explicit nav links marked with data-nav-link
        document.querySelectorAll('[data-nav-link]').forEach(link => {
            link.addEventListener('click', e => {
                if (!formDirty) return;
                e.preventDefault();
                showExitModal(link.href);
            });
        });

        // Also intercept sidebar nav links
        document.querySelectorAll('aside nav a, aside .px-4 a').forEach(link => {
            link.addEventListener('click', e => {
                if (!formDirty) return;
                e.preventDefault();
                showExitModal(link.href);
            });
        });
    });
</script>
@endpush