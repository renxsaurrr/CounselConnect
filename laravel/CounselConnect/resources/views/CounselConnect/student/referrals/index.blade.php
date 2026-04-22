@extends('CounselConnect.layouts.student')

@section('title', 'Referrals')
@section('page-title', 'Referrals')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

    {{-- ── Page Header ── --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Referrals</h2>
            <p class="text-sm text-gray-500 mt-0.5">Track referrals made on your behalf by your counselor.</p>
        </div>
    </div>

    {{-- ── Stat Row ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-yellow-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">
                    {{ str_pad($referrals->getCollection()->where('status', 'pending')->count(), 2, '0', STR_PAD_LEFT) }}
                </p>
                <p class="text-xs text-gray-400 mt-0.5">Pending</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">
                    {{ str_pad($referrals->getCollection()->where('status', 'acknowledged')->count(), 2, '0', STR_PAD_LEFT) }}
                </p>
                <p class="text-xs text-gray-400 mt-0.5">Acknowledged</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">
                    {{ str_pad($referrals->total(), 2, '0', STR_PAD_LEFT) }}
                </p>
                <p class="text-xs text-gray-400 mt-0.5">Total Referrals</p>
            </div>
        </div>

    </div>

    {{-- ── Referral History Table ── --}}
    <section class="bg-white rounded-2xl border border-gray-100 p-4 sm:p-6">

        {{-- Table Header + Filters: wraps on small screens --}}
        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <h3 class="text-sm font-semibold text-gray-900">Referral History</h3>
            <div class="flex items-center gap-1.5 flex-wrap">
                @foreach(['all' => 'All', 'internal' => 'Internal', 'external' => 'External'] as $value => $label)
                    @php
                        $currentType = request('type', 'all');
                        $isActive = $currentType === $value;
                        $href = $value === 'all'
                            ? route('student.referrals.index')
                            : route('student.referrals.index', ['type' => $value]);
                    @endphp
                    <a href="{{ $href }}"
                       class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors
                              {{ $isActive ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        @if($referrals->isEmpty())
            <div class="text-center py-14">
                <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                </svg>
                <p class="text-sm font-medium text-gray-400">No referrals found</p>
                <p class="text-xs text-gray-300 mt-1">
                    {{ request('type') ? 'No ' . request('type') . ' referrals yet.' : 'Your counselor will create referrals for you when needed.' }}
                </p>
            </div>
        @else
            @php
                $statusClasses = [
                    'pending'      => 'bg-yellow-50 text-yellow-600',
                    'acknowledged' => 'bg-green-50 text-green-600',
                ];
            @endphp

            {{-- Mobile: Card layout (hidden on sm+) --}}
            <div class="sm:hidden space-y-3">
                @foreach($referrals as $referral)
                @php $cls = $statusClasses[$referral->status] ?? 'bg-gray-50 text-gray-500'; @endphp
                <div class="p-3 rounded-xl border border-gray-100">
                    {{-- Top row: avatar + name + badges --}}
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xs font-bold shrink-0 overflow-hidden">
                            @if($referral->referredBy?->counselorProfile?->profile_picture)
                                <img src="{{ asset('storage/' . $referral->referredBy->counselorProfile->profile_picture) }}"
                                     alt="{{ $referral->referredBy->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($referral->referredBy?->name ?? '?', 0, 2)) }}
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $referral->referredBy?->name ?? '—' }}</p>
                                <div class="flex items-center gap-1.5 shrink-0">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-medium
                                        {{ $referral->type === 'internal' ? 'bg-blue-50 text-blue-600' : 'bg-purple-50 text-purple-600' }}">
                                        {{ ucfirst($referral->type) }}
                                    </span>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold {{ $cls }}">
                                        {{ ucfirst($referral->status) }}
                                    </span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $referral->referredBy?->counselorProfile?->specialization ?? 'Counselor' }}</p>
                        </div>
                    </div>
                    {{-- Reason + date + action --}}
                    <div class="mt-2.5 pl-12">
                        <p class="text-xs text-gray-600 truncate">{{ Str::limit($referral->reason, 60) }}</p>
                        @if($referral->referredTo)
                            <p class="text-xs text-gray-400 mt-0.5">To: {{ $referral->referredTo->name }}</p>
                        @endif
                        <div class="flex items-center justify-between mt-2">
                            <p class="text-xs text-gray-400">{{ $referral->created_at->format('M d, Y') }}</p>
                            <a href="{{ route('student.referrals.show', $referral) }}"
                               class="text-xs text-blue-500 hover:text-blue-700 font-medium">
                                View Details →
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Desktop: Table layout (hidden below sm) --}}
            <div class="hidden sm:block">
                <table class="w-full">
                    <thead>
                        <tr class="text-xs text-gray-400 uppercase tracking-wide border-b border-gray-100">
                            <th class="text-left pb-3 font-medium pr-4">Referred By</th>
                            <th class="text-left pb-3 font-medium pr-4">Reason / Focus Area</th>
                            <th class="text-left pb-3 font-medium pr-4">Type</th>
                            <th class="text-left pb-3 font-medium pr-4">Status</th>
                            <th class="text-left pb-3 font-medium pr-4">Date</th>
                            <th class="pb-3 font-medium text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($referrals as $referral)
                        @php $cls = $statusClasses[$referral->status] ?? 'bg-gray-50 text-gray-500'; @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors group">

                            {{-- Referred By --}}
                            <td class="py-4 pr-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xs font-bold shrink-0 overflow-hidden">
                                        @if($referral->referredBy?->counselorProfile?->profile_picture)
                                            <img src="{{ asset('storage/' . $referral->referredBy->counselorProfile->profile_picture) }}"
                                                 alt="{{ $referral->referredBy->name }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($referral->referredBy?->name ?? '?', 0, 2)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800 whitespace-nowrap">{{ $referral->referredBy?->name ?? '—' }}</p>
                                        <p class="text-xs text-gray-400">{{ $referral->referredBy?->counselorProfile?->specialization ?? 'Counselor' }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Reason --}}
                            <td class="py-4 pr-4 max-w-[200px]">
                                <p class="text-sm text-gray-800 truncate">{{ Str::limit($referral->reason, 40) }}</p>
                                @if($referral->referredTo)
                                    <p class="text-xs text-gray-400 mt-0.5">To: {{ $referral->referredTo->name }}</p>
                                @endif
                            </td>

                            {{-- Type --}}
                            <td class="py-4 pr-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium whitespace-nowrap
                                    {{ $referral->type === 'internal' ? 'bg-blue-50 text-blue-600' : 'bg-purple-50 text-purple-600' }}">
                                    {{ ucfirst($referral->type) }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="py-4 pr-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold whitespace-nowrap {{ $cls }}">
                                    {{ ucfirst($referral->status) }}
                                </span>
                            </td>

                            {{-- Date --}}
                            <td class="py-4 pr-4">
                                <p class="text-xs text-gray-500 whitespace-nowrap">{{ $referral->created_at->format('M d, Y') }}</p>
                            </td>

                            {{-- Action --}}
                            <td class="py-4 text-right">
                                <a href="{{ route('student.referrals.show', $referral) }}"
                                   class="text-xs text-blue-500 hover:text-blue-700 font-medium whitespace-nowrap">
                                    View Details →
                                </a>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination: wraps on small screens --}}
            @if($referrals->hasPages())
                <div class="pt-4 border-t border-gray-100 mt-4 flex flex-wrap items-center justify-between gap-3">
                    <p class="text-xs text-gray-400">
                        Showing {{ $referrals->firstItem() }}–{{ $referrals->lastItem() }} of {{ $referrals->total() }} referrals
                    </p>
                    {{ $referrals->links() }}
                </div>
            @endif
        @endif

    </section>

    {{-- ── Info Cards Row ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center mb-3">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-gray-800 mb-1">Internal vs External</p>
            <p class="text-xs text-gray-400 leading-relaxed">Internal referrals stay within the university network. External referrals involve outside clinical partners.</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center mb-3">
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-gray-800 mb-1">Privacy Guaranteed</p>
            <p class="text-xs text-gray-400 leading-relaxed">Your referral data is only shared with the receiving counselor and is kept confidential.</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="w-8 h-8 bg-orange-50 rounded-lg flex items-center justify-center mb-3">
                <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <p class="text-sm font-semibold text-gray-800 mb-1">Need Assistance?</p>
            <p class="text-xs text-gray-400 leading-relaxed">If your referral status hasn't updated, reach out to your counselor directly or visit the guidance office.</p>
        </div>

    </div>

</div>

@endsection