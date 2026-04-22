@extends('CounselConnect.layouts.admin')

@section('title', 'Referral #' . $referral->id)
@section('page-title', 'Referrals')

@section('content')

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="{{ route('admin.referrals.index') }}" class="hover:text-blue-600 transition-colors">Referrals</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <span class="text-gray-600 font-medium">Referral #{{ $referral->id }}</span>
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

    <div class="max-w-3xl">

        {{-- ── Main Card ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">

            {{-- Card Header --}}
            <div class="px-5 sm:px-7 py-5 sm:py-6 border-b border-gray-50">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                    <div class="flex-1">

                        {{-- Badges --}}
                        <div class="flex items-center gap-2 mb-3">
                            @php
                                $typeStyle = $referral->type === 'internal'
                                    ? 'bg-blue-50 text-blue-600'
                                    : 'bg-purple-50 text-purple-600';
                                $statusColor = $referral->status === 'acknowledged'
                                    ? 'text-green-600'
                                    : 'text-amber-500';
                                $dotColor = $referral->status === 'acknowledged'
                                    ? 'bg-green-500'
                                    : 'bg-amber-400';
                            @endphp
                            <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $typeStyle }}">
                                {{ ucfirst($referral->type) }}
                            </span>
                            <span class="flex items-center gap-1.5 text-xs {{ $statusColor }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                {{ ucfirst($referral->status) }}
                            </span>
                        </div>

                        <h2 class="text-lg sm:text-xl font-bold text-gray-900 leading-snug">
                            Referral for {{ $referral->student?->name ?? 'Unknown Student' }}
                        </h2>

                        <div class="flex flex-wrap items-center gap-2 sm:gap-3 mt-3 text-xs text-gray-400">
                            <span>Created {{ $referral->created_at->format('F d, Y \a\t g:i A') }}</span>
                            @if($referral->updated_at->ne($referral->created_at))
                                <span>· Updated {{ $referral->updated_at->diffForHumans() }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 shrink-0">
                        <a href="{{ route('admin.referrals.edit', $referral) }}"
                           class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                            </svg>
                            Edit
                        </a>
                        <form id="show-delete-form" method="POST" action="{{ route('admin.referrals.destroy', $referral) }}">
                            @csrf @method('DELETE')
                            <button type="button"
                                    onclick="openDeleteModal()"
                                    class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-gray-200
                                     text-gray-400 hover:bg-red-50 hover:text-red-500 hover:border-red-200
                                      text-xs font-semibold transition-colors cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Details Grid — 1 col on mobile, 2 col on sm+ --}}
            <div class="px-5 sm:px-7 py-5 sm:py-6 grid grid-cols-1 sm:grid-cols-2 gap-4">

                {{-- Student --}}
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Student</p>
                    <div class="flex items-center gap-2.5">
                        @if($referral->student?->studentProfile?->profile_picture)
                            <img src="{{ asset('storage/' . $referral->student->studentProfile->profile_picture) }}"
                                 alt="{{ $referral->student->name }}"
                                 class="w-8 h-8 rounded-full object-cover shrink-0">
                        @else
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-xs font-bold shrink-0">
                                {{ strtoupper(substr($referral->student?->name ?? 'S', 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $referral->student?->name ?? '—' }}</p>
                            <p class="text-xs text-gray-400">{{ $referral->student?->email ?? '' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Referred By --}}
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Referred By</p>
                    <div class="flex items-center gap-2.5">
                        @if($referral->referredBy?->counselorProfile?->profile_picture)
                            <img src="{{ asset('storage/' . $referral->referredBy->counselorProfile->profile_picture) }}"
                                 alt="{{ $referral->referredBy->name }}"
                                 class="w-8 h-8 rounded-full object-cover shrink-0">
                        @else
                            <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 text-xs font-bold shrink-0">
                                {{ strtoupper(substr($referral->referredBy?->name ?? 'R', 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $referral->referredBy?->name ?? '—' }}</p>
                            <p class="text-xs text-gray-400">{{ $referral->referredBy?->email ?? '' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Referred To --}}
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Referred To</p>
                    <div class="flex items-center gap-2.5">
                        @if($referral->referredTo?->counselorProfile?->profile_picture)
                            <img src="{{ asset('storage/' . $referral->referredTo->counselorProfile->profile_picture) }}"
                                 alt="{{ $referral->referredTo->name }}"
                                 class="w-8 h-8 rounded-full object-cover shrink-0">
                        @else
                            <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center text-purple-700 text-xs font-bold shrink-0">
                                {{ strtoupper(substr($referral->referredTo?->name ?? 'R', 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-semibold text-gray-800">{{ $referral->referredTo?->name ?? '—' }}</p>
                            <p class="text-xs text-gray-400">{{ $referral->referredTo?->email ?? '' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Type & Status --}}
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1.5">Details</p>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $typeStyle }}">
                            {{ ucfirst($referral->type) }}
                        </span>
                        <span class="flex items-center gap-1.5 text-xs {{ $statusColor }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                            {{ ucfirst($referral->status) }}
                        </span>
                    </div>
                </div>

            </div>

            {{-- Reason --}}
            <div class="px-5 sm:px-7 pb-6 sm:pb-7">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Reason</p>
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $referral->reason }}</p>
                </div>
            </div>

        </div>

        {{-- ── Back Link ── --}}
        <div class="mt-5">
            <a href="{{ route('admin.referrals.index') }}"
               class="flex items-center gap-2 text-sm text-gray-400 hover:text-gray-600 transition-colors w-fit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Back to Referrals
            </a>
        </div>

    </div>

    {{-- ── Delete Confirmation Modal ── --}}
    <div id="deleteModalBackdrop"
         class="hidden fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 opacity-0 transition-opacity duration-200">
        <div id="deleteModalBox"
             class="bg-white rounded-2xl shadow-xl w-full max-w-sm scale-95 opacity-0 transition-all duration-200">
            <div class="p-6">
                <div class="w-11 h-11 rounded-2xl bg-red-50 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1">Delete Referral</h3>
                <p class="text-sm text-gray-500">
                    Are you sure you want to permanently delete the referral for
                    <span class="font-semibold text-gray-700">{{ $referral->student?->name ?? 'this student' }}</span>?
                    This action cannot be undone.
                </p>
            </div>
            <div class="px-6 pb-6 flex items-center gap-3">
                <button type="button"
                        onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">
                    Cancel
                </button>
                <button type="button"
                        onclick="document.getElementById('show-delete-form').submit()"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition-colors cursor-pointer">
                    Delete
                </button>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    const deleteBackdrop = document.getElementById('deleteModalBackdrop');
    const deleteBox      = document.getElementById('deleteModalBox');

    function openDeleteModal() {
        deleteBackdrop.classList.remove('hidden');
        requestAnimationFrame(() => {
            deleteBackdrop.classList.remove('opacity-0');
            deleteBox.classList.remove('scale-95', 'opacity-0');
        });
    }

    function closeDeleteModal() {
        deleteBackdrop.classList.add('opacity-0');
        deleteBox.classList.add('scale-95', 'opacity-0');
        setTimeout(() => deleteBackdrop.classList.add('hidden'), 200);
    }

    deleteBackdrop.addEventListener('click', (e) => {
        if (e.target === deleteBackdrop) closeDeleteModal();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeDeleteModal();
    });
</script>
@endpush

@endsection