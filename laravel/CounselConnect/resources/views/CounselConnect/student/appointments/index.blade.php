@extends('CounselConnect.layouts.student')

@section('title', 'Appointments')
@section('page-title', 'Appointments')

@section('content')

    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">My Appointments</h2>
            <p class="text-sm text-gray-500 mt-0.5">Track and manage all your counseling sessions.</p>
        </div>
        <a href="{{ route('student.appointments.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl transition-colors self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Book Appointment
        </a>
    </div>

    {{-- ── Flash Message ── --}}
    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-100 text-green-700 text-sm px-4 py-3 rounded-xl">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Status Filter Tabs (scrollable on mobile) ── --}}
    <div class="flex items-center gap-2 mb-5 overflow-x-auto pb-1 -mx-1 px-1">
        @foreach(['', 'pending', 'approved', 'completed', 'cancelled', 'rejected'] as $filterStatus)
            <a href="{{ route('student.appointments.index', $filterStatus ? ['status' => $filterStatus] : []) }}"
               class="px-3.5 py-1.5 rounded-lg text-xs font-medium transition-colors whitespace-nowrap
                      {{ request('status') === $filterStatus || (request('status') === null && $filterStatus === '')
                          ? 'bg-blue-600 text-white'
                          : 'bg-white border border-gray-200 text-gray-500 hover:border-blue-300 hover:text-blue-600' }}">
                {{ $filterStatus === '' ? 'All' : ucfirst($filterStatus) }}
            </a>
        @endforeach
    </div>

    {{-- ── Appointments Table ── --}}
    <section class="bg-white rounded-2xl border border-gray-100">

        @if($appointments->isEmpty())
            <div class="text-center py-16">
                <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-sm font-medium text-gray-400">No appointments found</p>
                <a href="{{ route('student.appointments.create') }}" class="text-xs text-blue-500 hover:underline mt-1 inline-block">Book your first session</a>
            </div>
        @else

            {{-- Desktop Table (md+) --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-xs text-gray-400 uppercase tracking-wide border-b border-gray-100">
                            <th class="text-left px-6 py-4 font-medium">Concern</th>
                            <th class="text-left px-6 py-4 font-medium">Counselor</th>
                            <th class="text-left px-6 py-4 font-medium">Preferred Date</th>
                            <th class="text-left px-6 py-4 font-medium">Scheduled At</th>
                            <th class="text-left px-6 py-4 font-medium">Status</th>
                            <th class="px-6 py-4"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($appointments as $appointment)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-800">{{ $appointment->concern_type }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($appointment->counselor)
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $appointment->counselor->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $appointment->counselor->counselorProfile?->specialization ?? '—' }}</p>
                                    </div>
                                @else
                                    <span class="text-sm text-gray-300">Not assigned</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }}<br>
                                <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($appointment->preferred_time)->format('g:i A') }}</span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if($appointment->scheduled_at)
                                    {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('M d, Y') }}<br>
                                    <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('g:i A') }}</span>
                                @else
                                    <span class="text-xs text-gray-300">Pending approval</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusClasses = [
                                        'approved'  => 'bg-green-50 text-green-600',
                                        'pending'   => 'bg-yellow-50 text-yellow-600',
                                        'completed' => 'bg-blue-50 text-blue-600',
                                        'cancelled' => 'bg-red-50 text-red-500',
                                        'rejected'  => 'bg-red-50 text-red-500',
                                    ];
                                    $cls = $statusClasses[$appointment->status] ?? 'bg-gray-50 text-gray-500';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium {{ $cls }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('student.appointments.show', $appointment) }}"
                                   class="text-xs text-blue-500 hover:text-blue-700 font-medium">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile Card List (< md) --}}
            <div class="md:hidden divide-y divide-gray-50">
                @foreach($appointments as $appointment)
                    @php
                        $statusClasses = [
                            'approved'  => 'bg-green-50 text-green-600',
                            'pending'   => 'bg-yellow-50 text-yellow-600',
                            'completed' => 'bg-blue-50 text-blue-600',
                            'cancelled' => 'bg-red-50 text-red-500',
                            'rejected'  => 'bg-red-50 text-red-500',
                        ];
                        $cls = $statusClasses[$appointment->status] ?? 'bg-gray-50 text-gray-500';
                    @endphp
                    <div class="px-4 py-4">
                        <div class="flex items-start justify-between gap-3 mb-2">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold text-gray-800 truncate">{{ $appointment->concern_type }}</span>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium shrink-0 {{ $cls }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-y-1 text-xs text-gray-500 ml-10.5 pl-0.5 mb-3">
                            <div>
                                <span class="text-gray-400">Counselor: </span>
                                {{ $appointment->counselor?->name ?? 'Not assigned' }}
                            </div>
                            <div>
                                <span class="text-gray-400">Preferred: </span>
                                {{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }}
                            </div>
                            <div class="col-span-2">
                                <span class="text-gray-400">Scheduled: </span>
                                @if($appointment->scheduled_at)
                                    {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('M d, Y · g:i A') }}
                                @else
                                    <span class="text-gray-300">Pending approval</span>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('student.appointments.show', $appointment) }}"
                           class="text-xs text-blue-500 hover:text-blue-700 font-medium">View details →</a>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($appointments->hasPages())
                <div class="px-4 sm:px-6 py-4 border-t border-gray-100">
                    {{ $appointments->withQueryString()->links() }}
                </div>
            @endif
        @endif

    </section>

@endsection