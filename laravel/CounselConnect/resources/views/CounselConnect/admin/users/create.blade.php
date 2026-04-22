@extends('CounselConnect.layouts.admin')

@section('title', 'Add New User')
@section('page-title', 'Add New User')

@section('content')

    {{-- ── Page Header ── --}}
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Create Account</h2>
        <p class="text-sm text-gray-400 mt-1">Onboard a new member to the CounselConnect ecosystem.</p>
    </div>

    <div class="max-w-2xl mx-auto px-4 sm:px-0">

        {{-- ── Errors ── --}}
        @if($errors->any())
            <div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-100 text-red-600 text-sm px-4 py-3 rounded-xl">
                <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                </svg>
                <ul class="space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5">
            @csrf

            {{-- ── Main Card ── --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-7 space-y-6">

                {{-- Full Name --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Full Name</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="e.g. Dr. Sarah Jenkins"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition @error('name') border-red-300 bg-red-50 @enderror">
                </div>

                {{-- Email + Role: stacked on mobile, side-by-side on sm+ --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Email Address</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="s.jenkins@university.edu"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition @error('email') border-red-300 bg-red-50 @enderror">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">User Role</label>
                        <select name="role"
                                id="roleSelect"
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer @error('role') border-red-300 bg-red-50 @enderror">
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Select role...</option>
                            <option value="student"   {{ old('role') === 'student'   ? 'selected' : '' }}>Student</option>
                            <option value="counselor" {{ old('role') === 'counselor' ? 'selected' : '' }}>Counselor</option>
                            <option value="admin"     {{ old('role') === 'admin'     ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                </div>

                {{-- ── Student Profile Details ── --}}
                <div id="studentFields" class="hidden">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Student Profile Details</h3>
                    </div>
                    {{-- 1 col mobile → 3 col sm+ --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Student ID</label>
                            <input type="text"
                                   name="student_id"
                                   value="{{ old('student_id') }}"
                                   placeholder="2024-XXXX"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition @error('student_id') border-red-300 bg-red-50 @enderror">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Department</label>
                            <input type="text"
                                   name="department"
                                   value="{{ old('department') }}"
                                   placeholder="Psychology"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Year Level</label>
                            <select name="year_level"
                                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer">
                                <option value="">Select...</option>
                                <option value="First Year"   {{ old('year_level') === 'First Year'   ? 'selected' : '' }}>First Year</option>
                                <option value="Second Year"  {{ old('year_level') === 'Second Year'  ? 'selected' : '' }}>Second Year</option>
                                <option value="Third Year"   {{ old('year_level') === 'Third Year'   ? 'selected' : '' }}>Third Year</option>
                                <option value="Fourth Year"  {{ old('year_level') === 'Fourth Year'  ? 'selected' : '' }}>Fourth Year</option>
                                <option value="Fifth Year"   {{ old('year_level') === 'Fifth Year'   ? 'selected' : '' }}>Fifth Year</option>
                                <option value="Graduate"     {{ old('year_level') === 'Graduate'     ? 'selected' : '' }}>Graduate</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- ── Counselor Profile Details ── --}}
                <div id="counselorFields" class="hidden">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-5 h-5 rounded-full bg-purple-100 flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Counselor Profile Details</h3>
                    </div>
                    {{-- 1 col mobile → 3 col sm+ --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Specialization</label>
                            <input type="text"
                                   name="specialization"
                                   value="{{ old('specialization') }}"
                                   placeholder="e.g. Career Counseling"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Office Location</label>
                            <input type="text"
                                   name="office_location"
                                   value="{{ old('office_location') }}"
                                   placeholder="e.g. Room 201, Admin Bldg"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Contact Number</label>
                            <input type="text"
                                   name="contact_number"
                                   value="{{ old('contact_number') }}"
                                   placeholder="+63 9XX XXX XXXX"
                                   class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                        </div>
                    </div>
                </div>

                {{-- ── Security ── --}}
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-5 h-5 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                            <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-700">Security</h3>
                    </div>
                    {{-- 1 col mobile → 2 col sm+ --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- Password --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Password</label>
                            <div class="relative">
                                <input type="password"
                                       id="password"
                                       name="password"
                                       placeholder="••••••••••••"
                                       class="w-full px-4 py-3 pr-11 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition @error('password') border-red-300 bg-red-50 @enderror">
                                <button type="button"
                                        onclick="togglePassword()"
                                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600 transition-colors cursor-pointer">
                                    <svg id="pw-eye-show" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <svg id="pw-eye-hide" class="w-4 h-4" style="display:none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Confirm Password</label>
                            <div class="relative">
                                <input type="password"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       placeholder="••••••••••••"
                                       class="w-full px-4 py-3 pr-11 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                                <button type="button"
                                        onclick="toggleConfirmPassword()"
                                        class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-600 transition-colors cursor-pointer">
                                    <svg id="confirm-eye-show" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <svg id="confirm-eye-hide" class="w-4 h-4 hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            {{-- ── Form Actions ── --}}
            <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3">
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Discard Changes
                </a>
                <button type="submit"
                        class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors shadow-md shadow-blue-200 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/>
                    </svg>
                    Create User Account
                </button>
            </div>

        </form>

        {{-- ── Pro-tip ── --}}
        <div class="mt-6 bg-blue-50 border border-blue-100 rounded-2xl px-5 py-4 flex items-start gap-3">
            <div class="w-7 h-7 rounded-xl bg-blue-100 flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/>
                </svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-blue-800">Administrative Pro-tip</p>
                <p class="text-xs text-blue-500 mt-0.5 leading-relaxed">Ensure the university email provided is correct. An invitation link will be sent automatically to the user's inbox for first-time password setup and profile completion.</p>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
<script>
    // ── Role field toggling ──────────────────────────────────────
    const roleSelect    = document.getElementById('roleSelect');
    const studentFields  = document.getElementById('studentFields');
    const counselorFields = document.getElementById('counselorFields');

    function toggleRoleFields() {
        const role = roleSelect.value;
        studentFields.classList.toggle('hidden', role !== 'student');
        counselorFields.classList.toggle('hidden', role !== 'counselor');
    }

    roleSelect.addEventListener('change', toggleRoleFields);
    toggleRoleFields(); // restore state after validation failure

    // ── Password visibility toggle ───────────────────────────────
    function togglePassword() {
        const input   = document.getElementById('password');
        const eyeShow = document.getElementById('pw-eye-show');
        const eyeHide = document.getElementById('pw-eye-hide');
        const isShowing = eyeShow.style.display === 'none';
        input.type = isShowing ? 'password' : 'text';
        eyeShow.style.display = isShowing ? '' : 'none';
        eyeHide.style.display = isShowing ? 'none' : '';
    }

    function toggleConfirmPassword() {
        const input   = document.getElementById('password_confirmation');
        const eyeShow = document.getElementById('confirm-eye-show');
        const eyeHide = document.getElementById('confirm-eye-hide');
        const isVisible = !eyeShow.classList.contains('hidden');
        if (isVisible) {
            input.type = 'password';
            eyeShow.classList.remove('hidden');
            eyeHide.classList.add('hidden');
        } else {
            input.type = 'text';
            eyeShow.classList.add('hidden');
            eyeHide.classList.remove('hidden');
        }
    }
</script>
@endpush