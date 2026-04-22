@extends('CounselConnect.layouts.counselor')

@section('title', 'Send Referral')
@section('page-title', 'Referrals')

@section('content')

{{-- ── Back Link ── --}}
<a href="{{ route('counselor.referrals.index') }}"
   class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 mb-6 transition-colors">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    Back to Referrals
</a>

<div class="w-full max-w-2xl">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="text-base font-semibold text-gray-900">Send a Referral</h2>
            <p class="text-xs text-gray-400 mt-0.5">Refer a student to another counselor. This action cannot be undone once submitted.</p>
        </div>

        <form id="referral-form" method="POST" action="{{ route('counselor.referrals.store') }}" class="px-5 py-5 space-y-5">
            @csrf

            {{-- Student --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Student <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <select id="student-select" name="student_id"
                            class="w-full px-3.5 py-2.5 pr-9 rounded-xl border border-gray-200 text-sm text-gray-800
                                   appearance-none focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 bg-white transition
                                   @error('student_id') border-red-300 @enderror">
                        <option value="">Select a student...</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}"
                                    data-name="{{ $student->name }}"
                                    data-dept="{{ $student->studentProfile?->department ?? 'No department' }}"
                                    {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }}
                                @if($student->studentProfile?->student_id)
                                    ({{ $student->studentProfile->student_id }})
                                @endif
                                — {{ $student->studentProfile?->department ?? 'No department' }}
                            </option>
                        @endforeach
                    </select>
                    <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                @error('student_id')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Refer To --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Refer To <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <select id="counselor-select" name="referred_to"
                            class="w-full px-3.5 py-2.5 pr-9 rounded-xl border border-gray-200 text-sm text-gray-800
                                   appearance-none focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 bg-white transition
                                   @error('referred_to') border-red-300 @enderror">
                        <option value="">Select a counselor...</option>
                        @foreach($counselors as $counselor)
                            <option value="{{ $counselor->id }}"
                                    data-name="{{ $counselor->name }}"
                                    data-spec="{{ $counselor->counselorProfile?->specialization ?? 'Counselor' }}"
                                    {{ old('referred_to') == $counselor->id ? 'selected' : '' }}>
                                {{ $counselor->name }}
                                @if($counselor->counselorProfile?->specialization)
                                    — {{ $counselor->counselorProfile->specialization }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                @error('referred_to')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Type --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Referral Type <span class="text-red-400">*</span>
                </label>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="relative flex items-start gap-3 p-3.5 rounded-xl border cursor-pointer transition-colors
                                  {{ old('type') === 'internal' ? 'border-blue-400 bg-blue-50' : 'border-gray-200 hover:bg-gray-50' }}">
                        <input type="radio" name="type" value="internal"
                               {{ old('type') === 'internal' ? 'checked' : '' }}
                               class="mt-0.5 accent-blue-600">
                        <div>
                            <p class="text-sm font-medium text-gray-800">Internal</p>
                            <p class="text-xs text-gray-400 mt-0.5">Within the same institution</p>
                        </div>
                    </label>
                    <label class="relative flex items-start gap-3 p-3.5 rounded-xl border cursor-pointer transition-colors
                                  {{ old('type') === 'external' ? 'border-purple-400 bg-purple-50' : 'border-gray-200 hover:bg-gray-50' }}">
                        <input type="radio" name="type" value="external"
                               {{ old('type') === 'external' ? 'checked' : '' }}
                               class="mt-0.5 accent-purple-600">
                        <div>
                            <p class="text-sm font-medium text-gray-800">External</p>
                            <p class="text-xs text-gray-400 mt-0.5">Outside the institution</p>
                        </div>
                    </label>
                </div>
                @error('type')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Reason --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Reason for Referral <span class="text-red-400">*</span>
                </label>
                <textarea id="reason-field" name="reason" rows="5"
                          placeholder="Describe why this student is being referred and any relevant context the receiving counselor should know..."
                          class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-800 resize-none
                                 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition
                                 @error('reason') border-red-300 @enderror">{{ old('reason') }}</textarea>
                @error('reason')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-3 pt-2">
                <a href="{{ route('counselor.referrals.index') }}"
                   class="flex items-center justify-center px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 
                   hover:bg-gray-100 transition-colors">
                    Cancel
                </a>
                {{-- Opens confirmation modal, does NOT submit directly --}}
                <button type="button"
                        onclick="openReferralConfirm()"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Submit Referral
                </button>
            </div>

        </form>
    </div>
</div>


{{-- ══════════════════════════════════════════════════════════ --}}
{{-- REFERRAL CONFIRMATION MODAL                               --}}
{{-- ══════════════════════════════════════════════════════════ --}}
<div id="referral-confirm-modal"
     class="hidden fixed inset-0 z-[9999] flex items-center justify-center px-4 py-8 bg-black/40 backdrop-blur-sm"
     role="dialog"
     aria-modal="true"
     aria-labelledby="confirm-modal-title"
     onclick="if(event.target === this) closeReferralConfirm()">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden">

        {{-- Modal header --}}
        <div class="px-6 py-5 border-b border-gray-100 flex items-start justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </div>
                <div>
                    <h3 id="confirm-modal-title" class="text-sm font-semibold text-gray-900">Confirm Referral</h3>
                    <p class="text-xs text-gray-400 mt-0.5">Review the details below before submitting.</p>
                </div>
            </div>
            <button type="button"
                    onclick="closeReferralConfirm()"
                    aria-label="Close"
                    class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-400 hover:text-gray-600 transition-colors shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Summary rows --}}
        <div class="px-6 py-5 space-y-4">

            {{-- Student --}}
            <div class="flex items-start justify-between gap-4">
                <p class="text-xs text-gray-400 uppercase tracking-wide shrink-0 pt-0.5">Student</p>
                <div class="text-right min-w-0">
                    <p id="confirm-student-name" class="text-sm font-medium text-gray-900 break-words">—</p>
                    <p id="confirm-student-dept" class="text-xs text-gray-400 mt-0.5">—</p>
                </div>
            </div>

            <div class="border-t border-gray-50"></div>

            {{-- Referred To --}}
            <div class="flex items-start justify-between gap-4">
                <p class="text-xs text-gray-400 uppercase tracking-wide shrink-0 pt-0.5">Referred To</p>
                <div class="text-right min-w-0">
                    <p id="confirm-counselor-name" class="text-sm font-medium text-gray-900 break-words">—</p>
                    <p id="confirm-counselor-spec" class="text-xs text-gray-400 mt-0.5">—</p>
                </div>
            </div>

            <div class="border-t border-gray-50"></div>

            {{-- Type --}}
            <div class="flex items-center justify-between gap-4">
                <p class="text-xs text-gray-400 uppercase tracking-wide shrink-0">Type</p>
                <span id="confirm-type"
                      class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">—</span>
            </div>

            <div class="border-t border-gray-50"></div>

            {{-- Reason --}}
            <div>
                <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">Reason</p>
                <p id="confirm-reason"
                   class="text-sm text-gray-700 leading-relaxed line-clamp-4 whitespace-pre-wrap">—</p>
            </div>

            {{-- Warning --}}
            <div class="flex items-start gap-2.5 bg-amber-50 border border-amber-100 rounded-xl px-3.5 py-3">
                <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
                <p class="text-xs text-amber-700 leading-relaxed">This action cannot be undone. The receiving counselor will be notified immediately.</p>
            </div>

        </div>

        {{-- Modal footer --}}
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex flex-col-reverse sm:flex-row gap-3 sm:justify-end">
            <button type="button"
                    onclick="closeReferralConfirm()"
                    class="flex items-center justify-center px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm font-medium text-gray-600 hover:bg-gray-100
                    cursor-pointer transition-colors">
                Go Back
            </button>
            <button type="button"
                    id="confirm-submit-btn"
                    onclick="submitReferral()"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 
                    cursor-pointer transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                Confirm & Submit
            </button>
        </div>

    </div>
