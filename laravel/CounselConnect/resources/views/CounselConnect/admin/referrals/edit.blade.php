@extends('CounselConnect.layouts.admin')

@section('title', 'Edit Referral #' . $referral->id)
@section('page-title', 'Referrals')

@section('content')

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="{{ route('admin.referrals.index') }}" class="hover:text-blue-600 transition-colors">Referrals</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <a href="{{ route('admin.referrals.show', $referral) }}" class="hover:text-blue-600 transition-colors">Referral #{{ $referral->id }}</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <span class="text-gray-600 font-medium">Edit</span>
    </div>

    {{-- ── Page Header ── --}}
    <div class="mb-8 text-center">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Edit Referral</h2>
        <p class="text-sm text-gray-400 mt-1">Update the details for this referral record.</p>
    </div>

    <div class="max-w-2xl mx-auto">

        {{-- ── Errors ── --}}
        @if($errors->any())
            <div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-100 text-red-600 text-sm px-4 py-3 rounded-xl">
                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                </svg>
                <ul class="space-y-0.5">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.referrals.update', $referral) }}">
            @csrf @method('PATCH')

            <div class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-7 space-y-6">

                {{-- Current Referral Badge --}}
                <div class="flex items-center gap-3 p-3.5 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800">Referral #{{ $referral->id }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            For {{ $referral->student?->name ?? 'Unknown' }} · Created {{ $referral->created_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>

                {{-- Student --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Student</label>
                    <select name="student_id"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer @error('student_id') border-red-300 bg-red-50 @enderror">
                        @foreach($students as $student)
                            <option value="{{ $student->id }}"
                                {{ old('student_id', $referral->student_id) == $student->id ? 'selected' : '' }}>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Referred By --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Referred By</label>
                    <select id="edit_referred_by" name="referred_by"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer @error('referred_by') border-red-300 bg-red-50 @enderror">
                        @foreach($counselors as $counselor)
                            <option value="{{ $counselor->id }}"
                                {{ old('referred_by', $referral->referred_by) == $counselor->id ? 'selected' : '' }}>
                                {{ $counselor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Referred To --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Referred To</label>
                    <select id="edit_referred_to" name="referred_to"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer @error('referred_to') border-red-300 bg-red-50 @enderror">
                        @foreach(\App\Models\User::whereIn('role',['counselor','admin'])->orderBy('name')->get() as $user)
                            <option value="{{ $user->id }}"
                                    data-id="{{ $user->id }}"
                                    {{ old('referred_to', $referral->referred_to) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ ucfirst($user->role) }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Type --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Referral Type</label>
                    <select name="type"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer @error('type') border-red-300 bg-red-50 @enderror">
                        <option value="internal" {{ old('type', $referral->type) === 'internal' ? 'selected' : '' }}>Internal</option>
                        <option value="external" {{ old('type', $referral->type) === 'external' ? 'selected' : '' }}>External</option>
                    </select>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Status</label>
                    <select name="status"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer @error('status') border-red-300 bg-red-50 @enderror">
                        <option value="pending"      {{ old('status', $referral->status) === 'pending'      ? 'selected' : '' }}>Pending</option>
                        <option value="acknowledged" {{ old('status', $referral->status) === 'acknowledged' ? 'selected' : '' }}>Acknowledged</option>
                    </select>
                </div>

                {{-- Reason --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Reason</label>
                    <textarea name="reason"
                              rows="6"
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition resize-none @error('reason') border-red-300 bg-red-50 @enderror">{{ old('reason', $referral->reason) }}</textarea>
                </div>

            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-between mt-5 gap-3">
                <a href="{{ route('admin.referrals.show', $referral) }}"
                   class="flex items-center gap-2 px-4 sm:px-5 py-2.5 rounded-xl border border-gray-200 text-sm 
                   font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Discard Changes
                </a>
                <button type="submit"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800
                         text-white text-sm font-semibold px-5 sm:px-6 py-2.5 rounded-xl transition-colors
                          shadow-md shadow-blue-200 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Save Changes
                </button>
            </div>

        </form>

    </div>

@endsection

@push('scripts')
<script>
    // ── Exclude "Referred By" person from "Referred To" options ──
    (function () {
        const referredBy = document.getElementById('edit_referred_by');
        const referredTo = document.getElementById('edit_referred_to');

        // Snapshot all original options once
        const allOptions = Array.from(referredTo.options).map(o => ({
            value:  o.value,
            text:   o.text,
            dataId: o.dataset.id || o.value,
        }));

        function syncReferredTo() {
            const excludeId  = referredBy.value;
            const currentVal = referredTo.value;

            referredTo.innerHTML = '';
            allOptions.forEach(opt => {
                if (opt.value === '' || opt.dataId !== excludeId) {
                    const el = document.createElement('option');
                    el.value = opt.value;
                    el.text  = opt.text;
                    if (opt.value) el.dataset.id = opt.dataId;
                    referredTo.appendChild(el);
                }
            });

            // Restore prior selection if still valid
            if (referredTo.querySelector(`option[value="${currentVal}"]`)) {
                referredTo.value = currentVal;
            }
        }

        referredBy.addEventListener('change', syncReferredTo);
        // Run once on load so the existing record's referred_by is already excluded
        document.addEventListener('DOMContentLoaded', syncReferredTo);
    })();
</script>
@endpush