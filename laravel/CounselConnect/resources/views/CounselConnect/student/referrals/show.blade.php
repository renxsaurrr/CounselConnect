@extends('CounselConnect.layouts.student')

@section('title', 'Referral Details')
@section('page-title', 'Referral Details')

@section('content')

<div class="max-w-5xl mx-auto space-y-5">

    {{-- ── Back link ── --}}
    <a href="{{ route('student.referrals.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-blue-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Referrals
    </a>

    {{-- ── Page Title Row: wraps on small screens ── --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-xl font-bold text-gray-900">Referral #{{ $referral->id }}</h2>
            <p class="text-xs text-gray-400 mt-0.5">Submitted {{ $referral->created_at->format('F d, Y') }}</p>
        </div>
        @php
            $statusClasses = [
                'pending'      => 'bg-yellow-50 text-yellow-600 ring-1 ring-yellow-200',
                'acknowledged' => 'bg-green-50 text-green-600 ring-1 ring-green-200',
            ];
            $cls = $statusClasses[$referral->status] ?? 'bg-gray-50 text-gray-500 ring-1 ring-gray-200';
        @endphp
        <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-semibold {{ $cls }}">
            {{ ucfirst($referral->status) }}
        </span>
    </div>

    {{-- ── Main Grid: stacks on mobile, 5-col on large screens ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5 items-start">

        {{-- ══ Left: Detail Card ══ --}}
        <div class="lg:col-span-3 space-y-4">

            {{-- Overview --}}
            <section class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-6">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-4">Overview</h3>

                {{-- Stat grid: stacked on xs, 2-col on sm+ --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-4">

                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-400 font-medium mb-1.5">Referral Type</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold
                            {{ $referral->type === 'internal' ? 'bg-blue-50 text-blue-600' : 'bg-purple-50 text-purple-600' }}">
                            {{ ucfirst($referral->type) }}
                        </span>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-400 font-medium mb-1.5">Status</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-semibold {{ $cls }}">
                            {{ ucfirst($referral->status) }}
                        </span>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-400 font-medium mb-1.5">Date Created</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $referral->created_at->format('M d, Y') }}</p>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-400 font-medium mb-1.5">Last Updated</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $referral->updated_at->format('M d, Y') }}</p>
                    </div>

                </div>

                {{-- Reason --}}
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs text-gray-400 font-medium mb-2">Reason / Focus Area</p>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $referral->reason }}</p>
                </div>
            </section>

            {{-- Info box --}}
            <div class="bg-blue-50 rounded-2xl p-4 flex gap-3 items-start">
                <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-blue-700">What happens next?</p>
                    <p class="text-xs text-blue-500 mt-0.5 leading-relaxed">
                        Once the receiving counselor acknowledges this referral, the status will update to <span class="font-semibold">Acknowledged</span>. You may still book appointments independently at any time.
                    </p>
                </div>
            </div>

        </div>

        {{-- ══ Right: People Cards ══ --}}
        <aside class="lg:col-span-2 space-y-4">

            {{-- Referred By --}}
            <section class="bg-white rounded-2xl border border-gray-100 p-5">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-4">Referred By</h3>
                @if($referral->referredBy)
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-sm font-bold shrink-0 overflow-hidden">
                            @if($referral->referredBy->counselorProfile?->profile_picture)
                                <img src="{{ asset('storage/' . $referral->referredBy->counselorProfile->profile_picture) }}"
                                     alt="{{ $referral->referredBy->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($referral->referredBy->name, 0, 2)) }}
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $referral->referredBy->name }}</p>
                            <p class="text-xs text-blue-500 font-medium mt-0.5 truncate">
                                {{ $referral->referredBy->counselorProfile?->specialization ?? 'Counselor' }}
                            </p>
                            @if($referral->referredBy->counselorProfile?->office_location)
                                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="truncate">{{ $referral->referredBy->counselorProfile->office_location }}</span>
                                </p>
                            @endif
                        </div>
                    </div>
                @else
                    <p class="text-sm text-gray-400">No information available.</p>
                @endif
            </section>

            {{-- Referred To --}}
            <section class="bg-white rounded-2xl border border-gray-100 p-5">
                <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-4">Referred To</h3>
                @if($referral->referredTo)
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 text-sm font-bold shrink-0 overflow-hidden">
                            @if($referral->referredTo->counselorProfile?->profile_picture)
                                <img src="{{ asset('storage/' . $referral->referredTo->counselorProfile->profile_picture) }}"
                                     alt="{{ $referral->referredTo->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($referral->referredTo->name, 0, 2)) }}
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $referral->referredTo->name }}</p>
                            <p class="text-xs text-purple-500 font-medium mt-0.5 truncate">
                                {{ $referral->referredTo->counselorProfile?->specialization ?? 'Counselor' }}
                            </p>
                            @if($referral->referredTo->counselorProfile?->office_location)
                                <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="truncate">{{ $referral->referredTo->counselorProfile->office_location }}</span>
                                </p>
                            @endif
                        </div>
                    </div>
                @else
                    <p class="text-sm text-gray-400">No receiving counselor assigned yet.</p>
                @endif
            </section>

            {{-- Need help --}}
            <div class="bg-orange-50 rounded-2xl p-4 flex gap-3 items-start">
                <svg class="w-5 h-5 text-orange-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-orange-700">Questions about this referral?</p>
                    <p class="text-xs text-orange-500 mt-0.5 leading-relaxed">
                        Reach out to your counselor directly or visit the guidance office for any concerns.
                    </p>
                </div>
            </div>

        </aside>
    </div>

</div>

@endsection