@extends('CounselConnect.layouts.counselor')

@section('title', 'Session Records')
@section('page-title', 'Sessions')

@section('content')

{{-- ── Header ── --}}
<div class="flex flex-col gap-3 mb-6 sm:flex-row sm:items-center sm:justify-between">
    <p class="text-sm text-gray-500">A permanent log of all completed counseling sessions.</p>
    <div class="flex items-center gap-2 shrink-0">
        <a href="{{ route('counselor.sessions.index') }}"
           class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors
                  {{ ! request('follow_up') ? 'bg-blue-600 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            All Sessions
        </a>
        <a href="{{ route('counselor.sessions.index', ['follow_up' => 1]) }}"
           class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors
                  {{ request('follow_up') ? 'bg-blue-600 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' }}">
            Needs Follow-up
        </a>
    </div>
</div>

{{-- ── Flash ── --}}
@if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-xl bg-green-50 border border-green-100 text-green-700 text-sm">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

{{-- ── Table ── --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

    @if($records->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-center px-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-900">No session records found</h3>
            <p class="text-sm text-gray-400 mt-1">
                {{ request('follow_up') ? 'No sessions currently need a follow-up.' : 'Session records will appear here once appointments are completed.' }}
            </p>
        </div>
    @else

        {{-- ── Mobile Cards (hidden md+) ── --}}
        <div class="divide-y divide-gray-50 md:hidden">
            @foreach($records as $record)
                <div class="px-4 py-4 space-y-3">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                                @if($record->student->studentProfile?->profile_picture)
                                    <img src="{{ asset('storage/' . $record->student->studentProfile->profile_picture) }}"
                                         alt="{{ $record->student->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($record->student->name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $record->student->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ $record->student->studentProfile?->department ?? '—' }}</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 shrink-0">{{ $record->created_at->format('M d, Y') }}</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        @if($record->appointment)
                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                {{ ucfirst(str_replace('_', ' ', $record->appointment->concern_type)) }}
                            </span>
                        @endif
                        @if($record->follow_up_needed)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-600">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                Follow-up
                            </span>
                        @endif
                    </div>

                    <p class="text-sm text-gray-500 line-clamp-2">
                        {{ \Illuminate\Support\Str::limit($record->session_notes, 100) }}
                    </p>

                    <div class="flex items-center gap-2 pt-1">
                        <a href="{{ route('counselor.sessions.show', $record) }}"
                           class="flex-1 text-center px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                            View
                        </a>
                        <a href="{{ route('counselor.sessions.edit', $record) }}"
                           class="flex-1 text-center px-3 py-1.5 rounded-lg border border-blue-100 text-xs font-medium text-blue-600 hover:bg-blue-50 transition-colors">
                            Edit
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ── Desktop Table (hidden below md) ── --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Student</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Concern</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Session Notes</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Follow-up</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Date</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($records as $record)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                                        @if($record->student->studentProfile?->profile_picture)
                                            <img src="{{ asset('storage/' . $record->student->studentProfile->profile_picture) }}"
                                                 alt="{{ $record->student->name }}" class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($record->student->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $record->student->name }}</p>
                                        <p class="text-xs text-gray-400">{{ $record->student->studentProfile?->department ?? '—' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                @if($record->appointment)
                                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 whitespace-nowrap">
                                        {{ ucfirst(str_replace('_', ' ', $record->appointment->concern_type)) }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 max-w-xs">
                                <p class="text-sm text-gray-600 truncate">
                                    {{ \Illuminate\Support\Str::limit($record->session_notes, 60) }}
                                </p>
                            </td>
                            <td class="px-4 py-4">
                                @if($record->follow_up_needed)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-rose-50 text-rose-600">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Yes
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                        No
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <p class="text-sm text-gray-700">{{ $record->created_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-400">{{ $record->created_at->format('g:i A') }}</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('counselor.sessions.show', $record) }}"
                                       class="inline-flex items-center px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-colors">
                                        View
                                    </a>
                                    <a href="{{ route('counselor.sessions.edit', $record) }}"
                                       class="inline-flex items-center px-3 py-1.5 rounded-lg border border-blue-100 text-xs font-medium text-blue-600 hover:bg-blue-50 transition-colors">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($records->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-gray-100 flex flex-wrap items-center justify-between gap-3">
                <p class="text-xs text-gray-400">
                    Showing {{ $records->firstItem() }}–{{ $records->lastItem() }} of {{ $records->total() }} records
                </p>
                <div class="flex items-center gap-1 flex-wrap">
                    @if($records->onFirstPage())
                        <span class="px-3 py-1.5 rounded-lg text-xs text-gray-300 border border-gray-100 cursor-not-allowed">←</span>
                    @else
                        <a href="{{ $records->previousPageUrl() }}"
                           class="px-3 py-1.5 rounded-lg text-xs text-gray-600 border border-gray-200 hover:bg-gray-50 transition-colors">←</a>
                    @endif
                    @foreach($records->getUrlRange(max(1, $records->currentPage() - 2), min($records->lastPage(), $records->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}"
                           class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors
                                  {{ $page == $records->currentPage() ? 'bg-blue-600 text-white' : 'text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                            {{ $page }}
                        </a>
                    @endforeach
                    @if($records->hasMorePages())
                        <a href="{{ $records->nextPageUrl() }}"
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