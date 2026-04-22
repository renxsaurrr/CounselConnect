@extends('CounselConnect.layouts.counselor')

@section('title', $student->name)
@section('page-title', 'Students')

@section('content')

{{-- ── Back Link ── --}}
<a href="{{ route('counselor.students.index') }}"
   class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 mb-6 transition-colors">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
    </svg>
    Back to Students
</a>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Left: Student Profile Card ── --}}
    <div class="lg:col-span-1 space-y-5">

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            {{-- Avatar + Name --}}
            <div class="px-6 py-6 flex flex-col items-center text-center border-b border-gray-100">
                <div class="w-16 h-16 rounded-full bg-blue-600 flex items-center justify-center text-white text-xl font-bold mb-3 overflow-hidden shrink-0">
                    @if($student->studentProfile?->profile_picture)
                        <img src="{{ asset('storage/' . $student->studentProfile->profile_picture) }}"
                             alt="{{ $student->name }}"
                             class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($student->name, 0, 1)) }}
                    @endif
                </div>
                <h2 class="text-base font-semibold text-gray-900 break-words">{{ $student->name }}</h2>
                <p class="text-xs text-gray-400 mt-0.5 break-all">{{ $student->email }}</p>
                @if($student->studentProfile?->department)
                    <span class="mt-2 inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 text-center">
                        {{ $student->studentProfile->department }}
                    </span>
                @endif
            </div>

            {{-- Profile Details --}}
            <div class="px-6 py-5 space-y-3.5">

                @if($student->studentProfile?->student_id)
                    <div class="flex items-center justify-between gap-4">
                        <p class="text-xs text-gray-400 shrink-0">Student ID</p>
                        <p class="text-sm font-medium text-gray-800 font-mono text-right">{{ $student->studentProfile->student_id }}</p>
                    </div>
                @endif

                @if($student->studentProfile?->year_level)
                    <div class="flex items-center justify-between gap-4">
                        <p class="text-xs text-gray-400 shrink-0">Year Level</p>
                        <p class="text-sm font-medium text-gray-800 text-right">{{ $student->studentProfile->year_level }}</p>
                    </div>
                @endif

                <div class="flex items-center justify-between gap-4">
                    <p class="text-xs text-gray-400 shrink-0">Total Appointments</p>
                    <p class="text-sm font-semibold text-blue-600">{{ $appointments->count() }}</p>
                </div>

                <div class="flex items-center justify-between gap-4">
                    <p class="text-xs text-gray-400 shrink-0">Session Records</p>
                    <p class="text-sm font-semibold text-blue-600">{{ $sessionRecords->count() }}</p>
                </div>

                @if($sessionRecords->where('follow_up_needed', true)->count() > 0)
                    <div class="flex items-center justify-between gap-4">
                        <p class="text-xs text-gray-400 shrink-0">Follow-ups Needed</p>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 shrink-0"></span>
                            {{ $sessionRecords->where('follow_up_needed', true)->count() }}
                        </span>
                    </div>
                @endif

            </div>

            {{-- Bio --}}
            @if($student->studentProfile?->bio)
                <div class="px-6 pb-5">
                    <p class="text-xs text-gray-400 uppercase tracking-wide mb-1.5">Bio</p>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $student->studentProfile->bio }}</p>
                </div>
            @endif

        </div>

    </div>

    {{-- ── Right: Appointments + Session Records ── --}}
    <div class="lg:col-span-2 space-y-5">

        {{-- Appointments History --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Appointment History</h3>
                <p class="text-xs text-gray-400 mt-0.5">{{ $appointments->count() }} {{ Str::plural('appointment', $appointments->count()) }} with you</p>
            </div>

            @if($appointments->isEmpty())
                <div class="px-6 py-10 text-center">
                    <p class="text-sm text-gray-400">No appointments recorded.</p>
                </div>
            @else

                {{-- Mobile: Card layout --}}
                <div class="divide-y divide-gray-50 sm:hidden">
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
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0 space-y-1.5">
                                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                        {{ ucfirst(str_replace('_', ' ', $appointment->concern_type)) }}
                                    </span>
                                    <div>
                                        <p class="text-sm text-gray-800">{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($appointment->preferred_time)->format('g:i A') }}</p>
                                    </div>
                                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-500' }}">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </div>
                                <a href="{{ route('counselor.appointments.show', $appointment) }}"
                                   class="shrink-0 text-xs text-blue-600 hover:underline pt-1">
                                    View
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Desktop: Table layout --}}
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full min-w-[480px]">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Concern</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Preferred Date</th>
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
                                    <td class="px-6 py-3.5">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 whitespace-nowrap">
                                            {{ ucfirst(str_replace('_', ' ', $appointment->concern_type)) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap">
                                        <p class="text-sm text-gray-800">{{ \Carbon\Carbon::parse($appointment->preferred_date)->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($appointment->preferred_time)->format('g:i A') }}</p>
                                    </td>
                                    <td class="px-4 py-3.5 whitespace-nowrap">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium
                                                     {{ $statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-500' }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3.5 text-right whitespace-nowrap">
                                        <a href="{{ route('counselor.appointments.show', $appointment) }}"
                                           class="text-xs text-blue-600 hover:underline">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>

        {{-- Session Records --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-900">Session Records</h3>
                <p class="text-xs text-gray-400 mt-0.5">{{ $sessionRecords->count() }} {{ Str::plural('record', $sessionRecords->count()) }}</p>
            </div>

            @if($sessionRecords->isEmpty())
                <div class="px-6 py-10 text-center">
                    <p class="text-sm text-gray-400">No session records yet.</p>
                </div>
            @else
                <div class="divide-y divide-gray-50">
                    @foreach($sessionRecords as $record)
                        <div class="px-4 py-4 sm:px-6">

                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">

                                    {{-- Date + Badges --}}
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <p class="text-xs font-semibold text-gray-500 whitespace-nowrap">
                                            {{ $record->created_at->format('M d, Y') }}
                                        </p>
                                        @if($record->follow_up_needed)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-600 whitespace-nowrap">
                                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 shrink-0"></span>
                                                Follow-up needed
                                            </span>
                                        @endif
                                        @if($record->next_session_date)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-600 whitespace-nowrap">
                                                Next: {{ \Carbon\Carbon::parse($record->next_session_date)->format('M d, Y') }}
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Session Notes --}}
                                    @if($record->session_notes)
                                        <p class="text-sm text-gray-700 leading-relaxed mb-2 break-words">
                                            {{ \Illuminate\Support\Str::limit($record->session_notes, 200) }}
                                        </p>
                                    @endif

                                    {{-- Intervention --}}
                                    @if($record->intervention)
                                        <div class="flex items-start gap-2 mt-1.5">
                                            <span class="text-xs text-gray-400 shrink-0 mt-0.5">Intervention:</span>
                                            <p class="text-xs text-gray-600 break-words">{{ $record->intervention }}</p>
                                        </div>
                                    @endif

                                </div>

                                <a href="{{ route('counselor.sessions.show', $record) }}"
                                   class="shrink-0 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-colors">
                                    View
                                </a>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>

    </div>

</div>

@endsection