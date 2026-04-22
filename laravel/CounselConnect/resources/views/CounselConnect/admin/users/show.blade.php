@extends('CounselConnect.layouts.admin')

@section('title', $user->name)
@section('page-title', 'User Profile')

@section('content')

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="{{ route('admin.users.index') }}" class="hover:text-blue-600 transition-colors">Users</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <span class="text-gray-600 font-medium truncate">{{ $user->name }}</span>
    </div>

    {{-- ── Flash Message ── --}}
    @if(session('success'))
        <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-100 text-green-700 text-sm px-4 py-3 rounded-xl">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── Layout: stacked on mobile → 3-col on lg ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Left: Profile Card ── --}}
        <div class="lg:col-span-1 space-y-5">

            {{-- Identity --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center">
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
                    $roleBadge = match($user->role) {
                        'student'   => 'bg-blue-50 text-blue-600',
                        'counselor' => 'bg-green-50 text-green-600',
                        'admin'     => 'bg-purple-50 text-purple-600',
                        default     => 'bg-gray-50 text-gray-500',
                    };
                @endphp

                <div class="w-20 h-20 rounded-2xl {{ $avatarBg }} flex items-center justify-center text-2xl font-bold mx-auto mb-4 overflow-hidden">
                    @if($pic)
                        <img src="{{ asset('storage/' . $pic) }}" class="w-full h-full object-cover" alt="{{ $user->name }}">
                    @else
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    @endif
                </div>

                <h3 class="text-base font-bold text-gray-900">{{ $user->name }}</h3>
                <p class="text-sm text-gray-400 mt-0.5 break-all">{{ $user->email }}</p>

                <div class="flex items-center justify-center gap-2 mt-3">
                    <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wide {{ $roleBadge }}">
                        {{ $user->role }}
                    </span>
                    <span class="flex items-center gap-1 text-xs {{ $user->is_active ? 'text-green-600' : 'text-gray-400' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $user->is_active ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <div class="flex gap-2 mt-5">
                    <a href="{{ route('admin.users.edit', $user) }}"
                       class="flex-1 flex items-center justify-center gap-1.5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                        </svg>
                        Edit
                    </a>
                    <form id="deactivate-form" method="POST" action="{{ route('admin.users.destroy', $user) }}">
                        @csrf @method('DELETE')
                        <button type="button"
                                onclick="document.getElementById('modal-deactivate').classList.remove('hidden')"
                                class="px-3 py-2.5 rounded-xl border border-gray-200 text-gray-400 hover:bg-red-50 hover:text-red-500 hover:border-red-200 text-xs font-semibold transition-colors cursor-pointer">
                            Deactivate
                        </button>
                    </form>
                </div>
            </div>

            {{-- Account Info --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-4">Account Info</h4>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-xs text-gray-400">Joined</dt>
                        <dd class="text-sm text-gray-700 font-medium mt-0.5">{{ $user->created_at->format('F d, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-400">Email Verified</dt>
                        <dd class="text-sm font-medium mt-0.5 {{ $user->email_verified_at ? 'text-green-600' : 'text-amber-500' }}">
                            {{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y') : 'Not verified' }}
                        </dd>
                    </div>
                    @if($user->role === 'student' && $user->studentProfile)
                        <div>
                            <dt class="text-xs text-gray-400">Student ID</dt>
                            <dd class="text-sm text-gray-700 font-medium mt-0.5">{{ $user->studentProfile->student_id ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-400">Department</dt>
                            <dd class="text-sm text-gray-700 font-medium mt-0.5">{{ $user->studentProfile->department ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-400">Year Level</dt>
                            <dd class="text-sm text-gray-700 font-medium mt-0.5">{{ $user->studentProfile->year_level ?? '—' }}</dd>
                        </div>
                    @elseif($user->role === 'counselor' && $user->counselorProfile)
                        <div>
                            <dt class="text-xs text-gray-400">Specialization</dt>
                            <dd class="text-sm text-gray-700 font-medium mt-0.5">{{ $user->counselorProfile->specialization ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-400">Office</dt>
                            <dd class="text-sm text-gray-700 font-medium mt-0.5">{{ $user->counselorProfile->office_location ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-gray-400">Contact</dt>
                            <dd class="text-sm text-gray-700 font-medium mt-0.5">{{ $user->counselorProfile->contact_number ?? '—' }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

        </div>

        {{-- ── Right: Activity (spans 2 cols on lg) ── --}}
        <div class="lg:col-span-2 space-y-5">

            @if($user->role === 'student')

                {{-- Appointments as Student --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-sm font-semibold text-gray-900">Appointments</h3>
                        <span class="text-xs text-gray-400">{{ $user->appointmentsAsStudent->count() }} total</span>
                    </div>
                    @if($user->appointmentsAsStudent->isEmpty())
                        <p class="text-sm text-gray-400 text-center py-8">No appointments on record.</p>
                    @else
                        <div class="space-y-2">
                            @foreach($user->appointmentsAsStudent->take(5) as $appt)
                                @php
                                    $colors = [
                                        'approved'  => 'bg-green-50 text-green-600',
                                        'pending'   => 'bg-amber-50 text-amber-600',
                                        'completed' => 'bg-blue-50 text-blue-600',
                                        'cancelled' => 'bg-red-50 text-red-500',
                                        'rejected'  => 'bg-red-50 text-red-500',
                                    ];
                                @endphp
                                <div class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0 gap-3">
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate">{{ $appt->concern_type }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5 truncate">with {{ $appt->counselor->name }} · {{ \Carbon\Carbon::parse($appt->preferred_date)->format('M d, Y') }}</p>
                                    </div>
                                    <span class="shrink-0 inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $colors[$appt->status] ?? 'bg-gray-50 text-gray-500' }}">
                                        {{ ucfirst($appt->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Session Records --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-sm font-semibold text-gray-900">Session Records</h3>
                        <span class="text-xs text-gray-400">{{ $user->sessionRecordsAsStudent->count() }} total</span>
                    </div>
                    @if($user->sessionRecordsAsStudent->isEmpty())
                        <p class="text-sm text-gray-400 text-center py-8">No session records yet.</p>
                    @else
                        <div class="space-y-2">
                            @foreach($user->sessionRecordsAsStudent->take(5) as $session)
                                <div class="py-2.5 border-b border-gray-50 last:border-0">
                                    <div class="flex items-center justify-between gap-3">
                                        <p class="text-sm font-medium text-gray-800">Session #{{ $session->id }}</p>
                                        <span class="text-xs text-gray-400 shrink-0">{{ $session->created_at->format('M d, Y') }}</span>
                                    </div>
                                    @if($session->session_notes)
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $session->session_notes }}</p>
                                    @endif
                                    @if($session->follow_up_needed)
                                        <span class="inline-flex items-center gap-1 mt-1.5 text-xs text-amber-600">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
                                            Follow-up needed
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            @elseif($user->role === 'counselor')

                {{-- Appointments as Counselor --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-sm font-semibold text-gray-900">Assigned Appointments</h3>
                        <span class="text-xs text-gray-400">{{ $user->appointmentsAsCounselor->count() }} total</span>
                    </div>
                    @if($user->appointmentsAsCounselor->isEmpty())
                        <p class="text-sm text-gray-400 text-center py-8">No appointments assigned.</p>
                    @else
                        <div class="space-y-2">
                            @foreach($user->appointmentsAsCounselor->take(5) as $appt)
                                @php
                                    $colors = [
                                        'approved'  => 'bg-green-50 text-green-600',
                                        'pending'   => 'bg-amber-50 text-amber-600',
                                        'completed' => 'bg-blue-50 text-blue-600',
                                        'cancelled' => 'bg-red-50 text-red-500',
                                        'rejected'  => 'bg-red-50 text-red-500',
                                    ];
                                @endphp
                                <div class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0 gap-3">
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate">{{ $appt->concern_type }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $appt->student->name }} · {{ \Carbon\Carbon::parse($appt->preferred_date)->format('M d, Y') }}</p>
                                    </div>
                                    <span class="shrink-0 inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $colors[$appt->status] ?? 'bg-gray-50 text-gray-500' }}">
                                        {{ ucfirst($appt->status) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Session Records as Counselor --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-sm font-semibold text-gray-900">Conducted Sessions</h3>
                        <span class="text-xs text-gray-400">{{ $user->sessionRecordsAsCounselor->count() }} total</span>
                    </div>
                    @if($user->sessionRecordsAsCounselor->isEmpty())
                        <p class="text-sm text-gray-400 text-center py-8">No sessions conducted yet.</p>
                    @else
                        <div class="space-y-2">
                            @foreach($user->sessionRecordsAsCounselor->take(5) as $session)
                                <div class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0 gap-3">
                                    <div class="min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate">Session with Student #{{ $session->student_id }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ $session->created_at->format('M d, Y') }}</p>
                                    </div>
                                    @if($session->follow_up_needed)
                                        <span class="shrink-0 inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-50 text-amber-600">
                                            Follow-up
                                        </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            @else

                {{-- Admin — simple info card --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 text-center">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                        </svg>
                    </div>
                    <p class="text-sm font-semibold text-gray-700">System Administrator</p>
                    <p class="text-xs text-gray-400 mt-1">This account has full administrative access to the CounselConnect portal.</p>
                </div>

            @endif

        </div>
    </div>

{{-- ── Deactivate Confirmation Modal ── --}}
<div id="modal-deactivate"
     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4"
     onclick="if(event.target===this) this.classList.add('hidden')">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm"></div>
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 z-10">
        <div class="flex items-center justify-center w-12 h-12 rounded-full bg-red-50 mx-auto mb-4">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
            </svg>
        </div>
        <h3 class="text-base font-semibold text-gray-900 text-center">Deactivate Account?</h3>
        <p class="text-sm text-gray-500 text-center mt-1.5">
            You're about to deactivate
            <span class="font-semibold text-gray-700">{{ $user->name }}</span>.
            This will revoke their access to the portal.
        </p>
        <div class="flex gap-3 mt-6">
            <button type="button"
                    onclick="document.getElementById('modal-deactivate').classList.add('hidden')"
                    class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors cursor-pointer">
                Cancel
            </button>
            <button type="button"
                    onclick="document.getElementById('deactivate-form').submit()"
                    class="flex-1 px-4 py-2.5 rounded-xl bg-red-600 text-white text-sm font-medium hover:bg-red-700 transition-colors cursor-pointer">
                Yes, Deactivate
            </button>
        </div>
    </div>
</div>

@endsection