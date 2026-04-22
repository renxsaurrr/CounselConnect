@extends('CounselConnect.layouts.counselor')

@section('title', 'Add Schedule')
@section('page-title', 'Schedule')

@section('content')

<div class="w-full max-w-lg mx-auto sm:mx-0">

    {{-- ── Back Link ── --}}
    <a href="{{ route('counselor.schedule.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 mb-6 transition-colors">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Schedule
    </a>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <div class="px-4 py-5 border-b border-gray-100 sm:px-6">
            <h2 class="text-base font-semibold text-gray-900">Add Availability Slot</h2>
            <p class="text-xs text-gray-400 mt-0.5">Define a recurring weekly time block for student bookings.</p>
        </div>

        <form method="POST" action="{{ route('counselor.schedule.store') }}" class="px-4 py-5 space-y-5 sm:px-6">
            @csrf

            {{-- Day of Week --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Day of Week</label>
                <div class="relative">
                    <select name="day_of_week"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-800
                                   focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400
                                   bg-white appearance-none transition pr-9">
                        <option value="">Select a day</option>
                        @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday'] as $day)
                            <option value="{{ $day }}" {{ old('day_of_week') === $day ? 'selected' : '' }}>
                                {{ $day }}
                            </option>
                        @endforeach
                    </select>
                    <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                @error('day_of_week')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Time Range --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Start Time</label>
                    <input type="time" name="start_time" value="{{ old('start_time') }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-800
                                  focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                    @error('start_time')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">End Time</label>
                    <input type="time" name="end_time" value="{{ old('end_time') }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-800
                                  focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                    @error('end_time')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Slot Duration --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Slot Duration
                    <span class="text-gray-400 font-normal">(minutes per appointment)</span>
                </label>
                <div class="relative">
                    <select name="slot_duration_mins"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-800
                                   focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400
                                   bg-white appearance-none transition pr-9">
                        @foreach([15, 30, 45, 60, 90, 120] as $mins)
                            <option value="{{ $mins }}" {{ old('slot_duration_mins', 30) == $mins ? 'selected' : '' }}>
                                {{ $mins }} minutes
                            </option>
                        @endforeach
                    </select>
                    <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                         fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
                @error('slot_duration_mins')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Preview --}}
            <div id="slot-preview" class="hidden rounded-xl bg-blue-50 border border-blue-100 px-4 py-3">
                <p class="text-xs font-medium text-blue-700">Slot Preview</p>
                <p id="preview-text" class="text-sm text-blue-800 mt-0.5"></p>
            </div>

            {{-- Actions --}}
            <div class="flex flex-col-reverse gap-2 pt-2 sm:flex-row sm:items-center sm:justify-end sm:gap-3">
                <a href="{{ route('counselor.schedule.index') }}"
                   class="text-center px-4 py-2 rounded-xl border border-gray-200 text-sm font-medium text-gray-600
                    hover:bg-gray-100 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="px-5 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition-colors cursor-pointer">
                    Save Schedule
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const startInput    = document.querySelector('[name="start_time"]');
    const endInput      = document.querySelector('[name="end_time"]');
    const durationInput = document.querySelector('[name="slot_duration_mins"]');
    const preview       = document.getElementById('slot-preview');
    const previewText   = document.getElementById('preview-text');

    function updatePreview() {
        const start    = startInput.value;
        const end      = endInput.value;
        const duration = parseInt(durationInput.value);

        if (!start || !end || !duration) { preview.classList.add('hidden'); return; }

        const [sh, sm] = start.split(':').map(Number);
        const [eh, em] = end.split(':').map(Number);
        const totalMins = (eh * 60 + em) - (sh * 60 + sm);

        if (totalMins <= 0) { preview.classList.add('hidden'); return; }

        const slots = Math.floor(totalMins / duration);
        const fmt = t => {
            const [h, m] = t.split(':').map(Number);
            const ampm = h >= 12 ? 'PM' : 'AM';
            return `${h % 12 || 12}:${String(m).padStart(2,'0')} ${ampm}`;
        };

        previewText.textContent = `${fmt(start)} – ${fmt(end)} · ${slots} slot${slots !== 1 ? 's' : ''} of ${duration} min each`;
        preview.classList.remove('hidden');
    }

    [startInput, endInput, durationInput].forEach(el => el.addEventListener('change', updatePreview));
    updatePreview();
</script>
@endpush