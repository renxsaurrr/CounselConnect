@extends('CounselConnect.layouts.student')

@section('title', 'My Profile')
@section('page-title', 'Student Profile')

@section('content')

    {{-- ── Page Header ── --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Tell your story,</h2>
        <p class="text-2xl font-bold text-blue-600">at your own pace.</p>
        <p class="text-sm text-gray-400 mt-2 max-w-md leading-relaxed">
            Your profile helps our counselors understand your academic background and personal goals to provide more tailored support.
        </p>
    </div>

    {{-- ── Flash Messages ── --}}
    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-100 text-green-700 text-sm px-4 py-3 rounded-xl">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

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

    {{-- ── Responsive Grid: stacks on mobile, 5-col on large screens ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 items-start">

        {{-- ── Left: Profile Form ── --}}
        <div class="lg:col-span-3 space-y-5">

            <section class="bg-white rounded-2xl border border-gray-100 p-6">

                <h3 class="text-sm font-semibold text-gray-900 mb-1">Profile Identity</h3>
                <p class="text-xs text-gray-400 mb-5 leading-relaxed">
                    Update your photo and student credentials here. This information is used for administrative identification.
                </p>

                {{-- Avatar --}}
                <div class="flex flex-wrap items-center gap-5 mb-6">
                    <div class="relative shrink-0">
                        <div class="w-20 h-20 rounded-full bg-gray-700 flex items-center justify-center text-white text-2xl font-bold overflow-hidden"
                             id="avatar-preview-wrapper">
                            @if($profile?->profile_picture)
                                <img id="avatar-preview"
                                     src="{{ asset('storage/' . $profile->profile_picture) }}"
                                     alt="Profile photo"
                                     class="w-full h-full object-cover">
                                <span id="avatar-initials" class="hidden">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            @else
                                <span id="avatar-initials">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                <img id="avatar-preview" src="" alt="" class="w-full h-full object-cover hidden">
                            @endif
                        </div>
                        <label for="profile_picture"
                               class="absolute -bottom-1 -right-1 w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center cursor-pointer hover:bg-blue-700 transition-colors">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </label>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="profile_picture"
                               class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-xl cursor-pointer transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Change Photo
                        </label>
                        @if($profile?->profile_picture)
                            <button type="button" id="remove-photo-btn"
                                    class="text-xs text-gray-400 hover:text-red-500 transition-colors text-left px-1 cursor-pointer">
                                Remove Photo
                            </button>
                        @endif
                        <p class="text-xs text-gray-400">JPG, PNG or GIF · Max 2MB</p>
                    </div>
                </div>

                {{-- Profile Form --}}
                <form method="POST"
                      action="{{ route('student.profile.update') }}"
                      enctype="multipart/form-data"
                      id="profile-form">
                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="remove_photo" id="remove_photo" value="0">
                    <input type="file" id="profile_picture" name="profile_picture"
                           accept="image/*" class="hidden"
                           onchange="previewPhoto(this)">

                    {{-- Full Name + Email: stacked on mobile, side-by-side on sm+ --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <fieldset>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}"
                                   class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition"
                                   placeholder="Your full name">
                            @error('name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </fieldset>

                        <fieldset>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">University Email</label>
                            <input type="email" value="{{ Auth::user()->email }}"
                                   class="w-full bg-gray-100 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-400 cursor-not-allowed"
                                   disabled>
                            <p class="mt-1 text-xs text-gray-400">Email cannot be changed.</p>
                        </fieldset>
                    </div>

                    {{-- Student ID + Department: stacked on mobile, side-by-side on sm+ --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <fieldset>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Student ID Number</label>
                            <div class="w-full bg-gray-100 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-500 cursor-not-allowed">
                                {{ $profile?->student_id ?? '—' }}
                            </div>
                            <p class="mt-1 text-xs text-gray-400">Assigned at registration.</p>
                        </fieldset>

                        <fieldset>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Department</label>
                            <div class="w-full bg-gray-100 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-500 cursor-not-allowed">
                                {{ $profile?->department ?? '—' }}
                            </div>
                            <p class="mt-1 text-xs text-gray-400">Assigned at registration.</p>
                        </fieldset>
                    </div>

                    {{-- Year Level --}}
                    <fieldset class="mb-4">
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Year Level</label>
                        <div class="w-full sm:w-1/2 bg-gray-100 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-500 cursor-not-allowed">
                            {{ $profile?->year_level ?? '—' }}
                        </div>
                        <p class="mt-1 text-xs text-gray-400">Assigned at registration.</p>
                    </fieldset>

                    {{-- Personal Bio --}}
                    <fieldset class="mb-6">
                        <label class="block text-xs font-medium text-gray-500 mb-1.5">Personal Bio</label>
                        <textarea name="bio" rows="4"
                                  placeholder="Tell us a bit about yourself, your academic interests, and what you hope to achieve through counseling..."
                                  class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition resize-none">{{ old('bio', $profile?->bio) }}</textarea>
                        @error('bio')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </fieldset>

                    {{-- Actions --}}
                    <div class="flex flex-wrap items-center justify-end gap-3">
                        <a href="{{ route('student.dashboard') }}"
                           class="text-sm text-gray-400 hover:text-gray-600 font-medium px-4 py-2.5 rounded-xl transition-colors">
                            Discard changes
                        </a>
                        <button type="submit"
                                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors cursor-pointer">
                            Update Profile
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </button>
                    </div>

                </form>
            </section>

        </div>

        {{-- ── Right: Info Sidebar ── --}}
        <aside class="lg:col-span-2 space-y-4">

            {{-- Privacy notice --}}
            <section class="bg-blue-50 rounded-2xl p-5">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-blue-800">Your data is encrypted</p>
                        <p class="text-xs text-blue-500 mt-0.5 leading-relaxed">
                            and visible only to assigned counselors.
                        </p>
                    </div>
                </div>
            </section>

            {{-- Profile completeness --}}
            <section class="bg-white rounded-2xl border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Profile Completeness</h3>
                @php
                    $fields = [
                        'Name'       => Auth::user()->name,
                        'Student ID' => $profile?->student_id,
                        'Department' => $profile?->department,
                        'Year Level' => $profile?->year_level,
                        'Bio'        => $profile?->bio,
                        'Photo'      => $profile?->profile_picture,
                    ];
                    $filled   = collect($fields)->filter()->count();
                    $total    = count($fields);
                    $percent  = intval(($filled / $total) * 100);
                @endphp
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-gray-400">{{ $filled }} of {{ $total }} fields filled</span>
                    <span class="text-xs font-semibold text-blue-600">{{ $percent }}%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mb-4">
                    <div class="bg-blue-600 h-1.5 rounded-full transition-all" style="width: {{ $percent }}%"></div>
                </div>
                <ul class="space-y-2">
                    @foreach($fields as $label => $value)
                        <li class="flex items-center gap-2 text-xs {{ $value ? 'text-gray-600' : 'text-gray-400' }}">
                            @if($value)
                                <svg class="w-3.5 h-3.5 text-green-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            @else
                                <svg class="w-3.5 h-3.5 text-gray-300 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                            @endif
                            {{ $label }}
                        </li>
                    @endforeach
                </ul>
            </section>

            {{-- Account info --}}
            <section class="bg-white rounded-2xl border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">Account</h3>
                <dl class="space-y-2.5">
                    <div class="flex items-center justify-between">
                        <dt class="text-xs text-gray-400">Role</dt>
                        <dd class="text-xs font-medium text-gray-700 capitalize">{{ Auth::user()->role }}</dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-xs text-gray-400">Member since</dt>
                        <dd class="text-xs font-medium text-gray-700">
                            {{ Auth::user()->created_at->format('M Y') }}
                        </dd>
                    </div>
                    <div class="flex items-center justify-between">
                        <dt class="text-xs text-gray-400">Email verified</dt>
                        <dd class="text-xs font-medium {{ Auth::user()->email_verified_at ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ Auth::user()->email_verified_at ? 'Verified' : 'Pending' }}
                        </dd>
                    </div>
                </dl>
            </section>

        </aside>
    </div>

@endsection

@push('scripts')
<script>
    function previewPhoto(input) {
        if (!input.files || !input.files[0]) return;
        const file   = input.files[0];
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview  = document.getElementById('avatar-preview');
            const initials = document.getElementById('avatar-initials');
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (initials) initials.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }

    const removeBtn = document.getElementById('remove-photo-btn');
    if (removeBtn) {
        removeBtn.addEventListener('click', function () {
            document.getElementById('remove_photo').value = '1';
            const preview  = document.getElementById('avatar-preview');
            const initials = document.getElementById('avatar-initials');
            const input    = document.getElementById('profile_picture');
            preview.src = '';
            preview.classList.add('hidden');
            if (initials) initials.classList.remove('hidden');
            if (input) input.value = '';
            removeBtn.classList.add('hidden');
        });
    }
</script>
@endpush