</div>
{{-- ── End Confirmation Modal ── --}}

@endsection

@push('scripts')
<script>
    function openReferralConfirm() {
        const studentSel   = document.getElementById('student-select');
        const counselorSel = document.getElementById('counselor-select');
        const typeRadio    = document.querySelector('input[name="type"]:checked');
        const reason       = document.getElementById('reason-field').value.trim();

        const studentOpt   = studentSel.options[studentSel.selectedIndex];
        const counselorOpt = counselorSel.options[counselorSel.selectedIndex];

        // Student
        document.getElementById('confirm-student-name').textContent =
            studentSel.value ? studentOpt.dataset.name : '— Not selected —';
        document.getElementById('confirm-student-dept').textContent =
            studentSel.value ? (studentOpt.dataset.dept || '') : '';

        // Counselor
        document.getElementById('confirm-counselor-name').textContent =
            counselorSel.value ? counselorOpt.dataset.name : '— Not selected —';
        document.getElementById('confirm-counselor-spec').textContent =
            counselorSel.value ? (counselorOpt.dataset.spec || '') : '';

        // Type badge
        const typeEl = document.getElementById('confirm-type');
        if (typeRadio) {
            const isInternal = typeRadio.value === 'internal';
            typeEl.textContent = isInternal ? 'Internal' : 'External';
            typeEl.className = 'inline-block px-2.5 py-1 rounded-full text-xs font-medium '
                + (isInternal ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700');
        } else {
            typeEl.textContent = '— Not selected —';
            typeEl.className = 'inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500';
        }

        // Reason
        document.getElementById('confirm-reason').textContent =
            reason || '— No reason provided —';

        // Show modal
        document.getElementById('referral-confirm-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeReferralConfirm() {
        document.getElementById('referral-confirm-modal').classList.add('hidden');
        document.body.style.overflow = '';
    }

    function submitReferral() {
        const btn = document.getElementById('confirm-submit-btn');
        btn.disabled = true;
        btn.innerHTML = `
            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
            </svg>
            Submitting...
        `;
        document.getElementById('referral-form').submit();
    }

    // Escape key
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeReferralConfirm();
    });
</script>
@endpush