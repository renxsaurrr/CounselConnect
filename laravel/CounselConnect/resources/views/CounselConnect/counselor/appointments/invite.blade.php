@extends('CounselConnect.layouts.counselor')

@section('title', 'Invite Student')
@section('page-title', 'Invite Student')

@section('content')

{{-- ── Breadcrumb ── --}}
<div class="flex items-center gap-2 text-sm text-gray-400 mb-6">
    <a href="{{ route('counselor.appointments.index') }}" class="hover:text-gray-600 transition-colors">Appointments</a>
    <span>/</span>
    <span class="text-gray-600 font-medium">Invite Student</span>
</div>

<div class="max-w-2xl">

    {{-- ── Card ── --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- Card Header --}}
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-900">Invite a Student</h2>
                <p class="text-xs text-gray-400 mt-0.5">Schedule an appointment on behalf of a student. They will receive an invite to accept or decline.</p>
            </div>
        </div>

        {{-- ── Form ── --}}
        <form action="{{ route('counselor.appointments.store') }}" method="POST" class="px-6 py-6 space-y-5">
            @csrf

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="flex items-start gap-3 px-4 py-3 rounded-xl bg-red-50 border border-red-100 text-red-700 text-sm">
                    <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ── Student ── --}}
            <div>
                <label for="student_id" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                    Student <span class="text-red-400">*</span>
                </label>
                <select id="student_id" name="student_id" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 bg-white
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                               @error('student_id') border-red-300 bg-red-50 @enderror">
                    <option value="">— Select a student —</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->name }}
                            @if($student->studentProfile?->department)
                                · {{ $student->studentProfile->department }}
                            @endif
                        </option>
                    @endforeach
                </select>
                @error('student_id')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- ── Concern Type ── --}}
            <div>
                <label for="concern_type" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                    Concern Type <span class="text-red-400">*</span>
                </label>
                <select id="concern_type" name="concern_type" required
                        class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 bg-white
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                               @error('concern_type') border-red-300 bg-red-50 @enderror">
                    <option value="">— Select concern type —</option>
                    @foreach(['Academic', 'Personal', 'Career', 'Mental Health', 'Other'] as $type)
                        <option value="{{ $type }}" {{ old('concern_type') === $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
                @error('concern_type')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- ── Date & Time ── --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                {{-- Date --}}
                <div>
                    <label for="preferred_date" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                        Preferred Date <span class="text-red-400">*</span>
                    </label>
                    <input type="date" id="preferred_date" name="preferred_date"
                           value="{{ old('preferred_date') }}"
                           min="{{ now()->toDateString() }}"
                           required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                                  @error('preferred_date') border-red-300 bg-red-50 @enderror">
                    @error('preferred_date')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Time --}}
                <div>
                    <label for="preferred_time" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                        Preferred Time <span class="text-red-400">*</span>
                    </label>
                    <select id="preferred_time" name="preferred_time" required
                            class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 bg-white
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                                   @error('preferred_time') border-red-300 bg-red-50 @enderror">
                        <option value="">— Pick a date first —</option>
                    </select>
                    @error('preferred_time')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                    <p id="slot-message" class="mt-1 text-xs text-gray-400 hidden"></p>
                </div>

            </div>

            {{-- ── Schedule Hint ── --}}
            @if($scheduleSlots->isEmpty())
                <div class="flex items-center gap-2 px-4 py-3 rounded-xl bg-amber-50 border border-amber-100 text-amber-700 text-sm">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    You have no active schedule slots. Please <a href="{{ route('counselor.schedule.create') }}" class="underline font-medium">set up your schedule</a> first.
                </div>
            @else
                <div class="px-4 py-3 rounded-xl bg-blue-50 border border-blue-100 text-xs text-blue-700">
                    <p class="font-semibold mb-1">Your active schedule:</p>
                    <ul class="space-y-0.5">
                        @foreach($scheduleSlots as $slot)
                            <li>{{ $slot->day_of_week }} &mdash; {{ \Carbon\Carbon::parse($slot->start_time)->format('g:i A') }} to {{ \Carbon\Carbon::parse($slot->end_time)->format('g:i A') }}
                                @if($slot->slot_duration_mins)
                                    ({{ $slot->slot_duration_mins }}-min slots)
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ── Notes ── --}}
            <div>
                <label for="notes" class="block text-xs font-semibold text-gray-600 uppercase tracking-wide mb-1.5">
                    Notes <span class="text-gray-400 font-normal">(optional)</span>
                </label>
                <textarea id="notes" name="notes" rows="3" maxlength="1000"
                          placeholder="Reason for the invitation or any context for the student..."
                          class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-900 resize-none
                                 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition
                                 @error('notes') border-red-300 bg-red-50 @enderror">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- ── Actions ── --}}
            <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                <a href="{{ route('counselor.appointments.index') }}"
                   class="px-4 py-2 rounded-xl text-sm font-medium text-gray-600 border border-gray-200 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="px-5 py-2 rounded-xl text-sm font-medium bg-blue-600 text-white hover:bg-blue-700 active:bg-blue-800 transition-colors shadow-sm">
                    Send Invitation
                </button>
            </div>

        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
