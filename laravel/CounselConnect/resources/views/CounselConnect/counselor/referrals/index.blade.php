@extends('CounselConnect.layouts.counselor')

@section('title', 'Referrals')
@section('page-title', 'Referrals')

@section('content')

{{-- ── Header ── --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <p class="text-sm text-gray-500">Manage referrals you've sent and received from other counselors.</p>
    <a href="{{ route('counselor.referrals.create') }}"
       class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition-colors shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
        </svg>
        Send Referral
    </a>
</div>

{{-- ── Flash ── --}}
@if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-xl bg-green-50 border border-green-100 text-green-700 text-sm">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
@endif

{{-- ── Stats Row ── --}}
<div class="grid grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-4 sm:px-6 py-4 flex items-center gap-3 sm:gap-4">
        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
        <div class="min-w-0">
            <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $received->count() }}</p>
            <p class="text-xs text-gray-400 mt-0.5 truncate">Incoming Referrals</p>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-4 sm:px-6 py-4 flex items-center gap-3 sm:gap-4">
        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl bg-green-50 flex items-center justify-center shrink-0">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
            </svg>
        </div>
        <div class="min-w-0">
            <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $sent->count() }}</p>
            <p class="text-xs text-gray-400 mt-0.5 truncate">Outgoing Referrals</p>
        </div>
    </div>
</div>

{{-- ── Tabs ── --}}
<div class="flex items-center gap-1 mb-4">
    <button id="tab-received" onclick="switchTab('received')"
            class="px-4 py-2 rounded-xl text-sm font-medium transition-colors bg-blue-600 text-white cursor-pointer">
        Incoming
        @if($received->where('status', 'pending')->count() > 0)
            <span class="ml-1.5 inline-flex items-center justify-center px-1.5 py-0.5 rounded-full bg-white/20 text-xs font-semibold cursor-pointer">
                {{ $received->where('status', 'pending')->count() }}
            </span>
        @endif
    </button>
    <button id="tab-sent" onclick="switchTab('sent')"
            class="px-4 py-2 rounded-xl text-sm font-medium transition-colors bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 cursor-pointer">
        Outgoing
    </button>
</div>

