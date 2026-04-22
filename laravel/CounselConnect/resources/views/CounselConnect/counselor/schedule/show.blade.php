@extends('CounselConnect.layouts.counselor')

@section('title', 'Schedule Detail')
@section('page-title', 'Schedule')

@section('content')

{{-- ── Back Link ── --}}
<a href="{{ route('counselor.schedule.index') }}"
   class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 mb-6 transition-colors">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    Back to Schedule
</a>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Schedule Info Card ── --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-900">Slot Details</h2>
            </div>

            {{-- Details: 2-col grid on sm, stacked on mobile --}}
            <div class="px-6 py-5 grid grid-cols-2 gap-4 sm:grid-cols-2 lg:grid-cols-1">

                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Day</p>
                    <p class="text-sm font-medium text-gray-800">{{ $schedule->day_of_week }}</p>
                </div>

                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Time Range</p>
                    <p class="text-sm font-medium text-gray-800 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}
                        –
                        {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Slot Duration</p>
                    <p class="text-sm font-medium text-gray-800">{{ $schedule->slot_duration_mins }} minutes</p>
                </div>

                @php
                    $start      = \Carbon\Carbon::parse($schedule->start_time);
                    $end        = \Carbon\Carbon::parse($schedule->end_time);
                    $totalMins  = (int) $start->diffInMinutes($end);
                    $totalSlots = $totalMins > 0 ? floor($totalMins / $schedule->slot_duration_mins) : 0;
                @endphp
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Total Slots</p>
                    <p class="text-sm font-medium text-gray-800">{{ $totalSlots }} slots/week</p>
                </div>

                <div class="col-span-2 lg:col-span-1">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1">Status</p>
                    @if($schedule->is_active)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            Active
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                            Inactive
                        </span>
                    @endif
                </div>

            </div>

            {{-- Edit Action --}}
            <div class="px-6 pb-5">
                <a href="{{ route('counselor.schedule.edit', $schedule) }}"
                   class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit This Slot
                </a>
            </div>

        </div>
    </div>

    {{-- ── Appointments Linked to This Schedule ── --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Appointments in This Slot</h3>
                <p class="text-xs text-gray-400 mt-0.5">
                    {{ $schedule->appointments->count() }} {{ Str::plural('appointment', $schedule->appointments->count()) }} booked
                </p>
            </div>

            @if($schedule->appointments->isEmpty())
                <div class="px-6 py-12 text-center">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p class="text-sm text-gray-500">No appointments booked for this slot yet.</p>
                </div>
            @else
                <div class="divide-y divide-gray-50">
                    @foreach($schedule->appointments as $appointment)

                        {{-- Mobile layout --}}
                        <div class="px-4 py-4 sm:hidden">
                            <div class="flex items-center gap-3">
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

                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $appointment->student->name }}</p>
                                    <p class="text-xs text-gray-400">
                                        {{ $appointment->student->studentProfile?->department ?? '—' }}
                                        @if($appointment->student->studentProfile?->year_level)
                                            · {{ $appointment->student->studentProfile->year_level }}
                                        @endif
                                    </p>
                                    <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                        @php
                                            $statusColors = [
                                                'pending'   => 'bg-amber-50 text-amber-700',
                                                'approved'  => 'bg-blue-50 text-blue-700',
                                                'completed' => 'bg-green-50 text-green-700',
                                                'rejected'  => 'bg-red-50 text-red-500',
                                                'cancelled' => 'bg-gray-100 text-gray-500',
                                            ];
                                        @endphp
                                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                            {{ ucfirst(str_replace('_', ' ', $appointment->concern_type)) }}
                                        </span>
                                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-500' }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                        <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('counselor.appointments.show', $appointment) }}"
                                   class="shrink-0 text-xs text-blue-600 hover:underline">
                                    View
                                </a>
                            </div>
                        </div>

                        {{-- Desktop layout --}}
                        <div class="hidden sm:flex px-6 py-4 items-center gap-4">

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

                            {{-- Student Info --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $appointment->student->name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $appointment->student->studentProfile?->department ?? '—' }}
                                    @if($appointment->student->studentProfile?->year_level)
                                        · {{ $appointment->student->studentProfile->year_level }}
                                    @endif
                                </p>
                            </div>

                            {{-- Concern & Date --}}
                            <div class="text-right shrink-0">
                                <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 whitespace-nowrap">
                                    {{ ucfirst(str_replace('_', ' ', $appointment->concern_type)) }}
                                </span>
                                <p class="text-xs text-gray-400 mt-1 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }}
                                </p>
                            </div>

                            {{-- Status Badge --}}
                            @php
                                $statusColors = [
                                    'pending'   => 'bg-amber-50 text-amber-700',
                                    'approved'  => 'bg-blue-50 text-blue-700',
                                    'completed' => 'bg-green-50 text-green-700',
                                    'rejected'  => 'bg-red-50 text-red-500',
                                    'cancelled' => 'bg-gray-100 text-gray-500',
                                ];
                            @endphp
                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium shrink-0 whitespace-nowrap
                                         {{ $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-500' }}">
                                {{ ucfirst($appointment->status) }}
                            </span>

                            {{-- Link --}}
                            <a href="{{ route('counselor.appointments.show', $appointment) }}"
                               class="shrink-0 text-xs text-blue-600 hover:underline">
                                View
                            </a>

                        </div>

                    @endforeach
                </div>
            @endif

        </div>
    </div>

</div>

@endsection