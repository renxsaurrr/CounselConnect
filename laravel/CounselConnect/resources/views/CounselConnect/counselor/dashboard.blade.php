@extends('CounselConnect.layouts.counselor')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- ── Welcome Banner ── --}}
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">
        Welcome back, {{ Auth::user()->name }}
    </h2>
    <p class="text-sm text-gray-500 mt-1">
        Here's what's happening with your sessions today.
    </p>
</div>

{{-- ── Stats Grid ── --}}
<div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">

    {{-- Pending Appointments --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col gap-3 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_appointments'] }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Pending Appointments</p>
        </div>
    </div>

    {{-- Approved Appointments --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col gap-3 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['approved_appointments'] }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Approved Appointments</p>
        </div>
    </div>

    {{-- Completed Sessions --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col gap-3 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['completed_sessions'] }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Completed Sessions</p>
        </div>
    </div>

    {{-- Follow-ups Needed --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col gap-3 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center">
            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['follow_ups_needed'] }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Follow-ups Needed</p>
        </div>
    </div>

    {{-- Pending Referrals --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col gap-3 shadow-sm">
        <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_referrals'] }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Pending Referrals</p>
        </div>
    </div>

</div>

{{-- ── Two-Column Content ── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- ── Upcoming Appointments (Approved) ── --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-gray-900">Upcoming Appointments</h3>
                <p class="text-xs text-gray-400 mt-0.5">Approved & scheduled</p>
            </div>
            <a href="{{ route('counselor.appointments.index') }}"
               class="text-xs text-blue-600 font-medium hover:underline">
                View all →
            </a>
        </div>

        <div class="divide-y divide-gray-50">
            @forelse($upcomingAppointments as $appointment)
                <div class="px-6 py-4 flex items-start gap-4 hover:bg-gray-50 transition-colors">

                    {{-- Avatar --}}
                    <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                        @if($appointment->student->studentProfile?->profile_picture)
                            <img src="{{ asset('storage/' . $appointment->student->studentProfile->profile_picture) }}"
                                 alt="{{ $appointment->student->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($appointment->student->name, 0, 1)) }}
                        @endif
                    </div>

                    {{-- Details --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            {{ $appointment->student->name }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $appointment->student->studentProfile?->department ?? 'No department' }}
                        </p>
                        <span class="inline-flex items-center mt-1.5 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                            {{ ucfirst(str_replace('_', ' ', $appointment->concern_type)) }}
                        </span>
                    </div>

                    {{-- Time --}}
                    <div class="text-right shrink-0">
                        <p class="text-xs font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($appointment->preferred_time)->format('g:i A') }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d') }}
                        </p>
                        <a href="{{ route('counselor.appointments.show', $appointment) }}"
                           class="inline-block mt-1.5 text-xs text-blue-600 hover:underline">
                            View
                        </a>
                    </div>

                </div>
            @empty
                <div class="px-6 py-10 text-center">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500">No upcoming appointments</p>
                </div>
            @endforelse
        </div>

    </div>

    {{-- ── Pending Appointments (Needs Review) ── --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-gray-900">Pending Requests</h3>
                <p class="text-xs text-gray-400 mt-0.5">Awaiting your review</p>
            </div>
            <a href="{{ route('counselor.appointments.index', ['status' => 'pending']) }}"
               class="text-xs text-blue-600 font-medium hover:underline">
                View all →
            </a>
        </div>

        <div class="divide-y divide-gray-50">
            @forelse($pendingAppointments as $appointment)
                <div class="px-6 py-4 flex items-start gap-4 hover:bg-gray-50 transition-colors">

                    {{-- Avatar --}}
                    <div class="w-9 h-9 rounded-full bg-gray-700 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                        @if($appointment->student->studentProfile?->profile_picture)
                            <img src="{{ asset('storage/' . $appointment->student->studentProfile->profile_picture) }}"
                                 alt="{{ $appointment->student->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($appointment->student->name, 0, 1)) }}
                        @endif
                    </div>

                    {{-- Details --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            {{ $appointment->student->name }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $appointment->student->studentProfile?->department ?? 'No department' }}
                            @if($appointment->student->studentProfile?->year_level)
                                · {{ $appointment->student->studentProfile->year_level }}
                            @endif
                        </p>
                        <span class="inline-flex items-center mt-1.5 px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">
                            {{ ucfirst(str_replace('_', ' ', $appointment->concern_type)) }}
                        </span>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col items-end gap-1.5 shrink-0">
                        <p class="text-xs text-gray-400">
                            {{ $appointment->created_at->diffForHumans() }}
                        </p>
                        <a href="{{ route('counselor.appointments.show', $appointment) }}"
                           class="inline-flex items-center gap-1 px-3 py-1 rounded-lg bg-blue-600 text-white text-xs font-medium hover:bg-blue-700 transition-colors">
                            Review
                        </a>
                    </div>

                </div>
            @empty
                <div class="px-6 py-10 text-center">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500">No pending requests</p>
                </div>
            @endforelse
        </div>

    </div>

</div>

@endsection