{{-- ── Received Panel ── --}}
<div id="panel-received">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if($received->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-center px-4">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-900">No incoming referrals</h3>
                <p class="text-sm text-gray-400 mt-1">Referrals sent to you will appear here.</p>
            </div>
        @else
            {{-- Desktop Table --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full min-w-[640px]">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Student</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Referred By</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Reason</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($received as $referral)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                                            @if($referral->student->studentProfile?->profile_picture)
                                                <img src="{{ asset('storage/' . $referral->student->studentProfile->profile_picture) }}" alt="{{ $referral->student->name }}" class="w-full h-full object-cover">
                                            @else
                                                {{ strtoupper(substr($referral->student->name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $referral->student->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $referral->student->studentProfile?->department ?? '—' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm text-gray-800">{{ $referral->referredBy->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $referral->referredBy->counselorProfile?->specialization ?? 'Counselor' }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $referral->type === 'internal' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                                        {{ ucfirst($referral->type) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 max-w-xs">
                                    <p class="text-sm text-gray-600 truncate">{{ \Illuminate\Support\Str::limit($referral->reason, 50) }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $referral->isPending() ? 'bg-amber-50 text-amber-700' : 'bg-green-50 text-green-700' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $referral->isPending() ? 'bg-amber-500' : 'bg-green-500' }}"></span>
                                        {{ ucfirst($referral->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('counselor.referrals.show', $referral) }}"
                                       class="inline-flex items-center px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-100 transition-colors">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="md:hidden divide-y divide-gray-100">
                @foreach($received as $referral)
                    <div class="px-4 py-4">
                        {{-- Top row: avatar + name + status --}}
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                                    @if($referral->student->studentProfile?->profile_picture)
                                        <img src="{{ asset('storage/' . $referral->student->studentProfile->profile_picture) }}" alt="{{ $referral->student->name }}" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr($referral->student->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $referral->student->name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ $referral->student->studentProfile?->department ?? '—' }}</p>
                                </div>
                            </div>
                            <span class="inline-flex shrink-0 items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $referral->isPending() ? 'bg-amber-50 text-amber-700' : 'bg-green-50 text-green-700' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $referral->isPending() ? 'bg-amber-500' : 'bg-green-500' }}"></span>
                                {{ ucfirst($referral->status) }}
                            </span>
                        </div>

                        {{-- Meta --}}
                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1.5 mb-2">
                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $referral->type === 'internal' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                                {{ ucfirst($referral->type) }}
                            </span>
                            <p class="text-xs text-gray-500">From: <span class="text-gray-700">{{ $referral->referredBy->name }}</span></p>
                        </div>

                        {{-- Reason snippet --}}
                        <p class="text-xs text-gray-500 mb-3 line-clamp-2">{{ $referral->reason }}</p>

                        <a href="{{ route('counselor.referrals.show', $referral) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                            View Details →
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

{{-- ── Sent Panel ── --}}
<div id="panel-sent" class="hidden">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        @if($sent->isEmpty())
            <div class="flex flex-col items-center justify-center py-20 text-center px-4">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-900">No outgoing referrals</h3>
                <p class="text-sm text-gray-400 mt-1">Referrals you send will appear here.</p>
            </div>
        @else
            {{-- Desktop Table --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full min-w-[640px]">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Student</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Referred To</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Reason</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($sent as $referral)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                                            @if($referral->student->studentProfile?->profile_picture)
                                                <img src="{{ asset('storage/' . $referral->student->studentProfile->profile_picture) }}" alt="{{ $referral->student->name }}" class="w-full h-full object-cover">
                                            @else
                                                {{ strtoupper(substr($referral->student->name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $referral->student->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $referral->student->studentProfile?->department ?? '—' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <p class="text-sm text-gray-800">{{ $referral->referredTo->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $referral->referredTo->counselorProfile?->specialization ?? 'Counselor' }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $referral->type === 'internal' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                                        {{ ucfirst($referral->type) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 max-w-xs">
                                    <p class="text-sm text-gray-600 truncate">{{ \Illuminate\Support\Str::limit($referral->reason, 50) }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $referral->isPending() ? 'bg-amber-50 text-amber-700' : 'bg-green-50 text-green-700' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $referral->isPending() ? 'bg-amber-500' : 'bg-green-500' }}"></span>
                                        {{ ucfirst($referral->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('counselor.referrals.show', $referral) }}"
                                       class="inline-flex items-center px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Mobile Cards --}}
            <div class="md:hidden divide-y divide-gray-100">
                @foreach($sent as $referral)
                    <div class="px-4 py-4">
                        {{-- Top row: avatar + name + status --}}
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold shrink-0 overflow-hidden">
                                    @if($referral->student->studentProfile?->profile_picture)
                                        <img src="{{ asset('storage/' . $referral->student->studentProfile->profile_picture) }}" alt="{{ $referral->student->name }}" class="w-full h-full object-cover">
                                    @else
                                        {{ strtoupper(substr($referral->student->name, 0, 1)) }}
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $referral->student->name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ $referral->student->studentProfile?->department ?? '—' }}</p>
                                </div>
                            </div>
                            <span class="inline-flex shrink-0 items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $referral->isPending() ? 'bg-amber-50 text-amber-700' : 'bg-green-50 text-green-700' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $referral->isPending() ? 'bg-amber-500' : 'bg-green-500' }}"></span>
                                {{ ucfirst($referral->status) }}
                            </span>
                        </div>

                        {{-- Meta --}}
                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1.5 mb-2">
                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $referral->type === 'internal' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                                {{ ucfirst($referral->type) }}
                            </span>
                            <p class="text-xs text-gray-500">To: <span class="text-gray-700">{{ $referral->referredTo->name }}</span></p>
                        </div>

                        {{-- Reason snippet --}}
                        <p class="text-xs text-gray-500 mb-3 line-clamp-2">{{ $referral->reason }}</p>

                        <a href="{{ route('counselor.referrals.show', $referral) }}"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                            View Details →
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
    function switchTab(tab) {
        document.getElementById('panel-received').classList.toggle('hidden', tab !== 'received');
        document.getElementById('panel-sent').classList.toggle('hidden', tab !== 'sent');

        ['received', 'sent'].forEach(t => {
            const btn = document.getElementById('tab-' + t);
            if (t === tab) {
                btn.className = 'px-4 py-2 rounded-xl text-sm font-medium transition-colors bg-blue-600 text-white cursor-pointer';
            } else {
                btn.className = 'px-4 py-2 rounded-xl text-sm font-medium transition-colors bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 cursor-pointer';
            }
        });
    }
</script>
@endpush