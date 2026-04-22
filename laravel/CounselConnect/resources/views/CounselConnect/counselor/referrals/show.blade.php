@extends('CounselConnect.layouts.counselor')

@section('title', 'Referral Details')
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

{{-- ── Flash ── --}}
@if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-xl bg-green-50 border border-green-100 text-green-700 text-sm">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Left: Student + Referral Chain ── --}}
    <div class="lg:col-span-1 space-y-5">

        {{-- Student Card --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-900">Student</h2>
            </div>
            <div class="px-5 py-4">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-11 h-11 rounded-full bg-blue-600 flex items-center justify-center text-white text-base font-semibold shrink-0 overflow-hidden">
                        @if($referral->student->studentProfile?->profile_picture)
                            <img src="{{ asset('storage/' . $referral->student->studentProfile->profile_picture) }}"
                                 alt="{{ $referral->student->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($referral->student->name, 0, 1)) }}
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900 break-words">{{ $referral->student->name }}</p>
                        <p class="text-xs text-gray-400 break-all">{{ $referral->student->email }}</p>
                    </div>
                </div>
                <div class="space-y-2.5">
                    @if($referral->student->studentProfile?->department)
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-xs text-gray-400 shrink-0">Department</p>
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 text-right">
                                {{ $referral->student->studentProfile->department }}
                            </span>
                        </div>
                    @endif
                    @if($referral->student->studentProfile?->year_level)
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-xs text-gray-400 shrink-0">Year Level</p>
                            <p class="text-sm text-gray-700">{{ $referral->student->studentProfile->year_level }}</p>
                        </div>
                    @endif
                    @if($referral->student->studentProfile?->student_id)
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-xs text-gray-400 shrink-0">Student ID</p>
                            <p class="text-sm font-mono text-gray-700">{{ $referral->student->studentProfile->student_id }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Referral Chain --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-900">Referral Chain</h2>
            </div>
            <div class="px-5 py-4 space-y-4">

                {{-- From --}}
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">From</p>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-sm font-semibold shrink-0 overflow-hidden">
                            @if($referral->referredBy->counselorProfile?->profile_picture)
                                <img src="{{ asset('storage/' . $referral->referredBy->counselorProfile->profile_picture) }}" alt="{{ $referral->referredBy->name }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($referral->referredBy->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $referral->referredBy->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $referral->referredBy->counselorProfile?->specialization ?? 'Counselor' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Arrow --}}
                <div class="flex items-center gap-2 pl-1">
                    <div class="w-7 h-7 rounded-full bg-blue-50 flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                </div>

                {{-- To --}}
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-2">To</p>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                            @if($referral->referredTo->counselorProfile?->profile_picture)
                                <img src="{{ asset('storage/' . $referral->referredTo->counselorProfile->profile_picture) }}" alt="{{ $referral->referredTo->name }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($referral->referredTo->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $referral->referredTo->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $referral->referredTo->counselorProfile?->specialization ?? 'Counselor' }}</p>
                            @if($referral->referredTo->counselorProfile?->office_location)
                                <p class="text-xs text-gray-400 truncate">{{ $referral->referredTo->counselorProfile->office_location }}</p>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- ── Right: Meta + Reason + Actions ── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Meta Bar — wraps gracefully on small screens --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4">
            <div class="flex flex-wrap gap-x-5 gap-y-3">

                {{-- Type --}}
                <div>
                    <p class="text-xs text-gray-400 mb-1">Type</p>
                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium
                        {{ $referral->type === 'internal' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                        {{ ucfirst($referral->type) }}
                    </span>
                </div>

                {{-- Status --}}
                <div class="sm:pl-5 sm:border-l sm:border-gray-100">
                    <p class="text-xs text-gray-400 mb-1">Status</p>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                        {{ $referral->isPending() ? 'bg-amber-50 text-amber-700' : 'bg-green-50 text-green-700' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $referral->isPending() ? 'bg-amber-500' : 'bg-green-500' }}"></span>
                        {{ ucfirst($referral->status) }}
                    </span>
                </div>

                {{-- Date --}}
                <div class="sm:pl-5 sm:border-l sm:border-gray-100">
                    <p class="text-xs text-gray-400 mb-1">Submitted</p>
                    <p class="text-sm font-medium text-gray-800">{{ $referral->created_at->format('M d, Y — g:i A') }}</p>
                </div>

            </div>
        </div>

        {{-- Reason --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Reason for Referral</h3>
            </div>
            <div class="px-5 py-4">
                <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $referral->reason }}</p>
            </div>
        </div>

        {{-- Acknowledge Action --}}
        @if($referral->referred_to === Auth::id() && $referral->isPending())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-900">Acknowledge Referral</h3>
                    <p class="text-xs text-gray-400 mt-0.5">
                        Confirm that you have received and reviewed this referral.
                    </p>
                </div>
                <div class="px-5 py-4">
                    <form id="acknowledge-form" method="POST" action="{{ route('counselor.referrals.acknowledge', $referral) }}">
                        @csrf
                        @method('PATCH')
                        <button type="button"
                                onclick="document.getElementById('acknowledge-modal').classList.remove('hidden')"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-green-600 text-white 
                                text-sm font-medium hover:bg-green-700 transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            Mark as Acknowledged
                        </button>
                    </form>
                </div>
            </div>
        @endif

        {{-- Already Acknowledged Notice --}}
        @if($referral->isAcknowledged())
            <div class="bg-green-50 border border-green-100 rounded-2xl px-5 py-4 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-green-700">Referral Acknowledged</p>
                    <p class="text-xs text-green-600 mt-0.5 break-words">
                        {{ $referral->referredTo->name }} has acknowledged this referral.
                    </p>
                </div>
            </div>
        @endif

    </div>

</div>


{{-- ── Acknowledge Confirmation Modal ── --}}
<div id="acknowledge-modal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center px-4"
     aria-modal="true" role="dialog">

    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm"
         onclick="document.getElementById('acknowledge-modal').classList.add('hidden')"></div>

    {{-- Dialog --}}
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 space-y-4">

        {{-- Icon --}}
        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-green-50 mx-auto">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        {{-- Text --}}
        <div class="text-center">
            <h3 class="text-base font-semibold text-gray-900">Acknowledge Referral?</h3>
            <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                This confirms that you have received and reviewed this referral. This action cannot be undone.
            </p>
        </div>

        {{-- Actions --}}
        <div class="flex gap-3 pt-1">
            <button type="button"
                    onclick="document.getElementById('acknowledge-modal').classList.add('hidden')"
                    class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium
                     text-gray-600 hover:bg-gray-100 transition-colors cursor-pointer">
                Cancel
            </button>
            <button type="button"
                    onclick="document.getElementById('acknowledge-form').submit()"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-green-600 text-white text-sm font-medium
                     hover:bg-green-700 transition-colors cursor-pointer">
                Yes, Acknowledge
            </button>
        </div>

    </div>
</div>

@endsection