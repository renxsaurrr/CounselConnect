@extends('CounselConnect.layouts.admin')

@section('title', 'Referrals')
@section('page-title', 'Referrals')

@section('content')

    {{-- ── Page Header ── --}}
    <div class="flex items-start justify-between mb-6">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Referral Management</h2>
            <p class="text-sm text-gray-400 mt-1">Manage and track student support transitions — internal and external referrals.</p>
        </div>
        <button onclick="openModal()"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold 
                px-3 sm:px-4 py-2.5 rounded-xl transition-colors shadow-sm shadow-blue-200 shrink-0 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            <span class="hidden sm:inline">New Referral</span>
        </button>
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

    {{-- ── Stats Cards ── --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Total</p>
            <p class="text-2xl sm:text-3xl font-bold text-blue-600">{{ number_format($referrals->total()) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Pending</p>
            <p class="text-2xl sm:text-3xl font-bold text-amber-500">{{ $referrals->where('status', 'pending')->count() }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Internal</p>
            <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $referrals->where('type', 'internal')->count() }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">External</p>
            <p class="text-2xl sm:text-3xl font-bold text-gray-900">{{ $referrals->where('type', 'external')->count() }}</p>
        </div>
    </div>

    {{-- ── Referrals Table / Cards ── --}}
    <div class="bg-white rounded-2xl border border-gray-100">

        <div class="px-4 sm:px-6 pt-5 pb-4 border-b border-gray-50 flex items-center justify-between gap-3">
            <h3 class="text-sm font-semibold text-gray-900">All Referrals</h3>
            <form method="GET" action="{{ route('admin.referrals.index') }}">
                <div class="flex items-center gap-1.5 text-xs text-gray-400">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M6 12h12M9 17h6"/>
                    </svg>
                    <select name="sort"
                            onchange="this.form.submit()"
                            class="bg-transparent text-xs text-gray-500 font-medium focus:outline-none cursor-pointer pr-1">
                        <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="pending" {{ request('sort') === 'pending' ? 'selected' : '' }}>Pending First</option>
                        <option value="acknowledged" {{ request('sort') === 'acknowledged' ? 'selected' : '' }}>Acknowledged First</option>
                    </select>
                </div>
            </form>
        </div>

        {{-- ── Desktop Table (md+) ── --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-50">
                        <th class="text-left text-xs font-semibold text-gray-400 px-6 py-3">Student</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Referred By</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Referred To</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Type</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Status</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Date</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($referrals as $referral)
                        <tr class="hover:bg-gray-50/60 transition-colors">

                            {{-- Student --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2.5">
                                    @if($referral->student?->studentProfile?->profile_picture)
                                        <img src="{{ Storage::url($referral->student->studentProfile->profile_picture) }}"
                                             alt="{{ $referral->student->name }}"
                                             class="w-7 h-7 rounded-full object-cover shrink-0">
                                    @else
                                        <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-xs font-bold shrink-0">
                                            {{ strtoupper(substr($referral->student?->name ?? 'S', 0, 1)) }}
                                        </div>
                                    @endif
                                    <span class="text-sm font-semibold text-gray-800">{{ $referral->student?->name ?? '—' }}</span>
                                </div>
                            </td>

                            {{-- Referred By --}}
                            <td class="px-4 py-4">
                                <span class="text-sm text-gray-600">{{ $referral->referredBy?->name ?? '—' }}</span>
                            </td>

                            {{-- Referred To --}}
                            <td class="px-4 py-4">
                                <span class="text-sm text-gray-600">{{ $referral->referredTo?->name ?? '—' }}</span>
                            </td>

                            {{-- Type --}}
                            <td class="px-4 py-4">
                                @php
                                    $typeStyle = $referral->type === 'internal'
                                        ? 'bg-blue-50 text-blue-600'
                                        : 'bg-purple-50 text-purple-600';
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $typeStyle }}">
                                    {{ ucfirst($referral->type) }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-4">
                                @php
                                    $statusStyle = $referral->status === 'acknowledged'
                                        ? 'text-green-600'
                                        : 'text-amber-500';
                                    $dotStyle = $referral->status === 'acknowledged'
                                        ? 'bg-green-500'
                                        : 'bg-amber-400';
                                @endphp
                                <div class="flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotStyle }}"></span>
                                    <span class="text-sm {{ $statusStyle }}">{{ ucfirst($referral->status) }}</span>
                                </div>
                            </td>

                            {{-- Date --}}
                            <td class="px-4 py-4">
                                <span class="text-sm text-gray-500">{{ $referral->created_at->format('M d, Y') }}</span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('admin.referrals.show', $referral) }}"
                                       class="p-1.5 rounded-lg text-gray-400 hover:bg-blue-50 hover:text-blue-600 transition-colors" title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.referrals.edit', $referral) }}"
                                       class="p-1.5 rounded-lg text-gray-400 hover:bg-amber-50 hover:text-amber-500 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                        </svg>
                                    </a>
                                    <form id="delete-form-{{ $referral->id }}" method="POST" action="{{ route('admin.referrals.destroy', $referral) }}">
                                        @csrf @method('DELETE')
                                        <button type="button"
                                                onclick="openDeleteModal('delete-form-{{ $referral->id }}', '{{ addslashes($referral->student?->name ?? 'this referral') }}')"
                                                class="p-1.5 rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-500 transition-colors cursor-pointer" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-12 h-12 rounded-2xl bg-gray-100 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-700">No referrals yet</p>
                                    <p class="text-xs text-gray-400">Create a new referral to get started.</p>
                                    <button onclick="openModal()"
                                            class="mt-1 flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                        </svg>
                                        New Referral
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── Mobile Card List (below md) ── --}}
        <div class="md:hidden divide-y divide-gray-100">
            @forelse($referrals as $referral)
                @php
                    $typeStyle   = $referral->type === 'internal' ? 'bg-blue-50 text-blue-600' : 'bg-purple-50 text-purple-600';
                    $statusColor = $referral->status === 'acknowledged' ? 'text-green-600' : 'text-amber-500';
                    $dotColor    = $referral->status === 'acknowledged' ? 'bg-green-500' : 'bg-amber-400';
                @endphp
                <div class="p-4">

                    {{-- Top row: avatar + student name + badges --}}
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3 min-w-0">
                            @if($referral->student?->studentProfile?->profile_picture)
                                <img src="{{ Storage::url($referral->student->studentProfile->profile_picture) }}"
                                     alt="{{ $referral->student->name }}"
                                     class="w-9 h-9 rounded-full object-cover shrink-0">
                            @else
                                <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($referral->student?->name ?? 'S', 0, 1)) }}
                                </div>
                            @endif
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $referral->student?->name ?? '—' }}</p>
                                <p class="text-xs text-gray-400">{{ $referral->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5 shrink-0 flex-wrap justify-end">
                            <span class="inline-flex px-2 py-0.5 rounded-lg text-xs font-semibold {{ $typeStyle }}">
                                {{ ucfirst($referral->type) }}
                            </span>
                            <span class="flex items-center gap-1 text-xs {{ $statusColor }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }}"></span>
                                {{ ucfirst($referral->status) }}
                            </span>
                        </div>
                    </div>

                    {{-- Referred By / To row --}}
                    <div class="grid grid-cols-2 gap-2 mb-3 ml-12">
                        <div>
                            <p class="text-xs text-gray-400 font-medium mb-0.5">Referred By</p>
                            <p class="text-xs text-gray-700 font-semibold truncate">{{ $referral->referredBy?->name ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 font-medium mb-0.5">Referred To</p>
                            <p class="text-xs text-gray-700 font-semibold truncate">{{ $referral->referredTo?->name ?? '—' }}</p>
                        </div>
                    </div>

                    {{-- Action buttons --}}
                    <div class="flex items-center gap-2 ml-12">
                        <a href="{{ route('admin.referrals.show', $referral) }}"
                           class="flex-1 flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            View
                        </a>
                        <a href="{{ route('admin.referrals.edit', $referral) }}"
                           class="flex-1 flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg border border-amber-200 text-xs font-medium text-amber-600 hover:bg-amber-50 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                            </svg>
                            Edit
                        </a>
                        <form id="delete-form-mobile-{{ $referral->id }}" method="POST" action="{{ route('admin.referrals.destroy', $referral) }}">
                            @csrf @method('DELETE')
                            <button type="button"
                                    onclick="openDeleteModal('delete-form-mobile-{{ $referral->id }}', '{{ addslashes($referral->student?->name ?? 'this referral') }}')"
                                    class="flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg border border-red-200 text-xs font-medium text-red-500 hover:bg-red-50 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>

                </div>
            @empty
                <div class="px-4 py-16 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-gray-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-700">No referrals yet</p>
                        <p class="text-xs text-gray-400">Create a new referral to get started.</p>
                        <button onclick="openModal()"
                                class="mt-1 flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                            </svg>
                            New Referral
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($referrals->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-gray-50">
                {{ $referrals->links() }}
            </div>
        @endif

    </div>

    {{-- ── Delete Confirmation Modal ── --}}
    <div id="deleteModalBackdrop"
         class="hidden fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-50 flex items-center justify-center p-4 opacity-0 transition-opacity duration-200">
        <div id="deleteModalBox"
             class="bg-white rounded-2xl shadow-xl w-full max-w-sm scale-95 opacity-0 transition-all duration-200">
            <div class="p-6">
                {{-- Icon --}}
                <div class="w-11 h-11 rounded-2xl bg-red-50 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-900 mb-1">Delete Referral</h3>
                <p class="text-sm text-gray-500">
                    Are you sure you want to permanently delete the referral for
                    <span id="deleteModalStudentName" class="font-semibold text-gray-700"></span>?
                    This action cannot be undone.
                </p>
            </div>
            <div class="px-6 pb-6 flex items-center gap-3">
                <button type="button"
                        onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600
                         hover:bg-gray-100 transition-colors cursor-pointer">
                    Cancel
                </button>
                <button type="button"
                        id="deleteModalConfirmBtn"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition-colors cursor-pointer">
                    Delete
                </button>
            </div>
        </div>
    </div>

    {{-- ── Create Referral Modal (Slide-over) ── --}}
    <div id="modalBackdrop"
         class="hidden fixed inset-0 bg-gray-900/30 backdrop-blur-sm z-40 opacity-0 transition-opacity duration-300"
         onclick="closeModal()">
    </div>

    <div id="referralModal"
         class="fixed top-0 right-0 h-full w-full max-w-md bg-white shadow-2xl z-50 flex flex-col
                translate-x-full transition-transform duration-300 ease-in-out">

        {{-- Modal Header --}}
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between shrink-0">
            <div>
                <h3 class="text-base font-bold text-gray-900">New Referral</h3>
                <p class="text-xs text-gray-400 mt-0.5">Create a student referral record.</p>
            </div>
            <button onclick="closeModal()" class="p-2 rounded-xl text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.referrals.store') }}"
              class="flex-1 overflow-y-auto flex flex-col">
            @csrf

            <div class="px-6 py-5 space-y-5 flex-1">

                {{-- Errors --}}
                @if($errors->any())
                    <div class="flex items-start gap-3 bg-red-50 border border-red-100 text-red-600 text-xs px-4 py-3 rounded-xl">
                        <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                        </svg>
                        <ul class="space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Student --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Student</label>
                    <select name="student_id"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer @error('student_id') border-red-300 bg-red-50 @enderror">
                        <option value="">Select student…</option>
                        @foreach(\App\Models\User::where('role','student')->orderBy('name')->get() as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Referred By --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Referred By</label>
                    <select id="create_referred_by" name="referred_by"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer @error('referred_by') border-red-300 bg-red-50 @enderror">
                        <option value="">Select counselor…</option>
                        @foreach(\App\Models\User::where('role','counselor')->orderBy('name')->get() as $counselor)
                            <option value="{{ $counselor->id }}" {{ old('referred_by') == $counselor->id ? 'selected' : '' }}>
                                {{ $counselor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Referred To --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Referred To</label>
                    <select id="create_referred_to" name="referred_to"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer @error('referred_to') border-red-300 bg-red-50 @enderror">
                        <option value="">Select recipient…</option>
                        @foreach(\App\Models\User::where('role','counselor')->orderBy('name')->get() as $user)
                            <option value="{{ $user->id }}"
                                    data-id="{{ $user->id }}"
                                    {{ old('referred_to') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Type --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Referral Type</label>
                    <select name="type"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer @error('type') border-red-300 bg-red-50 @enderror">
                        <option value="internal" {{ old('type') === 'internal' ? 'selected' : '' }}>Internal</option>
                        <option value="external" {{ old('type') === 'external' ? 'selected' : '' }}>External</option>
                    </select>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Status</label>
                    <select name="status"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer @error('status') border-red-300 bg-red-50 @enderror">
                        <option value="pending"      {{ old('status', 'pending') === 'pending'      ? 'selected' : '' }}>Pending</option>
                        <option value="acknowledged" {{ old('status') === 'acknowledged' ? 'selected' : '' }}>Acknowledged</option>
                    </select>
                </div>

                {{-- Reason --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Reason</label>
                    <textarea name="reason"
                              rows="5"
                              placeholder="Describe the reason for this referral…"
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition resize-none @error('reason') border-red-300 bg-red-50 @enderror">{{ old('reason') }}</textarea>
                </div>

            </div>

            {{-- Modal Footer --}}
            <div class="px-6 py-4 border-t border-gray-100 flex items-center gap-3 shrink-0">
                <button type="submit"
                        class="flex-1 flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold 
                        py-3 rounded-xl transition-colors shadow-md shadow-blue-200 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                    Create Referral
                </button>
                <button type="button"
                        onclick="closeModal()"
                        class="px-5 py-3 rounded-xl border border-gray-200 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 
                        transition-colors cursor-pointer">
                    Discard
                </button>
            </div>

        </form>
    </div>

@endsection

@push('scripts')
<script>
    // ── Delete Confirmation Modal ──
    const deleteBackdrop  = document.getElementById('deleteModalBackdrop');
    const deleteBox       = document.getElementById('deleteModalBox');
    const deleteNameEl    = document.getElementById('deleteModalStudentName');
    const deleteConfirmBtn = document.getElementById('deleteModalConfirmBtn');
    let pendingDeleteFormId = null;

    function openDeleteModal(formId, studentName) {
        pendingDeleteFormId = formId;
        deleteNameEl.textContent = studentName;
        deleteBackdrop.classList.remove('hidden');
        requestAnimationFrame(() => {
            deleteBackdrop.classList.remove('opacity-0');
            deleteBox.classList.remove('scale-95', 'opacity-0');
        });
    }

    function closeDeleteModal() {
        deleteBackdrop.classList.add('opacity-0');
        deleteBox.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            deleteBackdrop.classList.add('hidden');
            pendingDeleteFormId = null;
        }, 200);
    }

    deleteConfirmBtn.addEventListener('click', () => {
        if (pendingDeleteFormId) {
            document.getElementById(pendingDeleteFormId).submit();
        }
    });

    deleteBackdrop.addEventListener('click', (e) => {
        if (e.target === deleteBackdrop) closeDeleteModal();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeDeleteModal();
    });

    // ── Create Referral Slide-over ──
    const modal    = document.getElementById('referralModal');
    const backdrop = document.getElementById('modalBackdrop');

    function openModal() {
        backdrop.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            modal.classList.remove('translate-x-full');
        });
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        backdrop.classList.add('opacity-0');
        modal.classList.add('translate-x-full');
        setTimeout(() => {
            backdrop.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300);
    }

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', () => openModal());
    @endif

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeModal();
    });

    // ── Exclude "Referred By" person from "Referred To" options ──
    (function () {
        const referredBy = document.getElementById('create_referred_by');
        const referredTo = document.getElementById('create_referred_to');

        // Snapshot all original options once
        const allOptions = Array.from(referredTo.options).map(o => ({
            value:  o.value,
            text:   o.text,
            dataId: o.dataset.id || o.value,
        }));

        function syncReferredTo() {
            const excludeId = referredBy.value;
            const currentVal = referredTo.value;

            referredTo.innerHTML = '';
            allOptions.forEach(opt => {
                // Always keep the blank placeholder; exclude matched person
                if (opt.value === '' || opt.dataId !== excludeId) {
                    const el = document.createElement('option');
                    el.value = opt.value;
                    el.text  = opt.text;
                    if (opt.value) el.dataset.id = opt.dataId;
                    referredTo.appendChild(el);
                }
            });

            // Restore prior selection if it's still available
            if (referredTo.querySelector(`option[value="${currentVal}"]`)) {
                referredTo.value = currentVal;
            }
        }

        referredBy.addEventListener('change', syncReferredTo);
        // Run once on page load to handle old() pre-selections
        document.addEventListener('DOMContentLoaded', syncReferredTo);
    })();
</script>
@endpush