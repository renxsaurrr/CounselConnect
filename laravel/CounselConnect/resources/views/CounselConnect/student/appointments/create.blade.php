@extends('CounselConnect.layouts.student')

@section('title', 'Book Appointment')
@section('page-title', 'Book Appointment')

@section('content')

    {{-- ── Page Header ── --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Book Appointment</h2>
        <p class="text-sm text-gray-500 mt-0.5">Schedule a session with our supportive team.</p>
    </div>

    {{-- On mobile: single column stacked (form first, then counselors).
         On lg+: 3/5 form left + 2/5 counselors right. --}}
    <div class="flex flex-col lg:grid lg:grid-cols-5 gap-6 items-start">

        {{-- ── Left: Booking Form ── --}}
        <section class="w-full lg:col-span-3 bg-white rounded-2xl border border-gray-100 p-5 sm:p-7">

            {{-- Step indicator --}}
            <div class="flex items-center gap-3 mb-6">
                <span class="w-7 h-7 rounded-full bg-blue-600 text-white text-xs font-bold flex items-center justify-center shrink-0">1</span>
                <h3 class="text-base font-semibold text-gray-900">Appointment Details</h3>
            </div>

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="mb-5 bg-red-50 border border-red-100 rounded-xl px-4 py-3">
                    <ul class="text-sm text-red-600 space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="flex items-start gap-2">
                                <svg class="w-3.5 h-3.5 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('student.appointments.store') }}" id="booking-form">
                @csrf

                {{-- Hidden fields populated via JS --}}
                <input type="hidden" name="counselor_id" id="counselor_id" value="{{ old('counselor_id') }}">
                <input type="hidden" name="schedule_id"  id="schedule_id"  value="{{ old('schedule_id') }}">

                {{-- Concern Type --}}
                <fieldset class="mb-5">
                    <label for="concern_type" class="block text-sm font-medium text-gray-700 mb-1.5">
                        What can we help you with today?
                    </label>
                    <div class="relative">
                        <select id="concern_type" name="concern_type"
                                class="w-full appearance-none bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                            <option value="" disabled {{ old('concern_type') ? '' : 'selected' }}>Select a concern type</option>
                            @foreach(['Academic', 'Personal', 'Career', 'Mental Health', 'Other'] as $type)
                                <option value="{{ $type }}" {{ old('concern_type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        <svg class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    @error('concern_type')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </fieldset>

                {{-- Preferred Date + Time — stack on mobile, side-by-side on sm+ --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                    <fieldset>
                        <label for="preferred_date" class="block text-sm font-medium text-gray-700 mb-1.5">Preferred Date</label>
                        <input type="date" id="preferred_date" name="preferred_date"
                               value="{{ old('preferred_date') }}"
                               min="{{ now()->addDay()->toDateString() }}"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                        @error('preferred_date')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    <fieldset>
                        <label for="preferred_time" class="block text-sm font-medium text-gray-700 mb-1.5">Preferred Time</label>
                        <div class="relative">
                            <select id="preferred_time" name="preferred_time"
                                    class="w-full appearance-none bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled>
                                <option value="">Select counselor & date first</option>
                            </select>
                            <svg class="w-4 h-4 text-gray-400 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        @error('preferred_time')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </fieldset>
                </div>

                {{-- Additional Notes --}}
                <fieldset class="mb-6">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1.5">Additional Notes</label>
                    <textarea id="notes" name="notes" rows="4"
                              placeholder="Briefly describe your concern or any special requests..."
                              class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition resize-none">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </fieldset>

                <hr class="border-gray-100 mb-6">

                {{-- Submit — stack on mobile, side-by-side on sm+ --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <p class="text-xs text-gray-400 sm:max-w-xs">By clicking confirm, you agree to our confidential health services policy.</p>
                    <button type="submit"
                            class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold 
                            px-7 py-3 rounded-2xl transition-colors shrink-0 cursor-pointer">
                        Confirm Booking
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>
                </div>

            </form>
        </section>

        {{-- ── Right: Counselor Cards ── --}}
        <aside class="w-full lg:col-span-2 space-y-4">

            {{-- Step indicator --}}
            <div class="flex items-center gap-3 mb-1">
                <span class="w-7 h-7 rounded-full bg-gray-200 text-gray-500 text-xs font-bold flex items-center justify-center shrink-0">2</span>
                <h3 class="text-base font-semibold text-gray-900">Available Counselors</h3>
            </div>

            {{-- On mobile: horizontal scroll of cards. On lg+: stacked list. --}}
            <div class="flex lg:flex-col gap-3 overflow-x-auto pb-2 lg:pb-0 lg:overflow-visible -mx-4 px-4 lg:mx-0 lg:px-0">

                @forelse($counselors as $counselor)
                    <article id="counselor-{{ $counselor->id }}"
                             class="counselor-card bg-white rounded-2xl border-2 border-transparent cursor-pointer transition-all p-4 shrink-0 w-64 lg:w-auto"
                             onclick="selectCounselor({{ $counselor->id }})">
                        <div class="flex items-start gap-4">

                            {{-- Avatar --}}
                            <div class="w-12 h-12 lg:w-14 lg:h-14 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 font-bold text-lg shrink-0 overflow-hidden">
                                @if($counselor->counselorProfile?->profile_picture)
                                    <img src="{{ asset('storage/' . $counselor->counselorProfile->profile_picture) }}"
                                         alt="{{ $counselor->name }}"
                                         class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($counselor->name, 0, 1)) }}
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <p class="text-sm font-semibold text-gray-900 leading-snug">{{ $counselor->name }}</p>
                                    <span class="shrink-0 text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded-lg">Available</span>
                                </div>
                                <p class="text-xs text-blue-500 font-medium mt-0.5">{{ $counselor->counselorProfile?->specialization ?? 'Counselor' }}</p>

                                @if($counselor->counselorProfile?->office_location)
                                    <div class="flex items-center gap-1 mt-2">
                                        <span class="flex items-center gap-1 text-xs text-gray-400">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $counselor->counselorProfile->office_location }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center w-full">
                        <p class="text-sm text-gray-400">No counselors available at this time.</p>
                    </div>
                @endforelse

            </div>

            {{-- Urgent Help Box --}}
            <div class="bg-blue-50 rounded-2xl p-4 flex gap-3">
                <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-blue-700">Need Urgent Help?</p>
                    <p class="text-xs text-blue-500 mt-0.5 leading-relaxed">If you are experiencing a mental health emergency, please call our 24/7 crisis hotline at 1-800-SAFE-UNI or visit the student health center immediately.</p>
                </div>
            </div>

        </aside>
    </div>

@endsection

@push('scripts')
<script>
    // ── Counselor selection ──────────────────────────────────────
    function selectCounselor(id) {
        document.querySelectorAll('.counselor-card').forEach(card => {
            card.classList.remove('border-blue-600', 'bg-blue-50/30');
            card.classList.add('border-transparent');

            // Re-add hover listeners for unselected cards
            card.onmouseenter = () => {
                if (!card.classList.contains('border-blue-600')) {
                    card.classList.add('border-blue-200');
                }
            };
            card.onmouseleave = () => {
                if (!card.classList.contains('border-blue-600')) {
                    card.classList.remove('border-blue-200');
                }
            };
        });

        const selected = document.getElementById('counselor-' + id);
        selected.classList.remove('border-transparent', 'border-blue-200');
        selected.classList.add('border-blue-600', 'bg-blue-50/30');

        // Remove hover effect from selected card
        selected.onmouseenter = null;
        selected.onmouseleave = null;

        document.getElementById('counselor_id').value = id;

        const date = document.getElementById('preferred_date').value;
        if (date) fetchSlots(id, date);
    }

    // ── Initialise hover listeners on page load ──────────────────
    document.querySelectorAll('.counselor-card').forEach(card => {
        card.onmouseenter = () => {
            if (!card.classList.contains('border-blue-600')) {
                card.classList.add('border-blue-200');
            }
        };
        card.onmouseleave = () => {
            if (!card.classList.contains('border-blue-600')) {
                card.classList.remove('border-blue-200');
            }
        };
    });

    // ── Date change → re-fetch slots ────────────────────────────
    document.getElementById('preferred_date').addEventListener('change', function () {
        const counselorId = document.getElementById('counselor_id').value;
        if (counselorId) fetchSlots(counselorId, this.value);
    });

    // ── AJAX: fetch available slots ──────────────────────────────
    function fetchSlots(counselorId, date) {
        const select = document.getElementById('preferred_time');
        select.disabled = true;
        select.innerHTML = '<option value="">Loading slots...</option>';

        fetch(`{{ route('student.appointments.available-slots') }}?counselor_id=${counselorId}&date=${date}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            select.innerHTML = '';

            if (!data.slots || data.slots.length === 0) {
                select.innerHTML = '<option value="">No slots available</option>';
                select.disabled = true;
                return;
            }

            if (data.schedule_id) {
                document.getElementById('schedule_id').value = data.schedule_id;
            }

            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = 'Choose a time slot';
            placeholder.disabled = true;
            placeholder.selected = true;
            select.appendChild(placeholder);

            data.slots.forEach(slot => {
                const opt = document.createElement('option');
                opt.value = slot;
                const [h, m] = slot.split(':');
                const hour = parseInt(h);
                const ampm = hour >= 12 ? 'PM' : 'AM';
                const display = `${hour % 12 || 12}:${m} ${ampm}`;
                opt.textContent = display;
                select.appendChild(opt);
            });

            select.disabled = false;
        })
        .catch(() => {
            select.innerHTML = '<option value="">Failed to load slots</option>';
            select.disabled = true;
        });
    }

    // ── Pre-select counselor if old input exists ─────────────────
    const oldCounselorId = '{{ old('counselor_id') }}';
    if (oldCounselorId) selectCounselor(oldCounselorId);
</script>
@endpush 