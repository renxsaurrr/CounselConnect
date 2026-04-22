@extends('CounselConnect.layouts.admin')

@section('title', 'Manual Booking')
@section('page-title', 'Appointments')

@section('content')

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="{{ route('admin.appointments.index') }}" class="hover:text-blue-600 transition-colors">Appointments</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <span class="text-gray-600 font-medium">Manual Booking</span>
    </div>

    {{-- ── Page Header ── --}}
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Manual Booking</h2>
        <p class="text-sm text-gray-400 mt-1">Book an appointment on behalf of a student. It will be auto-approved.</p>
    </div>

    <div class="max-w-2xl mx-auto px-4 sm:px-0">

        {{-- ── Errors ── --}}
        @if($errors->any())
            <div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-100 text-red-600 text-sm px-4 py-3 rounded-xl">
                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                </svg>
                <ul class="space-y-0.5">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.appointments.store') }}">
            @csrf

            <div class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-7 space-y-6">

                {{-- Student --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Student</label>
                    <select name="student_id" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer @error('student_id') border-red-300 bg-red-50 @enderror">
                        <option value="">Select a student...</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} — {{ $student->email }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Counselor --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Counselor</label>
                    <select name="counselor_id" id="counselorSelect" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer @error('counselor_id') border-red-300 bg-red-50 @enderror">
                        <option value="">Select a counselor...</option>
                        @foreach($counselors as $counselor)
                            <option value="{{ $counselor->id }}" {{ old('counselor_id') == $counselor->id ? 'selected' : '' }}>
                                {{ $counselor->name }}
                                @if($counselor->counselorProfile?->specialization)
                                    — {{ $counselor->counselorProfile->specialization }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Schedule Slot --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Schedule Slot</label>
                    <select name="schedule_id" id="scheduleSelect" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer @error('schedule_id') border-red-300 bg-red-50 @enderror">
                        <option value="">Select counselor first...</option>
                    </select>
                    <p class="text-xs text-gray-400 mt-1.5">Only active schedule slots are shown.</p>
                </div>

                {{-- Concern Type --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Concern Type</label>
                    <select name="concern_type" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer @error('concern_type') border-red-300 bg-red-50 @enderror">
                        <option value="">Select concern type...</option>
                        @foreach(['Academic', 'Personal', 'Career', 'Mental Health', 'Other'] as $type)
                            <option value="{{ $type }}" {{ old('concern_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Date & Time: stacked on mobile → side-by-side on sm+ --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    {{-- Preferred Date --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Preferred Date</label>
                        <input type="date" name="preferred_date" id="preferredDate" required
                               value="{{ old('preferred_date') }}"
                               min="{{ date('Y-m-d') }}"
                               disabled
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition disabled:opacity-50 disabled:cursor-not-allowed @error('preferred_date') border-red-300 bg-red-50 @enderror">
                        <p id="dateHint" class="text-xs text-gray-400 mt-1.5 hidden"></p>
                        @error('preferred_date')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Preferred Time — dropdown of valid slot times --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Preferred Time</label>
                        <select name="preferred_time" id="preferredTime" required
                                disabled
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed @error('preferred_time') border-red-300 bg-red-50 @enderror">
                            <option value="">Select date first...</option>
                        </select>
                        <p id="timeHint" class="text-xs text-gray-400 mt-1.5 hidden"></p>
                        @error('preferred_time')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Notes --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Notes <span class="text-gray-300 normal-case font-normal">(optional)</span></label>
                    <textarea name="notes" rows="4"
                              placeholder="Any additional information about this appointment..."
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition resize-none @error('notes') border-red-300 bg-red-50 @enderror">{{ old('notes') }}</textarea>
                </div>

                {{-- Info Notice --}}
                <div class="flex items-start gap-3 p-4 bg-blue-50 rounded-xl border border-blue-100">
                    <svg class="w-4 h-4 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                    </svg>
                    <p class="text-xs text-blue-700 leading-relaxed">
                        Appointments booked manually by the admin are <strong>automatically approved</strong> and will be immediately visible to both the student and the assigned counselor.
                    </p>
                </div>

            </div>

            {{-- Form Actions: stacked on mobile → side-by-side on sm+ --}}
            <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3 mt-5">
                <button type="button" onclick="handleCancel()"
                   class="flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-medium
                 text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancel
                </button>
                <button type="submit"
                        class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold 
                        px-6 py-2.5 rounded-xl transition-colors shadow-md shadow-blue-200 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Book Appointment
                </button>
            </div>

        </form>
    </div>

    {{-- ── Cancel Confirmation Modal ── --}}
    <div id="cancelBackdrop" class="fixed inset-0 z-50 hidden opacity-0 transition-opacity duration-200 bg-black/40 flex items-center justify-center p-4"
         onclick="if(event.target===this) closeCancelModal()">
        <div id="cancelModal" class="bg-white rounded-2xl border border-gray-100 shadow-xl w-full max-w-sm scale-95 transition-transform duration-200">
            <div class="p-6 text-center">
                <div class="w-12 h-12 rounded-full bg-amber-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-900">Discard changes?</h3>
                <p class="text-sm text-gray-500 mt-1.5">You have unsaved information. Leaving now will discard everything you've entered.</p>
            </div>
            <div class="flex gap-3 px-6 pb-6">
                <button type="button" onclick="closeCancelModal()"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors cursor-pointer">
                    Keep Editing
                </button>
                <a href="{{ route('admin.appointments.index') }}"
                   class="flex-1 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold transition-colors text-center cursor-pointer">
                    Discard
                </a>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // ── Cancel / discard modal ────────────────────────────────────
    let formDirty = false;

    document.querySelector('form').addEventListener('change', () => { formDirty = true; });
    document.querySelector('form').addEventListener('input',  () => { formDirty = true; });

    function handleCancel() {
        if (!formDirty) {
            window.location.href = '{{ route('admin.appointments.index') }}';
            return;
        }
        const backdrop = document.getElementById('cancelBackdrop');
        const modal    = document.getElementById('cancelModal');
        backdrop.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            modal.classList.remove('scale-95');
        });
    }

    function closeCancelModal() {
        const backdrop = document.getElementById('cancelBackdrop');
        const modal    = document.getElementById('cancelModal');
        backdrop.classList.add('opacity-0');
        modal.classList.add('scale-95');
        setTimeout(() => backdrop.classList.add('hidden'), 200);
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeCancelModal();
    });

    // ── Slot / date / time logic ──────────────────────────────────
    const counselorSelect = document.getElementById('counselorSelect');
    const scheduleSelect  = document.getElementById('scheduleSelect');
    const preferredDate   = document.getElementById('preferredDate');
    const preferredTime   = document.getElementById('preferredTime');
    const dateHint        = document.getElementById('dateHint');
    const timeHint        = document.getElementById('timeHint');

    // Stores the currently selected schedule object from the API
    let activeSlot = null;

    // ── Day index map ────────────────────────────────────────────
    const DAY_INDEX = { Sunday:0, Monday:1, Tuesday:2, Wednesday:3, Thursday:4, Friday:5, Saturday:6 };
    const DAY_NAMES = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

    /** Next date string (YYYY-MM-DD) for targetDayIndex on or after today */
    function nextOccurrence(targetDayIndex) {
        const d = new Date();
        d.setHours(0,0,0,0);
        const diff = (targetDayIndex - d.getDay() + 7) % 7;
        d.setDate(d.getDate() + diff);
        return d.toISOString().slice(0, 10);
    }

    /** Generate { value: "HH:MM", label: "h:MM AM/PM" } objects for the slot window */
    function buildTimeOptions(slot) {
        const options = [];
        const [sh, sm] = slot.start_time.split(':').map(Number);
        const [eh, em] = slot.end_time.split(':').map(Number);
        const startMins = sh * 60 + sm;
        const endMins   = eh * 60 + em;
        const step      = slot.slot_duration_mins > 0 ? slot.slot_duration_mins : 30;

        for (let m = startMins; m < endMins; m += step) {
            const hh   = String(Math.floor(m / 60)).padStart(2, '0');
            const mm   = String(m % 60).padStart(2, '0');
            const hr   = Math.floor(m / 60) % 12 || 12;
            const ampm = m >= 720 ? 'PM' : 'AM';
            options.push({ value: `${hh}:${mm}`, label: `${hr}:${mm} ${ampm}` });
        }
        return options;
    }

    /** Format "HH:MM:SS" → "h:MM AM/PM" */
    function fmtTime(t) {
        const [h, m] = t.split(':').map(Number);
        const ampm = h >= 12 ? 'PM' : 'AM';
        const hr   = h % 12 || 12;
        return `${hr}:${String(m).padStart(2,'0')} ${ampm}`;
    }

    // ── Reset date & time whenever slot changes ──────────────────
    function resetDateTime() {
        preferredDate.value    = '';
        preferredDate.disabled = true;
        preferredDate.min      = '';
        dateHint.classList.add('hidden');
        dateHint.textContent   = '';

        preferredTime.innerHTML = '<option value="">Select date first...</option>';
        preferredTime.disabled  = true;
        timeHint.classList.add('hidden');
        timeHint.textContent    = '';
    }

    // ── When a schedule slot is selected ────────────────────────
    function onSlotSelected() {
        const opt = scheduleSelect.options[scheduleSelect.selectedIndex];
        if (!opt || !opt.dataset.slot) { resetDateTime(); return; }

        activeSlot = JSON.parse(opt.dataset.slot);
        const targetDayIdx = DAY_INDEX[activeSlot.day_of_week];

        // Unlock date picker, jump min to first valid date
        const firstValid       = nextOccurrence(targetDayIdx);
        preferredDate.min      = firstValid;
        preferredDate.value    = '';
        preferredDate.disabled = false;

        dateHint.textContent = `Only ${activeSlot.day_of_week}s are valid for this slot — select a ${activeSlot.day_of_week}.`;
        dateHint.classList.remove('hidden');

        // Reset time until date confirmed
        preferredTime.innerHTML = '<option value="">Select date first...</option>';
        preferredTime.disabled  = true;
        timeHint.classList.add('hidden');
    }

    // ── When a date is chosen ────────────────────────────────────
    preferredDate.addEventListener('change', function () {
        if (!activeSlot || !this.value) return;

        // new Date(YYYY-MM-DD) parses as UTC midnight; add 'T12:00' to keep local day
        const chosen    = new Date(this.value + 'T12:00:00');
        const chosenDay = DAY_NAMES[chosen.getDay()];

        if (chosenDay !== activeSlot.day_of_week) {
            this.value = '';
            dateHint.textContent = `⚠ That date is a ${chosenDay}. Please pick a ${activeSlot.day_of_week}.`;
            preferredTime.innerHTML = '<option value="">Select date first...</option>';
            preferredTime.disabled  = true;
            timeHint.classList.add('hidden');
            return;
        }

        dateHint.textContent = `✓ ${chosen.toLocaleDateString('en-US',{weekday:'long',month:'long',day:'numeric'})} — valid ${activeSlot.day_of_week}.`;

        // Populate time dropdown with slot-aligned options
        const timeOpts = buildTimeOptions(activeSlot);
        preferredTime.innerHTML = '<option value="">Select a time slot...</option>';
        timeOpts.forEach(o => {
            const el = document.createElement('option');
            el.value       = o.value;
            el.textContent = o.label;
            // Restore old value after validation failure
            if (el.value === '{{ old('preferred_time') }}') el.selected = true;
            preferredTime.appendChild(el);
        });
        preferredTime.disabled = false;

        timeHint.textContent = `Available: ${fmtTime(activeSlot.start_time)} – ${fmtTime(activeSlot.end_time)}, every ${activeSlot.slot_duration_mins} min.`;
        timeHint.classList.remove('hidden');
    });

    // ── Load slots when counselor changes ───────────────────────
    counselorSelect.addEventListener('change', async function () {
        const counselorId = this.value;

        scheduleSelect.innerHTML = '<option value="">Loading slots...</option>';
        scheduleSelect.disabled  = true;
        activeSlot = null;
        resetDateTime();

        if (!counselorId) {
            scheduleSelect.innerHTML = '<option value="">Select counselor first...</option>';
            scheduleSelect.disabled  = false;
            return;
        }

        try {
            const res  = await fetch(`/admin/appointments/slots?counselor_id=${counselorId}`);
            const data = await res.json();

            scheduleSelect.disabled = false;

            if (!data.length) {
                scheduleSelect.innerHTML = '<option value="">No active slots available</option>';
                return;
            }

            scheduleSelect.innerHTML = '<option value="">Select a slot...</option>';
            data.forEach(slot => {
                const opt        = document.createElement('option');
                opt.value        = slot.id;
                opt.textContent  = `${slot.day_of_week} · ${fmtTime(slot.start_time)} – ${fmtTime(slot.end_time)} (${slot.slot_duration_mins} min slots)`;
                opt.dataset.slot = JSON.stringify(slot);  // carry full slot data client-side
                scheduleSelect.appendChild(opt);
            });
        } catch {
            scheduleSelect.innerHTML = '<option value="">Failed to load slots</option>';
            scheduleSelect.disabled  = false;
        }
    });

    scheduleSelect.addEventListener('change', onSlotSelected);
</script>
@endpush