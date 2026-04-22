@extends('CounselConnect.layouts.counselor')

@section('title', 'Students')
@section('page-title', 'Students')

@section('content')

{{-- ── Header ── --}}
<div class="flex flex-col gap-3 mb-6 sm:flex-row sm:items-center sm:justify-between">
    <p class="text-sm text-gray-500">Students who have had appointments with you.</p>

    {{-- Search --}}
    <form method="GET" action="{{ route('counselor.students.index') }}" class="flex flex-col gap-2 sm:flex-row sm:items-center">

        <div class="relative w-full sm:w-52">
            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search students..."
                   class="w-full pl-9 pr-4 py-2 text-sm bg-white border border-gray-200 rounded-xl text-gray-700 placeholder-gray-400
                          focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
        </div>

        {{-- Search Submit (visible on mobile since onchange won't trigger for text input) --}}
        <button type="submit"
                class="sm:hidden w-full px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition-colors">
            Search
        </button>

        @if(request('search'))
            <a href="{{ route('counselor.students.index') }}"
               class="text-center px-3 py-2 rounded-xl border border-gray-200 text-xs font-medium text-gray-500 hover:bg-gray-50 transition-colors whitespace-nowrap">
                Clear
            </a>
        @endif
    </form>
</div>

{{-- ── Students Table ── --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

    @if($students->isEmpty())
        <div class="flex flex-col items-center justify-center py-20 text-center px-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-900">No students found</h3>
            <p class="text-sm text-gray-400 mt-1">
                {{ request('search') || request('department') ? 'Try adjusting your search or filter.' : 'Students will appear here once they book an appointment with you.' }}
            </p>
        </div>
    @else

        {{-- ── Mobile Card View (< md) ── --}}
        <div class="divide-y divide-gray-100 md:hidden">
            @foreach($students as $student)
                <div class="px-4 py-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between gap-3">

                        {{-- Avatar + Name --}}
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                                @if($student->studentProfile?->profile_picture)
                                    <img src="{{ asset('storage/' . $student->studentProfile->profile_picture) }}"
                                         alt="{{ $student->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $student->name }}</p>
                                <p class="text-xs text-gray-400 truncate">{{ $student->email }}</p>
                                <div class="flex flex-wrap items-center gap-1.5 mt-1">
                                    @if($student->studentProfile?->department)
                                        <span class="inline-block px-2 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                            {{ $student->studentProfile->department }}
                                        </span>
                                    @endif
                                    @if($student->studentProfile?->student_id)
                                        <span class="text-xs text-gray-500 font-mono">{{ $student->studentProfile->student_id }}</span>
                                    @endif
                                    @if($student->studentProfile?->year_level)
                                        <span class="text-xs text-gray-400">· {{ $student->studentProfile->year_level }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Action --}}
                        <a href="{{ route('counselor.students.show', $student) }}"
                           class="shrink-0 inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-100 hover:border-gray-300 transition-colors">
                            View
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ── Desktop Table View (≥ md) ── --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full min-w-[600px]">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Student</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Student ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Department</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Year Level</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($students as $student)
                        <tr class="hover:bg-gray-50 transition-colors">

                            {{-- Student Name + Email --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                                        @if($student->studentProfile?->profile_picture)
                                            <img src="{{ asset('storage/' . $student->studentProfile->profile_picture) }}"
                                                 alt="{{ $student->name }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate max-w-[180px]">{{ $student->name }}</p>
                                        <p class="text-xs text-gray-400 truncate max-w-[180px]">{{ $student->email }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Student ID --}}
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-700 font-mono">
                                    {{ $student->studentProfile?->student_id ?? '—' }}
                                </span>
                            </td>

                            {{-- Department --}}
                            <td class="px-4 py-4">
                                @if($student->studentProfile?->department)
                                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 whitespace-nowrap">
                                        {{ $student->studentProfile->department }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>

                            {{-- Year Level --}}
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-700">
                                    {{ $student->studentProfile?->year_level ?? '—' }}
                                </span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('counselor.students.show', $student) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-100
                                    hover:border-gray-300 transition-colors">
                                    View Profile
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($students->hasPages())
            <div class="px-4 py-4 border-t border-gray-100 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                <p class="text-xs text-gray-400 text-center sm:text-left">
                    Showing {{ $students->firstItem() }}–{{ $students->lastItem() }} of {{ $students->total() }} students
                </p>
                <div class="flex items-center justify-center gap-1">
                    @if($students->onFirstPage())
                        <span class="px-3 py-1.5 rounded-lg text-xs text-gray-300 border border-gray-100 cursor-not-allowed">←</span>
                    @else
                        <a href="{{ $students->previousPageUrl() }}"
                           class="px-3 py-1.5 rounded-lg text-xs text-gray-600 border border-gray-200 hover:bg-gray-50 transition-colors">←</a>
                    @endif

                    @foreach($students->getUrlRange(max(1, $students->currentPage() - 2), min($students->lastPage(), $students->currentPage() + 2)) as $page => $url)
                        <a href="{{ $url }}"
                           class="px-3 py-1.5 rounded-lg text-xs font-medium transition-colors
                                  {{ $page == $students->currentPage() ? 'bg-blue-600 text-white' : 'text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    @if($students->hasMorePages())
                        <a href="{{ $students->nextPageUrl() }}"
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