/**
 * Dynamically load available time slots for the counselor's own schedule
 * when they pick a date on the invite form.
 */
document.addEventListener('DOMContentLoaded', function () {
    const dateInput   = document.getElementById('preferred_date');
    const timeSelect  = document.getElementById('preferred_time');
    const slotMessage = document.getElementById('slot-message');

    // Schedule slots passed from controller (day_of_week + start/end/duration)
    const scheduleSlots = @json($scheduleSlots);

    dateInput.addEventListener('change', function () {
        const selectedDate = this.value;
        if (!selectedDate) return;

        const dayOfWeek = new Date(selectedDate + 'T00:00:00').toLocaleDateString('en-US', { weekday: 'long' });

        // Find matching schedule slot for that day
        const matchingSlot = scheduleSlots.find(
            s => s.day_of_week.toLowerCase() === dayOfWeek.toLowerCase() && s.is_active
        );

        // Reset
        timeSelect.innerHTML = '';
        slotMessage.classList.add('hidden');
        slotMessage.textContent = '';

        if (!matchingSlot) {
            const opt = document.createElement('option');
            opt.value = '';
            opt.textContent = '— Not available on this day —';
            timeSelect.appendChild(opt);
            slotMessage.textContent = 'You have no active schedule on ' + dayOfWeek + '.';
            slotMessage.classList.remove('hidden');
            return;
        }

        // Generate slots client-side matching the server logic
        const slots = generateSlots(
            matchingSlot.start_time,
            matchingSlot.end_time,
            matchingSlot.slot_duration_mins
        );

        if (slots.length === 0) {
            const opt = document.createElement('option');
            opt.value = '';
            opt.textContent = '— No slots available —';
            timeSelect.appendChild(opt);
            return;
        }

        // Add placeholder
        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = '— Select a time slot —';
        timeSelect.appendChild(placeholder);

        const oldValue = '{{ old('preferred_time') }}';

        slots.forEach(function (slot) {
            const opt      = document.createElement('option');
            opt.value      = slot;
            opt.textContent = formatTime(slot);
            if (slot === oldValue) opt.selected = true;
            timeSelect.appendChild(opt);
        });
    });

    function generateSlots(startTime, endTime, durationMins) {
        const slots   = [];
        let   current = parseTime(startTime);
        const end     = parseTime(endTime);

        while (current + durationMins * 60 <= end) {
            slots.push(formatPad(Math.floor(current / 3600)) + ':' + formatPad(Math.floor((current % 3600) / 60)));
            current += durationMins * 60;
        }
        return slots;
    }

    function parseTime(timeStr) {
        const parts = timeStr.split(':');
        return parseInt(parts[0]) * 3600 + parseInt(parts[1]) * 60 + (parseInt(parts[2]) || 0);
    }

    function formatPad(n) {
        return String(n).padStart(2, '0');
    }

    function formatTime(slot) {
        const [h, m] = slot.split(':').map(Number);
        const ampm   = h >= 12 ? 'PM' : 'AM';
        const hour   = h % 12 || 12;
        return hour + ':' + String(m).padStart(2, '0') + ' ' + ampm;
    }

    // Trigger on page load if old value exists (validation re-display)
    if (dateInput.value) {
        dateInput.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush