@extends('CounselConnect.layouts.counselor')

@section('title', 'Appointments')
@section('page-title', 'Appointments')

@section('content')

{{-- ── Header ── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <p class="text-sm text-gray-500">Review and manage student appointment requests.</p>

    {{-- Status Filter — scrollable on mobile --}}
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
            <a href="{{ route('counselor.appointments.index', $s ? ['status' => $s] : []) }}"
               class="shrink-0 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors
                      {{ $active ? 'bg-blue-600 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
                {{ $labels[$s] }}
            </a>
        @endforeach
    </div>
</div>

{{-- ── Flash Message ── --}}
@if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-xl bg-green-50 border border-green-100 text-green-700 text-sm">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

{{-- ── Appointments Table ── --}}
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
        </div>
    @else

        {{-- ── Desktop Table (md and up) ── --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full min-w-[640px]">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Student</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Concern</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Preferred Date & Time</th>
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

                            {{-- Student --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                                        @if($appointment->student->studentProfile?->profile_picture)
                                            <img src="{{ asset('storage/' . $appointment->student->studentProfile->profile_picture) }}"
                                                 alt="{{ $appointment->student->name }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($appointment->student->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $appointment->student->name }}</p>
                                        <p class="text-xs text-gray-400">
                                            {{ $appointment->student->studentProfile?->department ?? '—' }}
                                            @if($appointment->student->studentProfile?->year_level)
                                                · {{ $appointment->student->studentProfile->year_level }}
                                            @endif
                                        </p>
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
                                <a href="{{ route('counselor.appointments.show', $appointment) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-colors">
                                    View
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ── Mobile Card List (below md) ── --}}
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

                    {{-- Top row: avatar + name + status --}}
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                                @if($appointment->student->studentProfile?->profile_picture)
                                    <img src="{{ asset('storage/' . $appointment->student->studentProfile->profile_picture) }}"
                                         alt="{{ $appointment->student->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($appointment->student->name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $appointment->student->name }}</p>
                                <p class="text-xs text-gray-400 truncate">
                                    {{ $appointment->student->studentProfile?->department ?? '—' }}
                                    @if($appointment->student->studentProfile?->year_level)
                                        · {{ $appointment->student->studentProfile->year_level }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <span class="inline-block shrink-0 px-2.5 py-1 rounded-full text-xs font-medium
                                     {{ $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-500' }}">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>

                    {{-- Meta row: concern + date --}}
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

                    {{-- Action --}}
                    <a href="{{ route('counselor.appointments.show', $appointment) }}"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-colors">
                        View Details →
                    </a>

                </div>
            @endforeach
        </div>

        {{-- ── Pagination ── --}}
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