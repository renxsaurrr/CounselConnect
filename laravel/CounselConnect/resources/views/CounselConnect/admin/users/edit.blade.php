@extends('CounselConnect.layouts.admin')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="{{ route('admin.users.index') }}" class="hover:text-blue-600 transition-colors">Users</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <a href="{{ route('admin.users.show', $user) }}" class="hover:text-blue-600 transition-colors">{{ $user->name }}</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <span class="text-gray-600 font-medium">Edit</span>
    </div>

    {{-- ── Page Header ── --}}
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Edit Account</h2>
        <p class="text-sm text-gray-400 mt-1">Update profile and access settings for this user.</p>
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

        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf @method('PATCH')

            {{-- ── Main Card ── --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-7 space-y-6">

                {{-- Current User Badge --}}
                <div class="flex items-center gap-3 p-3.5 bg-gray-50 rounded-xl border border-gray-100">
                    @php
                        $pic = match($user->role) {
                            'student'   => $user->studentProfile?->profile_picture,
                            'counselor' => $user->counselorProfile?->profile_picture,
                            'admin'     => $user->adminProfile?->profile_picture,
                            default     => null,
                        };
                        $avatarBg = match($user->role) {
                            'counselor' => 'bg-green-100 text-green-700',
                            'admin'     => 'bg-purple-100 text-purple-700',
                            default     => 'bg-blue-100 text-blue-700',
                        };
                    @endphp
                    <div class="w-10 h-10 rounded-xl {{ $avatarBg }} flex items-center justify-center text-sm font-bold shrink-0 overflow-hidden">
                        @if($pic)
                            <img src="{{ asset('storage/' . $pic) }}" class="w-full h-full object-cover" alt="{{ $user->name }}">
                        @else
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $user->name }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $user->email }} · Joined {{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                </div>

                {{-- Full Name --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Full Name</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $user->name) }}"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition @error('name') border-red-300 bg-red-50 @enderror">
                </div>

                {{-- Email + Status: stacked on mobile, side-by-side on sm+ --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Email Address</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email', $user->email) }}"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition @error('email') border-red-300 bg-red-50 @enderror">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Account Status</label>
                        <div class="flex items-center gap-4 h-[46px]">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_active" value="1" {{ old('is_active', $user->is_active ? '1' : '0') == '1' ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer">
                                <span class="text-sm text-gray-700">Active</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="is_active" value="0" {{ old('is_active', $user->is_active ? '1' : '0') == '0' ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 cursor-pointer">
                                <span class="text-sm text-gray-700">Inactive</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Role (read-only display) --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">User Role</label>
                    <div class="flex items-center gap-2 px-4 py-3 bg-gray-50 border border-dashed border-gray-200 rounded-xl">
                        @php
                            $roleIcon = match($user->role) {
                                'counselor' => 'bg-green-100 text-green-600',
                                'admin'     => 'bg-purple-100 text-purple-600',
                                default     => 'bg-blue-100 text-blue-600',
                            };
                        @endphp
                        <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wide {{ $roleIcon }}">
                            {{ $user->role }}
                        </span>
                        <span class="text-xs text-gray-400">Role cannot be changed after account creation.</span>
                    </div>
                </div>

                {{-- ── Student Profile Details ── --}}
                @if($user->role === 'student')
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-sm font-semibold text-gray-700">Student Profile Details</h3>
                        </div>
                        {{-- 1 col mobile → 2 col sm+ --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Department</label>
                                <input type="text"
                                       name="department"
                                       value="{{ old('department', $user->studentProfile?->department) }}"
                                       placeholder="e.g. Psychology"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Year Level</label>
                                <select name="year_level"
                                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer">
                                    <option value="">Select...</option>
                                    @foreach(['First Year','Second Year','Third Year','Fourth Year','Fifth Year','Graduate'] as $yr)
                                        <option value="{{ $yr }}" {{ old('year_level', $user->studentProfile?->year_level) === $yr ? 'selected' : '' }}>
                                            {{ $yr }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Bio</label>
                            <textarea name="bio"
                                      rows="3"
                                      placeholder="Short bio or notes about this student..."
                                      class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition resize-none">{{ old('bio', $user->studentProfile?->bio) }}</textarea>
                        </div>
                    </div>
                @endif

                {{-- ── Counselor Profile Details ── --}}
                @if($user->role === 'counselor')
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                                <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
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
                                       value="{{ old('specialization', $user->counselorProfile?->specialization) }}"
                                       placeholder="e.g. Career Counseling"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Office Location</label>
                                <input type="text"
                                       name="office_location"
                                       value="{{ old('office_location', $user->counselorProfile?->office_location) }}"
                                       placeholder="e.g. Room 201"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Contact Number</label>
                                <input type="text"
                                       name="contact_number"
                                       value="{{ old('contact_number', $user->counselorProfile?->contact_number) }}"
                                       placeholder="+63 9XX XXX XXXX"
                                       class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Bio</label>
                            <textarea name="bio"
                                      rows="3"
                                      placeholder="Professional summary visible to students..."
                                      class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition resize-none">{{ old('bio', $user->counselorProfile?->bio) }}</textarea>
                        </div>
                    </div>
                @endif

            </div>

            {{-- ── Form Actions ── --}}
            <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3 mt-5">
                <a href="{{ route('admin.users.show', $user) }}"
                   class="flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Discard Changes
                </a>
                <button type="submit"
                        class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-colors shadow-md shadow-blue-200 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Save Changes
                </button>
            </div>

        </form>

    </div>

@endsection