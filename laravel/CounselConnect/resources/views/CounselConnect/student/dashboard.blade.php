@extends('CounselConnect.layouts.student')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

    {{-- ── Welcome + CTA ── --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6 sm:mb-8">
        <div>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Welcome back, <br>
                <span class="text-blue-600">{{ explode(' ', Auth::user()->name)[0] }}.</span>
            </h2>
            <p class="text-gray-500 text-sm mt-2">
                Your well-being is our priority.
                @if($stats['approved_appointments'] > 0)
                    You have <span class="font-semibold text-gray-700">{{ $stats['approved_appointments'] }} upcoming
                    {{ Str::plural('session', $stats['approved_appointments']) }}</span> this week. How are you feeling today?
                @else
                    You have no upcoming sessions this week. How are you feeling today?
                @endif
            </p>
        </div>

        <div class="flex flex-wrap gap-2 sm:gap-3 shrink-0">
            <a href="{{ route('student.appointments.create') }}"
               class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 sm:px-5 py-2.5 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Book Appointment
            </a>
            <a href="https://www.thementalhealthcoalition.org/resources/" target="_blank"
               class="flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-100 text-gray-700 text-sm font-medium px-4 sm:px-5 py-2.5 rounded-xl transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.75 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                View Resources
            </a>
        </div>
    </div>

    {{-- ── Stat Cards ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6 sm:mb-8">

        {{-- Approved / Upcoming --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-3xl font-bold text-gray-900">{{ str_pad($stats['approved_appointments'], 2, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-sm font-medium text-gray-700 mt-1">Upcoming Appointments</p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        @if($recentAppointments->where('status', 'approved')->first()?->scheduled_at)
                            Next: {{ \Carbon\Carbon::parse($recentAppointments->where('status', 'approved')->first()->scheduled_at)->format('D \a\t g:i A') }}
                        @else
                            No confirmed sessions yet
                        @endif
                    </p>
                </div>
                <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Completed --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-3xl font-bold text-gray-900">{{ str_pad($stats['completed_appointments'], 2, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-sm font-medium text-gray-700 mt-1">Completed Sessions</p>
                    <p class="text-xs text-gray-400 mt-0.5">Since January {{ date('Y') }}</p>
                </div>
                <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Pending --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-3xl font-bold text-gray-900">{{ str_pad($stats['pending_appointments'], 2, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-sm font-medium text-gray-700 mt-1">Pending Appointments</p>
                    <p class="text-xs text-gray-400 mt-0.5">Awaiting counselor review</p>
                </div>
                <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Two Column: Appointments + Announcements ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        {{-- Recent Appointments Table (3/5 width on lg+) --}}
        <div class="lg:col-span-3 bg-white rounded-2xl border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-900">Upcoming Appointments</h3>
                <a href="{{ route('student.appointments.index') }}" class="text-xs text-blue-500 hover:text-blue-700 font-medium">View All</a>
            </div>

            @if($recentAppointments->isEmpty())
                <div class="text-center py-10">
                    <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm text-gray-400">No appointments yet</p>
                    <a href="{{ route('student.appointments.create') }}" class="text-xs text-blue-500 hover:underline mt-1 inline-block">Book one now</a>
                </div>
            @else
                @php
                    $statusClasses = [
                        'approved'  => 'bg-green-50 text-green-600',
                        'pending'   => 'bg-yellow-50 text-yellow-600',
                        'completed' => 'bg-blue-50 text-blue-600',
                        'cancelled' => 'bg-red-50 text-red-500',
                        'rejected'  => 'bg-red-50 text-red-500',
                    ];
                @endphp

                {{-- Mobile: Card layout (hidden on sm+) --}}
                <div class="sm:hidden space-y-3">
                    @foreach($recentAppointments as $appointment)
                    @php $cls = $statusClasses[$appointment->status] ?? 'bg-gray-50 text-gray-500'; @endphp
                    <div class="flex items-start gap-3 p-3 rounded-xl border border-gray-100">
                        <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $appointment->concern_type }}</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-medium shrink-0 {{ $cls }}">
                                    {{ strtoupper($appointment->status) }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-400 mt-0.5">
                                @if($appointment->scheduled_at)
                                    {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('M d, Y · g:i A') }}
                                @else
                                    <span class="text-gray-300">TBD</span>
                                @endif
                            </p>
                        </div>
                        <a href="{{ route('student.appointments.show', $appointment) }}"
                           class="text-gray-300 hover:text-gray-500 transition-colors self-center shrink-0">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/>
                            </svg>
                        </a>
                    </div>
                    @endforeach
                </div>

                {{-- Desktop: Table layout (hidden below sm) --}}
                <div class="hidden sm:block">
                    <table class="w-full">
                        <thead>
                            <tr class="text-xs text-gray-400 uppercase tracking-wide border-b border-gray-50">
                                <th class="text-left pb-3 font-medium">Concern Type</th>
                                <th class="text-left pb-3 font-medium">Date & Time</th>
                                <th class="text-left pb-3 font-medium">Status</th>
                                <th class="pb-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($recentAppointments as $appointment)
                            @php $cls = $statusClasses[$appointment->status] ?? 'bg-gray-50 text-gray-500'; @endphp
                            <tr class="text-sm">
                                <td class="py-3.5">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                                            <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $appointment->concern_type }}</span>
                                    </div>
                                </td>
                                <td class="py-3.5 text-gray-500 text-xs">
                                    @if($appointment->scheduled_at)
                                        {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('M d, Y') }}<br>
                                        {{ \Carbon\Carbon::parse($appointment->scheduled_at)->format('g:i A') }}
                                    @else
                                        <span class="text-gray-300">TBD</span>
                                    @endif
                                </td>
                                <td class="py-3.5">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium {{ $cls }}">
                                        {{ strtoupper($appointment->status) }}
                                    </span>
                                </td>
                                <td class="py-3.5 text-right">
                                    <a href="{{ route('student.appointments.show', $appointment) }}"
                                       class="text-gray-300 hover:text-gray-500 transition-colors">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Announcements (2/5 width on lg+) --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-5">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-gray-900">Announcements</h3>
                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                </svg>
            </div>

            @if($announcements->isEmpty())
                <p class="text-sm text-gray-400 text-center py-8">No announcements yet.</p>
            @else
                <div class="space-y-3 overflow-y-auto max-h-72">
                    @foreach($announcements as $announcement)
                    <div class="p-3 rounded-xl border border-gray-50 bg-gray-50/50 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-semibold text-blue-500 uppercase tracking-wide">
                                {{ $announcement->audience === 'all' ? 'All Students' : ucfirst($announcement->audience) }}
                            </span>
                            <span class="text-xs text-gray-400">
                                {{ \Carbon\Carbon::parse($announcement->created_at)->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-sm font-semibold text-gray-800">{{ $announcement->title }}</p>
                        <p class="text-xs text-gray-500 mt-0.5 line-clamp-2">{{ $announcement->body }}</p>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

@endsection