@extends('CounselConnect.layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')

    {{-- ── Page Header ── --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Welcome back, Admin</h2>
        <p class="text-sm text-gray-400 mt-1">Your sanctuary for managing student well-being. Here's a summary of the current activity across the campus.</p>
    </div>

    {{-- ── Stats Cards ── --}}
    {{-- 2 cols on mobile → 3 on md → 6 on lg --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">

        {{-- Total Students --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center mb-3">
                <svg class="w-4.5 h-4.5 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_students']) }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Total Students</p>
        </div>

        {{-- Total Counselors --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="w-9 h-9 rounded-xl bg-green-50 flex items-center justify-center mb-3">
                <svg class="w-4.5 h-4.5 text-green-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_counselors']) }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Total Counselors</p>
        </div>

        {{-- Total Appointments --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center mb-3">
                <svg class="w-4.5 h-4.5 text-purple-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_appointments']) }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Total Appointments</p>
        </div>

        {{-- Pending Appointments --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center mb-3">
                <svg class="w-4.5 h-4.5 text-amber-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['pending_appointments']) }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Pending Appointments</p>
        </div>

        {{-- Completed Sessions --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center mb-3">
                <svg class="w-4.5 h-4.5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['completed_sessions']) }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Completed Sessions</p>
        </div>

        {{-- Pending Referrals --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="w-9 h-9 rounded-xl bg-rose-50 flex items-center justify-center mb-3">
                <svg class="w-4.5 h-4.5 text-rose-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                </svg>
            </div>
            <p class="text-2xl font-bold text-gray-900">{{ str_pad($stats['pending_referrals'], 2, '0', STR_PAD_LEFT) }}</p>
            <p class="text-xs text-gray-400 mt-0.5">Pending Referrals</p>
        </div>

    </div>

    {{-- ── Bottom Grid ── --}}
    {{-- Stacked on mobile → side-by-side (3/5 + 2/5) on lg --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- ── Left: Recent Appointments ── --}}
        <section class="col-span-full lg:col-span-3 bg-white rounded-2xl border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-semibold text-gray-900">Recent Appointments</h3>
                <a href="{{ route('admin.appointments.index') }}"
                   class="text-xs text-blue-600 hover:text-blue-700 font-medium transition-colors">
                    View All Records →
                </a>
            </div>

            @if($recentAppointments->isEmpty())
                <div class="text-center py-10">
                    <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm text-gray-400">No appointments yet.</p>
                </div>
            @else
                @php
                    $colors = [
                        'approved'  => 'bg-green-50 text-green-600',
                        'pending'   => 'bg-amber-50 text-amber-600',
                        'completed' => 'bg-blue-50 text-blue-600',
                        'cancelled' => 'bg-red-50 text-red-500',
                        'rejected'  => 'bg-red-50 text-red-500',
                    ];
                @endphp

                {{-- Mobile: Card layout (hidden on sm+) --}}
                <div class="sm:hidden space-y-3">
                    @foreach($recentAppointments as $appointment)
                    @php $colorCls = $colors[$appointment->status] ?? 'bg-gray-50 text-gray-500'; @endphp
                    <div class="flex items-start gap-3 p-3 rounded-xl border border-gray-100">
                        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xs font-semibold shrink-0 overflow-hidden mt-0.5">
                            @if($appointment->student->studentProfile?->profile_picture)
                                <img src="{{ asset('storage/' . $appointment->student->studentProfile->profile_picture) }}"
                                     class="w-full h-full object-cover"
                                     alt="{{ $appointment->student->name }}">
                            @else
                                {{ strtoupper(substr($appointment->student->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $appointment->student->name }}</p>
                                <span class="inline-flex px-2 py-0.5 rounded-lg text-xs font-semibold shrink-0 {{ $colorCls }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $appointment->counselor->name }}</p>
                            <div class="flex items-center justify-between mt-1.5">
                                <span class="text-xs text-gray-400">{{ $appointment->concern_type }}</span>
                                <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Desktop: Table layout (hidden below sm) --}}
                <div class="hidden sm:block">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left border-b border-gray-50">
                                <th class="text-xs font-medium text-gray-400 pb-3 pr-4">Student Name</th>
                                <th class="text-xs font-medium text-gray-400 pb-3 pr-4">Counselor</th>
                                <th class="text-xs font-medium text-gray-400 pb-3 pr-4">Concern</th>
                                <th class="text-xs font-medium text-gray-400 pb-3 pr-4">Date</th>
                                <th class="text-xs font-medium text-gray-400 pb-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($recentAppointments as $appointment)
                            @php $colorCls = $colors[$appointment->status] ?? 'bg-gray-50 text-gray-500'; @endphp
                                <tr class="group hover:bg-gray-50/50 transition-colors">
                                    <td class="py-3 pr-4">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xs font-semibold shrink-0 overflow-hidden">
                                                @if($appointment->student->studentProfile?->profile_picture)
                                                    <img src="{{ asset('storage/' . $appointment->student->studentProfile->profile_picture) }}"
                                                         class="w-full h-full object-cover"
                                                         alt="{{ $appointment->student->name }}">
                                                @else
                                                    {{ strtoupper(substr($appointment->student->name, 0, 1)) }}
                                                @endif
                                            </div>
                                            <span class="text-sm text-gray-800 font-medium">{{ $appointment->student->name }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 pr-4">
                                        <span class="text-sm text-gray-600">{{ $appointment->counselor->name }}</span>
                                    </td>
                                    <td class="py-3 pr-4">
                                        <span class="text-xs text-gray-500">{{ $appointment->concern_type }}</span>
                                    </td>
                                    <td class="py-3 pr-4">
                                        <span class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $colorCls }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        {{-- ── Right: Recent Referrals ── --}}
        <section class="col-span-full lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-sm font-semibold text-gray-900">Recent Referrals</h3>
                <a href="{{ route('admin.referrals.index') }}"
                   class="text-xs text-blue-600 hover:text-blue-700 font-medium transition-colors">
                    View All →
                </a>
            </div>
            <p class="text-xs text-gray-400 mb-5">Incoming clinical requests requiring review.</p>

            @if($recentReferrals->isEmpty())
                <div class="text-center py-10">
                    <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                    <p class="text-sm text-gray-400">No referrals yet.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($recentReferrals as $referral)
                        <div class="p-3.5 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors cursor-pointer">
                            <div class="flex items-center gap-2 mb-1.5">
                                @php
                                    $typeColor = $referral->type === 'internal'
                                        ? 'bg-blue-100 text-blue-600'
                                        : 'bg-purple-100 text-purple-600';
                                    $statusColor = $referral->status === 'pending'
                                        ? 'bg-amber-100 text-amber-600'
                                        : 'bg-green-100 text-green-600';
                                @endphp
                                <span class="text-xs font-semibold uppercase tracking-wide px-2 py-0.5 rounded-md {{ $typeColor }}">
                                    {{ $referral->type }}
                                </span>
                                <span class="text-xs text-gray-400">{{ $referral->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm font-semibold text-gray-800 leading-snug mb-1">
                                {{ Str::limit($referral->reason, 50) }}
                            </p>
                           <div class="flex items-center gap-2 mt-2">
                                <div class="w-5 h-5 rounded-full bg-blue-200 flex items-center justify-center text-blue-700 text-xs font-bold shrink-0 overflow-hidden">
                                    @if($referral->referredBy->counselorProfile?->profile_picture)
                                        <img src="{{ asset('storage/' . $referral->referredBy->counselorProfile->profile_picture) }}"
                                                class="w-full h-full object-cover"
                                                alt="{{ $referral->referredBy->name }}">
                                            @else
                                            {{ strtoupper(substr($referral->referredBy->name, 0, 1)) }}
                                            @endif
                                </div>
                                    <span class="text-xs text-gray-400">Ref by: {{ $referral->referredBy->name }}</span>
                                </div>
                        </div>
                    @endforeach
                </div>

                <a href="{{ route('admin.referrals.index') }}"
                   class="flex items-center justify-center gap-1.5 w-full mt-4 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors">
                    View All Referrals
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                    </svg>
                </a>
            @endif
        </section>

    </div>

@endsection