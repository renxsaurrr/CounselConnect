@extends('CounselConnect.layouts.student')

@section('title', 'My Appointments')
@section('page-title', 'My Appointments')

@section('content')

{{-- ── Flash Message ── --}}
@if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-xl bg-green-50 border border-green-100 text-green-700 text-sm">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

{{-- ── Pending Counselor Invites Banner ── --}}
{{-- Shown only when a counselor has invited this student and they haven't responded yet --}}
@if($pendingInvites->isNotEmpty())
    <div class="mb-6 space-y-3">
        <div class="flex items-center gap-2 mb-1">
            <div class="w-2 h-2 rounded-full bg-purple-500 animate-pulse"></div>
            <p class="text-sm font-semibold text-gray-800">
                You have {{ $pendingInvites->count() }} pending invitation{{ $pendingInvites->count() > 1 ? 's' : '' }} from a counselor
            </p>
        </div>

        @foreach($pendingInvites as $invite)
            <div class="bg-white border border-purple-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="px-5 py-4">

                    {{-- Counselor info --}}
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                                @if($invite->counselor->counselorProfile?->profile_picture)
                                    <img src="{{ asset('storage/' . $invite->counselor->counselorProfile->profile_picture) }}"
                                         alt="{{ $invite->counselor->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($invite->counselor->name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-gray-900">{{ $invite->counselor->name }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ $invite->counselor->counselorProfile?->specialization ?? 'Counselor' }}
                                </p>
                            </div>
                        </div>

                        <span class="inline-flex items-center gap-1 shrink-0 px-2.5 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Invitation
                        </span>
                    </div>

                    {{-- Appointment details --}}
                    <div class="mt-3 flex flex-wrap gap-x-5 gap-y-1.5 text-xs text-gray-500">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($invite->preferred_date)->format('F d, Y') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($invite->preferred_time)->format('g:i A') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                            </svg>
                            {{ $invite->concern_type }}
                        </span>
                    </div>

                    @if($invite->notes)
                        <p class="mt-2 text-xs text-gray-600 bg-gray-50 rounded-lg px-3 py-2 italic">
                            "{{ $invite->notes }}"
                        </p>
                    @endif

                    {{-- Accept / Decline --}}
                    <div class="mt-4 flex items-center gap-3">
                        <form action="{{ route('student.appointments.accept-invite', $invite) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium
                                           bg-green-600 text-white hover:bg-green-700 active:bg-green-800 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                Accept
                            </button>
                        </form>

                        <form action="{{ route('student.appointments.decline-invite', $invite) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    onclick="return confirm('Are you sure you want to decline this invitation?')"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium
                                           border border-gray-200 text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Decline
                            </button>
                        </form>

                        <a href="{{ route('student.appointments.show', $invite) }}"
                           class="text-xs text-blue-600 hover:underline ml-1">
                            View details
                        </a>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- ── Header ── --}}
<div class="flex flex-col gap-3 mb-4">

    {{-- Row 1: Description + Book Appointment button --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <p class="text-sm text-gray-500">Track and manage your counseling appointments.</p>

        <a href="{{ route('student.appointments.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-blue-600 text-white
                  hover:bg-blue-700 active:bg-blue-800 transition-colors shadow-sm shrink-0 self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Book Appointment
        </a>
    </div>

    {{-- Row 2: Status Filters --}}
    <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0 flex-nowrap sm:flex-wrap">
        <span class="text-xs text-gray-400 font-medium uppercase tracking-wide mr-1 shrink-0">Filter:</span>
        @foreach(['', 'pending', 'approved', 'completed', 'rejected', 'cancelled'] as $s)
            @php
                $labels = [
                    ''          => 'All',
                    'pending'   => 'Pending',
                    'approved'  => 'Approved',
                    'completed' => 'Completed',
                    'rejected'  => 'Rejected',
                    'cancelled' => 'Cancelled',
                ];
                $active = request('status', '') === $s;
            @endphp
            <a href="{{ route('student.appointments.index', $s ? ['status' => $s] : []) }}"
               class="shrink-0 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors
                      {{ $active ? 'bg-blue-600 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                {{ $labels[$s] }}
            </a>
        @endforeach
    </div>

</div>

{{-- ── Appointments List ── --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

    @if($appointments->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-center px-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-900">No appointments found</h3>
            <p class="text-sm text-gray-400 mt-1">
                {{ request('status') ? 'No ' . request('status') . ' appointments at this time.' : 'You have no appointments yet.' }}
            </p>
            <a href="{{ route('student.appointments.create') }}"
               class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                Book an Appointment
            </a>
        </div>
    @else

        {{-- Desktop Table --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full min-w-[640px]">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Counselor</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Concern</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Date & Time</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($appointments as $appointment)
                        @php
                            $statusColors = [
                                'pending'   => 'bg-amber-50 text-amber-700',
                                'approved'  => 'bg-blue-50 text-blue-700',
                                'completed' => 'bg-green-50 text-green-700',
                                'rejected'  => 'bg-red-50 text-red-500',
                                'cancelled' => 'bg-gray-100 text-gray-500',
                            ];
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">

                            {{-- Counselor --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                                        @if($appointment->counselor->counselorProfile?->profile_picture)
                                            <img src="{{ asset('storage/' . $appointment->counselor->counselorProfile->profile_picture) }}"
                                                 alt="{{ $appointment->counselor->name }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($appointment->counselor->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $appointment->counselor->name }}</p>
                                        @if($appointment->isCounselorInitiated())
                                            <p class="text-xs text-purple-600 mt-0.5">Invited you</p>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Concern --}}
                            <td class="px-4 py-4">
                                <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 whitespace-nowrap">
                                    {{ ucfirst(str_replace('_', ' ', $appointment->concern_type)) }}
                                </span>
                            </td>

                            {{-- Date & Time --}}
                            <td class="px-4 py-4">
                                <p class="text-sm font-medium text-gray-800">
                                    {{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ \Carbon\Carbon::parse($appointment->preferred_time)->format('g:i A') }}
                                </p>
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-4">
                                <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium whitespace-nowrap
                                             {{ $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-500' }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('student.appointments.show', $appointment) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-colors">
                                    View
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile Card List --}}
        <div class="md:hidden divide-y divide-gray-100">
            @foreach($appointments as $appointment)
                @php
                    $statusColors = [
                        'pending'   => 'bg-amber-50 text-amber-700',
                        'approved'  => 'bg-blue-50 text-blue-700',
                        'completed' => 'bg-green-50 text-green-700',
                        'rejected'  => 'bg-red-50 text-red-500',
                        'cancelled' => 'bg-gray-100 text-gray-500',
                    ];
                @endphp
                <div class="px-4 py-4">
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                                @if($appointment->counselor->counselorProfile?->profile_picture)
                                    <img src="{{ asset('storage/' . $appointment->counselor->counselorProfile->profile_picture) }}"
                                         alt="{{ $appointment->counselor->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($appointment->counselor->name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $appointment->counselor->name }}</p>
                                @if($appointment->isCounselorInitiated())
                                    <p class="text-xs text-purple-600">Invited you</p>
                                @endif
                            </div>
                        </div>
                        <span class="inline-block shrink-0 px-2.5 py-1 rounded-full text-xs font-medium
                                     {{ $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-500' }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mb-3">
                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                            {{ ucfirst(str_replace('_', ' ', $appointment->concern_type)) }}
                        </span>
                        <div class="flex items-center gap-1.5 text-xs text-gray-500">
                            <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }}
                            &middot;
                            {{ \Carbon\Carbon::parse($appointment->preferred_time)->format('g:i A') }}
                        </div>
                    </div>

                    <a href="{{ route('student.appointments.show', $appointment) }}"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-colors">
                        View Details →
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($appointments->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <p class="text-xs text-gray-400">
                    Showing {{ $appointments->firstItem() }}–{{ $appointments->lastItem() }} of {{ $appointments->total() }} appointments
                </p>
                <div class="flex items-center gap-1 flex-wrap">
                    @if($appointments->onFirstPage())
                        <span class="px-3 py-1.5 rounded-lg text-xs text-gray-300 border border-gray-100 cursor-not-allowed">←</span>
                    @else
                        <a href="{{ $appointments->previousPageUrl() }}"
                           class="px-3 py-1.5 rounded-lg text-xs text-gray-600 border border-gray-200 hover:bg-gray-50 transition-colors">←</a>
                    @endif

                    @foreach($appointments->getUrlRange(max(1, $appointments->currentPage() - 2), min($appointments->lastPage(), $appointments->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}"
                           class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors
                                  {{ $page == $appointments->currentPage() ? 'bg-blue-600 text-white' : 'text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    @if($appointments->hasMorePages())
                        <a href="{{ $appointments->nextPageUrl() }}"
                           class="px-3 py-1.5 rounded-lg text-xs text-gray-600 border border-gray-200 hover:bg-gray-50 transition-colors">→</a>
                    @else
                        <span class="px-3 py-1.5 rounded-lg text-xs text-gray-300 border border-gray-100 cursor-not-allowed">→</span>
                    @endif
                </div>
            </div>
        @endif

    @endif

</div>

@endsection