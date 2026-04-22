@extends('CounselConnect.layouts.counselor')

@section('title', 'My Schedule')
@section('page-title', 'Schedule')

@section('content')

{{-- ── Header ── --}}
<div class="flex flex-col gap-3 mb-6 sm:flex-row sm:items-center sm:justify-between">
    <p class="text-sm text-gray-500">Manage your weekly availability and time slots.</p>
    <a href="{{ route('counselor.schedule.create') }}"
       class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition-colors w-full sm:w-auto">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Add Schedule
    </a>
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

@if($schedules->isEmpty())

    {{-- ── Empty State ── --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm flex flex-col items-center justify-center py-20 px-4 text-center">
        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-4">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h3 class="text-base font-semibold text-gray-900">No schedule set up yet</h3>
        <p class="text-sm text-gray-400 mt-1 mb-5">Add your weekly availability so students can book appointments.</p>
        <a href="{{ route('counselor.schedule.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Add Your First Schedule
        </a>
    </div>

@else

    @php
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $grouped = $schedules->groupBy('day_of_week');
    @endphp

    <div class="space-y-4">
        @foreach($days as $day)
            @if($grouped->has($day))
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                    {{-- Day Header --}}
                    <div class="px-4 py-3.5 bg-gray-50 border-b border-gray-100 flex items-center gap-3 sm:px-6">
                        <span class="text-sm font-semibold text-gray-800">{{ $day }}</span>
                        <span class="text-xs text-gray-400">
                            {{ $grouped[$day]->count() }} {{ Str::plural('slot', $grouped[$day]->count()) }}
                        </span>
                    </div>

                    {{-- Slot Rows --}}
                    <div class="divide-y divide-gray-50">
                        @foreach($grouped[$day] as $schedule)
                            @php
                                $start = \Carbon\Carbon::parse($schedule->start_time);
                                $end   = \Carbon\Carbon::parse($schedule->end_time);
                                $total = (int) $start->diffInMinutes($end);
                                $slots = $total > 0 ? floor($total / $schedule->slot_duration_mins) : 0;
                            @endphp

                            {{-- Mobile layout --}}
                            <div class="px-4 py-4 sm:hidden">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="space-y-2 min-w-0">

                                        {{-- Time --}}
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="text-sm font-medium text-gray-800">
                                                {{ $start->format('g:i A') }} – {{ $end->format('g:i A') }}
                                            </span>
                                        </div>

                                        {{-- Meta --}}
                                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-500">
                                            <span>{{ $schedule->slot_duration_mins }} min/slot</span>
                                            <span>·</span>
                                            <span>{{ $slots }} {{ Str::plural('slot', $slots) }} available</span>
                                        </div>

                                        {{-- Status --}}
                                        @if($schedule->is_active)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                                Inactive
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Actions --}}
                                    <div class="flex flex-col gap-2 shrink-0">
                                        <a href="{{ route('counselor.schedule.edit', $schedule) }}"
                                           class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-100 hover:border-gray-300 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Edit
                                        </a>
                                        <button type="button"
                                                data-delete-action="{{ route('counselor.schedule.destroy', $schedule) }}"
                                                class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg border border-red-100 text-xs font-medium text-red-500 hover:bg-red-50 hover:border-red-200 
                                                transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Desktop layout --}}
                            <div class="hidden sm:flex px-6 py-4 items-center gap-4">

                                {{-- Time Range --}}
                                <div class="flex items-center gap-2 min-w-[160px]">
                                    <svg class="w-4 h-4 text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-800 whitespace-nowrap">
                                        {{ $start->format('g:i A') }} – {{ $end->format('g:i A') }}
                                    </span>
                                </div>

                                {{-- Slot Duration --}}
                                <div class="flex items-center gap-1.5 text-xs text-gray-500 min-w-[110px] whitespace-nowrap">
                                    <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                    </svg>
                                    {{ $schedule->slot_duration_mins }} min/slot
                                </div>

                                {{-- Computed Slots --}}
                                <div class="text-xs text-gray-400 min-w-[80px] whitespace-nowrap">
                                    {{ $slots }} {{ Str::plural('slot', $slots) }} available
                                </div>

                                {{-- Status Badge --}}
                                <div class="flex-1">
                                    @if($schedule->is_active)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                            <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                            Inactive
                                        </span>
                                    @endif
                                </div>

                                {{-- Actions --}}
                                <div class="flex items-center gap-2 shrink-0">
                                    <a href="{{ route('counselor.schedule.edit', $schedule) }}"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-50 hover:border-gray-300 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <button type="button"
                                            data-delete-action="{{ route('counselor.schedule.destroy', $schedule) }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-red-100 text-xs font-medium text-red-500 hover:bg-red-50 hover:border-red-200 transition-colors cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete
                                    </button>
                                </div>

                            </div>
                        @endforeach
                    </div>

                </div>
            @endif
        @endforeach
    </div>

@endif 

{{-- ── Delete Confirmation Modal ── --}}
<div id="delete-modal"
     class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     aria-modal="true" role="dialog" aria-labelledby="modal-title">

    <div id="modal-backdrop"
         class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity duration-200 opacity-0"></div>

    <div id="modal-panel"
         class="relative bg-white rounded-2xl shadow-xl border border-gray-100 w-full max-w-sm p-6
                transition-all duration-200 scale-95 opacity-0">

        <div class="flex items-center justify-center w-12 h-12 rounded-2xl bg-red-50 mb-4 mx-auto">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>

        <h3 id="modal-title" class="text-base font-semibold text-gray-900 text-center">Delete Schedule Slot?</h3>
        <p class="text-sm text-gray-500 text-center mt-1 mb-6">
            This will permanently remove the schedule slot. Students won't be able to book it anymore.
        </p>

        <div class="flex items-center gap-3">
            <button id="modal-cancel"
                    class="flex-1 px-4 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-600
                           hover:bg-gray-100 hover:border-gray-300 transition-colors cursor-pointer">
                Cancel
            </button>
            <form id="modal-delete-form" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full px-4 py-2 rounded-xl bg-red-500 text-white text-sm font-medium
                               hover:bg-red-600 transition-colors cursor-pointer"> 
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const deleteModal     = document.getElementById('delete-modal');
    const modalBackdrop   = document.getElementById('modal-backdrop');
    const modalPanel      = document.getElementById('modal-panel');
    const modalCancelBtn  = document.getElementById('modal-cancel');
    const modalDeleteForm = document.getElementById('modal-delete-form');

    function openDeleteModal(action) {
        modalDeleteForm.action = action;
        deleteModal.classList.remove('hidden');
        deleteModal.classList.add('flex');
        requestAnimationFrame(() => {
            modalBackdrop.classList.remove('opacity-0');
            modalBackdrop.classList.add('opacity-100');
            modalPanel.classList.remove('scale-95', 'opacity-0');
            modalPanel.classList.add('scale-100', 'opacity-100');
        });
    }

    function closeDeleteModal() {
        modalBackdrop.classList.remove('opacity-100');
        modalBackdrop.classList.add('opacity-0');
        modalPanel.classList.remove('scale-100', 'opacity-100');
        modalPanel.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            deleteModal.classList.add('hidden');
            deleteModal.classList.remove('flex');
        }, 200);
    }

    document.querySelectorAll('[data-delete-action]').forEach(btn => {
        btn.addEventListener('click', () => openDeleteModal(btn.dataset.deleteAction));
    });

    modalCancelBtn.addEventListener('click', closeDeleteModal);
    modalBackdrop.addEventListener('click', closeDeleteModal);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDeleteModal(); });
</script>
@endpush

@endsection