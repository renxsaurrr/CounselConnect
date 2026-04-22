@extends('CounselConnect.layouts.counselor')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

    {{-- ── Page Subheader ── --}}
    <div class="flex flex-col gap-1.5 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-gray-500">Manage your professional information and account settings.</p>
        @if($profile->exists && $profile->updated_at)
            <span class="text-xs text-gray-400 flex items-center gap-1.5 shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Last updated {{ $profile->updated_at->format('M d, Y \a\t h:i A') }}
            </span>
        @endif
    </div>

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
        <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 text-sm rounded-xl px-4 py-3">
            <svg class="w-5 h-5 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 text-sm rounded-xl px-4 py-3">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <ul class="space-y-0.5 list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ── Main Form ── --}}
    <form action="{{ route('counselor.profile.update') }}"
          method="POST"
          enctype="multipart/form-data"
          id="profileForm">
        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ════════════════════════════════════════
                 LEFT COLUMN — Avatar & Account Info
            ════════════════════════════════════════ --}}
            <div class="lg:col-span-1 space-y-4">

                {{-- Profile Picture Card --}}
                <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm flex flex-col items-center text-center gap-4">

                    {{-- Avatar + explicit upload button (like student profile) --}}
                    <div class="flex flex-col items-center gap-3">

                        {{-- Fixed-size circle, always clipped --}}
                        <div class="relative">
                            <div class="w-24 h-24 rounded-full overflow-hidden bg-blue-100 ring-2 ring-gray-200 shrink-0 flex items-center justify-center">
                                @if($profile->profile_picture)
                                    <img id="avatarPreview"
                                         src="{{ asset('storage/' . $profile->profile_picture) }}"
                                         alt="Profile picture"
                                         class="w-full h-full object-cover">
                                    <div id="avatarFallback" class="hidden w-full h-full items-center justify-center bg-blue-100">
                                        <span class="text-3xl font-bold text-blue-600">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                    </div>
                                @else
                                    <div id="avatarFallback" class="w-full h-full flex items-center justify-center bg-blue-100">
                                        <span class="text-3xl font-bold text-blue-600">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                    </div>
                                    <img id="avatarPreview"
                                         src=""
                                         alt="Profile picture"
                                         class="w-full h-full object-cover hidden">
                                @endif
                            </div>

                            {{-- Small camera badge on bottom-right of circle --}}
                            <label for="profile_picture"
                                   class="absolute bottom-0 right-0 w-7 h-7 bg-blue-600 hover:bg-blue-700 rounded-full flex items-center justify-center cursor-pointer shadow-md transition-colors"
                                   title="Change photo">
                                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </label>
                        </div>

                        {{-- Explicit "Change Photo" button — always visible, clear CTA --}}
                        <label for="profile_picture"
                               class="flex items-center gap-1.5 px-4 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-lg cursor-pointer transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            {{ $profile->profile_picture ? 'Change Photo' : 'Upload Photo' }}
                        </label>

                        <input type="file"
                               id="profile_picture"
                               name="profile_picture"
                               accept="image/jpeg,image/png,image/webp"
                               class="hidden"
                               onchange="previewAvatar(this)">

                        <p class="text-xs text-gray-400">JPG, PNG or WebP &mdash; max 2 MB</p>
                    </div>

                    {{-- Identity --}}
                    <div class="w-full border-t border-gray-100 pt-4">
                        <p class="font-semibold text-gray-900 text-base leading-snug">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-gray-400 mt-0.5">{{ Auth::user()->email }}</p>
                        <div class="flex items-center justify-center gap-2 mt-3">
                            <span class="inline-block px-2.5 py-0.5 bg-blue-50 text-blue-600 text-xs font-medium rounded-full capitalize">
                                {{ Auth::user()->role }}
                            </span>
                            @if(Auth::user()->is_active)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-green-50 text-green-600 text-xs font-medium rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 bg-red-50 text-red-500 text-xs font-medium rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                    Inactive
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Account Meta Card --}}
                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">Account Details</h3>

                    <dl class="space-y-3">
                        <div class="flex items-center justify-between">
                            <dt class="text-xs text-gray-500">User ID</dt>
                            <dd class="text-xs font-medium text-gray-700">#{{ Auth::id() }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-xs text-gray-500">Member since</dt>
                            <dd class="text-xs font-medium text-gray-700">{{ Auth::user()->created_at->format('M d, Y') }}</dd>
                        </div>
                        @if($profile->specialization)
                            <div class="flex items-start justify-between gap-2">
                                <dt class="text-xs text-gray-500 shrink-0">Specialization</dt>
                                <dd class="text-xs font-medium text-gray-700 text-right">{{ $profile->specialization }}</dd>
                            </div>
                        @endif
                        @if($profile->office_location)
                            <div class="flex items-start justify-between gap-2">
                                <dt class="text-xs text-gray-500 shrink-0">Office</dt>
                                <dd class="text-xs font-medium text-gray-700 text-right">{{ $profile->office_location }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

            </div>

            {{-- ════════════════════════════════════════
                 RIGHT COLUMN — Editable Fields
            ════════════════════════════════════════ --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- ── Personal Information ── --}}
                <section class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">

                    <div class="flex items-center gap-2.5 mb-5">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-gray-800">Personal Information</h2>
                            <p class="text-xs text-gray-400">Your name and email are managed by the administrator.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- Full Name (read-only) --}}
                        <div class="space-y-1.5">
                            <label class="text-xs font-medium text-gray-500 flex items-center gap-1.5">
                                Full Name
                                <span class="px-1.5 py-px bg-gray-100 text-gray-400 text-[10px] rounded">Read-only</span>
                            </label>
                            <input type="text"
                                   value="{{ Auth::user()->name }}"
                                   class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl text-gray-500 cursor-not-allowed select-none"
                                   readonly
                                   tabindex="-1">
                        </div>

                        {{-- Email (read-only) --}}
                        <div class="space-y-1.5">
                            <label class="text-xs font-medium text-gray-500 flex items-center gap-1.5">
                                Email Address
                                <span class="px-1.5 py-px bg-gray-100 text-gray-400 text-[10px] rounded">Read-only</span>
                            </label>
                            <input type="email"
                                   value="{{ Auth::user()->email }}"
                                   class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-200 rounded-xl text-gray-500 cursor-not-allowed select-none"
                                   readonly
                                   tabindex="-1">
                        </div>

                        {{-- Specialization --}}
                        <div class="space-y-1.5">
                            <label for="specialization" class="text-xs font-medium text-gray-600">
                                Specialization
                            </label>
                            <input type="text"
                                   id="specialization"
                                   name="specialization"
                                   value="{{ old('specialization', $profile->specialization) }}"
                                   placeholder="e.g. Clinical Psychology, Career Counseling"
                                   maxlength="255"
                                   class="w-full px-3.5 py-2.5 text-sm border rounded-xl text-gray-800 placeholder-gray-400
                                          focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition
                                          {{ $errors->has('specialization') ? 'border-red-300 bg-red-50 focus:ring-red-100 focus:border-red-400' : 'border-gray-200 bg-white' }}">
                            @error('specialization')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Office Location --}}
                        <div class="space-y-1.5">
                            <label for="office_location" class="text-xs font-medium text-gray-600">
                                Office Location
                            </label>
                            <input type="text"
                                   id="office_location"
                                   name="office_location"
                                   value="{{ old('office_location', $profile->office_location) }}"
                                   placeholder="e.g. Wellness Wing, Room 302"
                                   maxlength="255"
                                   class="w-full px-3.5 py-2.5 text-sm border rounded-xl text-gray-800 placeholder-gray-400
                                          focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition
                                          {{ $errors->has('office_location') ? 'border-red-300 bg-red-50 focus:ring-red-100 focus:border-red-400' : 'border-gray-200 bg-white' }}">
                            @error('office_location')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </section>

                {{-- ── Contact Details ── --}}
                <section class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">

                    <div class="flex items-center gap-2.5 mb-5">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-gray-800">Contact Details</h2>
                            <p class="text-xs text-gray-400">How students and staff can reach you.</p>
                        </div>
                    </div>

                    <div class="space-y-4">

                        {{-- Contact Number --}}
                        <div class="space-y-1.5">
                            <label for="contact_number" class="text-xs font-medium text-gray-600">
                                Contact Number
                            </label>
                            <input type="text"
                                   id="contact_number"
                                   name="contact_number"
                                   value="{{ old('contact_number', $profile->contact_number) }}"
                                   placeholder="e.g. +63 912 345 6789"
                                   maxlength="255"
                                   class="w-full px-3.5 py-2.5 text-sm border rounded-xl text-gray-800 placeholder-gray-400
                                          focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition
                                          {{ $errors->has('contact_number') ? 'border-red-300 bg-red-50 focus:ring-red-100 focus:border-red-400' : 'border-gray-200 bg-white' }}">
                            @error('contact_number')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Professional Bio --}}
                        <div class="space-y-1.5">
                            <label for="bio" class="text-xs font-medium text-gray-600">
                                Professional Bio
                            </label>
                            <textarea id="bio"
                                      name="bio"
                                      rows="5"
                                      placeholder="Describe your background, counseling approach, and areas of expertise..."
                                      class="w-full px-3.5 py-2.5 text-sm border rounded-xl text-gray-800 placeholder-gray-400 resize-none
                                             focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition
                                             {{ $errors->has('bio') ? 'border-red-300 bg-red-50 focus:ring-red-100 focus:border-red-400' : 'border-gray-200 bg-white' }}">{{ old('bio', $profile->bio) }}</textarea>
                            @error('bio')
                                <p class="text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </section>

                {{-- ── Form Actions ── --}}
                <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-end gap-2 sm:gap-3 pb-2">
                    <button type="button"
                            onclick="discardChanges()"
                            class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors cursor-pointer">
                        Discard Changes
                    </button>
                    <button type="submit"
                            class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-2.5 text-sm font-semibold text-white bg-blue-600 rounded-xl hover:bg-blue-700 active:scale-95 transition-all shadow-sm
                             shadow-blue-200 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Changes
                    </button>
                </div>

            </div>
        </div>
    </form>

</div>

@endsection

@push('scripts')
<script>
    // ── Live avatar preview on file select ──
    function previewAvatar(input) {
        if (!input.files || !input.files[0]) return;

        const reader = new FileReader();

        reader.onload = function (e) {
            const preview  = document.getElementById('avatarPreview');
            const fallback = document.getElementById('avatarFallback');

            // Always show the img, always hide the letter fallback
            if (preview) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                preview.style.display = 'block';
            }
            if (fallback) {
                fallback.classList.add('hidden');
                fallback.style.display = 'none';
            }

            // Update the upload button label text
            const uploadLabels = document.querySelectorAll('label[for="profile_picture"]');
            uploadLabels.forEach(label => {
                const span = label.querySelector('span') || label;
                // Only update the button-style label (has text content beyond just the icon)
                if (label.textContent.trim().includes('Photo')) {
                    label.innerHTML = label.innerHTML.replace(/Upload Photo|Change Photo/, 'Change Photo');
                }
            });
        };

        reader.readAsDataURL(input.files[0]);
    }

    // ── Discard — reload to original values ──
    function discardChanges() {
        if (confirm('Discard all unsaved changes and revert to saved values?')) {
            window.location.reload();
        }
    }
</script>
@endpush