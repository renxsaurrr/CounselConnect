@extends('CounselConnect.layouts.admin')

@section('title', 'Announcements')
@section('page-title', 'Announcements')

@section('content')

    {{-- ── Page Header ── --}}
    <div class="flex items-start justify-between gap-3 mb-6">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Announcements Manager</h2>
            <p class="text-sm text-gray-400 mt-1 hidden sm:block">Broadcast important updates, maintenance alerts, and messages to specific user groups across the platform.</p>
        </div>
        <button onclick="openModal()"
                class="shrink-0 flex items-center gap-2 bg-blue-600 hover:bg-blue-700
                 active:bg-blue-800 text-white text-sm font-semibold px-4 py-2.5 rounded-xl
                  transition-colors shadow-sm shadow-blue-200 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            <span class="hidden sm:inline">New Announcement</span>
            <span class="sm:hidden">New</span>
        </button>
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

    {{-- ── Stats Cards ── --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Live Now</p>
            <p class="text-3xl font-bold text-blue-600">{{ $announcements->where('is_published', true)->count() }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Total Sent</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($announcements->total()) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">For Students</p>
            <p class="text-3xl font-bold text-gray-900">{{ $announcements->where('audience', 'students')->count() }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">For Counselors</p>
            <p class="text-3xl font-bold text-gray-900">{{ $announcements->where('audience', 'counselors')->count() }}</p>
        </div>
    </div>

    {{-- ── Announcements Table ── --}}
    <div class="bg-white rounded-2xl border border-gray-100">

        <div class="px-4 sm:px-6 pt-5 pb-4 border-b border-gray-50 flex items-center justify-between gap-3">
            <h3 class="text-sm font-semibold text-gray-900">All Announcements</h3>
            <form method="GET" action="{{ route('admin.announcements.index') }}">
                <div class="flex items-center gap-1.5 text-xs text-gray-400">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M6 12h12M9 17h6"/>
                    </svg>
                    <select name="sort"
                            onchange="this.form.submit()"
                            class="bg-transparent text-xs text-gray-500 font-medium focus:outline-none cursor-pointer pr-1">
                        <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="published" {{ request('sort') === 'published' ? 'selected' : '' }}>Published First</option>
                        <option value="drafts" {{ request('sort') === 'drafts' ? 'selected' : '' }}>Drafts First</option>
                    </select>
                </div>
            </form>
        </div>

        {{-- ── Desktop Table (md+) ── --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-50">
                        <th class="text-left text-xs font-semibold text-gray-400 px-6 py-3">Title</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Audience</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Status</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Posted By</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Date</th>
                        <th class="text-left text-xs font-semibold text-gray-400 px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($announcements as $announcement)
                        <tr class="hover:bg-gray-50/60 transition-colors">

                            {{-- Title + Preview --}}
                            <td class="px-6 py-4 max-w-xs">
                                <p class="text-sm font-semibold text-gray-800 truncate">{{ $announcement->title }}</p>
                                <p class="text-xs text-gray-400 truncate mt-0.5">{{ Str::limit(strip_tags($announcement->body), 60) }}</p>
                            </td>

                            {{-- Audience --}}
                            <td class="px-4 py-4">
                                @php
                                    $audienceStyle = match($announcement->audience) {
                                        'students'   => 'bg-blue-50 text-blue-600',
                                        'counselors' => 'bg-green-50 text-green-600',
                                        default      => 'bg-gray-100 text-gray-600',
                                    };
                                    $audienceLabel = match($announcement->audience) {
                                        'students'   => 'Students',
                                        'counselors' => 'Counselors',
                                        default      => 'All Users',
                                    };
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold {{ $audienceStyle }}">
                                    {{ $audienceLabel }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $announcement->is_published ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                                    <span class="text-sm {{ $announcement->is_published ? 'text-gray-700' : 'text-gray-400' }}">
                                        {{ $announcement->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Author --}}
                            <td class="px-4 py-4">
                                <span class="text-sm text-gray-600">{{ $announcement->author?->name ?? '—' }}</span>
                            </td>

                            {{-- Date --}}
                            <td class="px-4 py-4">
                                <span class="text-sm text-gray-500">{{ $announcement->created_at->format('M d, Y') }}</span>
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('admin.announcements.show', $announcement) }}"
                                       class="p-1.5 rounded-lg text-gray-400 hover:bg-blue-50 hover:text-blue-600 transition-colors" title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.announcements.edit', $announcement) }}"
                                       class="p-1.5 rounded-lg text-gray-400 hover:bg-amber-50 hover:text-amber-600 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}"
                                          class="delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button"
                                                onclick="openDeleteModal(this)"
                                                data-title="{{ $announcement->title }}"
                                                class="p-1.5 rounded-lg text-gray-400 hover:bg-red-50 hover:text-red-500 transition-colors cursor-pointer" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                </svg>
                                <p class="text-sm text-gray-400">No announcements yet.</p>
                                <button onclick="openModal()" class="inline-block mt-3 text-xs text-blue-600 hover:underline font-medium">
                                    Create the first announcement →
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>{{-- end desktop table --}}

        {{-- ── Mobile Cards (below md) ── --}}
        <div class="md:hidden divide-y divide-gray-50">
            @forelse($announcements as $announcement)
                @php
                    $audienceStyle = match($announcement->audience) {
                        'students'   => 'bg-blue-50 text-blue-600',
                        'counselors' => 'bg-green-50 text-green-600',
                        default      => 'bg-gray-100 text-gray-600',
                    };
                    $audienceLabel = match($announcement->audience) {
                        'students'   => 'Students',
                        'counselors' => 'Counselors',
                        default      => 'All Users',
                    };
                @endphp
                <div class="px-4 py-4">
                    {{-- Top row: title + status dot --}}
                    <div class="flex items-start justify-between gap-3 mb-1.5">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $announcement->title }}</p>
                            <p class="text-xs text-gray-400 truncate mt-0.5">{{ Str::limit(strip_tags($announcement->body), 70) }}</p>
                        </div>
                        <span class="flex items-center gap-1 shrink-0 text-xs {{ $announcement->is_published ? 'text-green-600' : 'text-gray-400' }}">
                            <span class="w-1.5 h-1.5 rounded-full {{ $announcement->is_published ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                            {{ $announcement->is_published ? 'Live' : 'Draft' }}
                        </span>
                    </div>

                    {{-- Meta row --}}
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1.5 mt-2 mb-3">
                        <span class="inline-flex px-2 py-0.5 rounded-lg text-xs font-semibold {{ $audienceStyle }}">{{ $audienceLabel }}</span>
                        <span class="text-xs text-gray-400">{{ $announcement->author?->name ?? '—' }}</span>
                        <span class="text-xs text-gray-400">{{ $announcement->created_at->format('M d, Y') }}</span>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.announcements.show', $announcement) }}"
                           class="flex-1 flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            View
                        </a>
                        <a href="{{ route('admin.announcements.edit', $announcement) }}"
                           class="flex-1 flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-amber-600 hover:bg-amber-50 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                            </svg>
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}"
                              class="delete-form">
                            @csrf @method('DELETE')
                            <button type="button"
                                    onclick="openDeleteModal(this)"
                                    data-title="{{ $announcement->title }}"
                                    class="flex items-center justify-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-red-400 hover:bg-red-50 hover:border-red-200 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="px-4 py-12 text-center">
                    <p class="text-sm text-gray-400 font-medium">No announcements yet.</p>
                    <button onclick="openModal()" class="inline-block mt-2 text-xs text-blue-600 hover:underline font-medium">
                        Create the first announcement →
                    </button>
                </div>
            @endforelse
        </div>{{-- end mobile cards --}}

        {{-- Pagination --}}
        @if($announcements->hasPages())
            <div class="px-4 sm:px-6 py-4 border-t border-gray-50 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <p class="text-xs text-gray-400">
                    Showing {{ $announcements->firstItem() }}–{{ $announcements->lastItem() }} of {{ number_format($announcements->total()) }} announcements
                </p>
                <div class="flex items-center gap-1">
                    @if($announcements->onFirstPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        </span>
                    @else
                        <a href="{{ $announcements->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        </a>
                    @endif
                    @foreach($announcements->getUrlRange(max(1, $announcements->currentPage()-2), min($announcements->lastPage(), $announcements->currentPage()+2)) as $page => $url)
                        <a href="{{ $url }}"
                           class="w-8 h-8 flex items-center justify-center rounded-lg text-sm font-medium transition-colors
                                  {{ $page === $announcements->currentPage() ? 'bg-blue-600 text-white' : 'text-gray-500 hover:bg-gray-100' }}">
                            {{ $page }}
                        </a>
                    @endforeach
                    @if($announcements->hasMorePages())
                        <a href="{{ $announcements->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </a>
                    @else
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </span>
                    @endif
                </div>
            </div>
        @endif

    </div>

    {{-- ══════════════════════════════════════════════════════════
         Create Announcement Modal (slide-in panel from right)
    ══════════════════════════════════════════════════════════ --}}

    {{-- Backdrop --}}
    <div id="modalBackdrop"
         onclick="closeModal()"
         class="fixed inset-0 bg-black/30 backdrop-blur-sm z-40 hidden transition-opacity duration-200 opacity-0">
    </div>

    {{-- Panel --}}
    <div id="announcementModal"
         class="fixed top-0 right-0 h-full w-full max-w-md bg-white shadow-2xl z-50 flex flex-col
                translate-x-full transition-transform duration-300 ease-in-out">

        {{-- Modal Header --}}
        <div class="px-6 py-5 border-b border-gray-100 flex items-start justify-between shrink-0">
            <div>
                <h3 class="text-base font-bold text-gray-900">New Announcement</h3>
                <p class="text-xs text-gray-400 mt-0.5">Create and publish a new message to the portal.</p>
            </div>
            <button onclick="closeModal()"
                    class="w-7 h-7 flex items-center justify-center rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Modal Form --}}
        <form method="POST" action="{{ route('admin.announcements.store') }}"
              class="flex-1 overflow-y-auto flex flex-col">
            @csrf

            <div class="px-6 py-5 space-y-5 flex-1">

                {{-- Errors --}}
                @if($errors->any())
                    <div class="flex items-start gap-3 bg-red-50 border border-red-100 text-red-600 text-xs px-4 py-3 rounded-xl">
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

                {{-- Announcement Title --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Announcement Title</label>
                    <input type="text"
                           name="title"
                           value="{{ old('title') }}"
                           placeholder="e.g. Scheduled Maintenance Notice"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition @error('title') border-red-300 bg-red-50 @enderror">
                </div>

                {{-- Target Audience --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Target Audience</label>
                    <select name="audience"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer @error('audience') border-red-300 bg-red-50 @enderror">
                        <option value="all"        {{ old('audience') === 'all'        ? 'selected' : '' }}>All Users</option>
                        <option value="students"   {{ old('audience') === 'students'   ? 'selected' : '' }}>Students Only</option>
                        <option value="counselors" {{ old('audience') === 'counselors' ? 'selected' : '' }}>Counselors Only</option>
                    </select>
                </div>

                {{-- Body Message --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Body Message</label>
                    <textarea name="body"
                              rows="6"
                              placeholder="Draft your message here. Use clear and professional language..."
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition resize-none @error('body') border-red-300 bg-red-50 @enderror">{{ old('body') }}</textarea>
                </div>

                {{-- Toggle Options --}}
                <div class="space-y-3">

                    {{-- Publish Immediately --}}
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-100">
                        <div>
                            <p class="text-sm font-semibold text-gray-700">Publish Immediately</p>
                            <p class="text-xs text-gray-400 mt-0.5">The announcement will go live as soon as you save.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="is_published" value="0">
                            <input type="checkbox"
                                   name="is_published"
                                   value="1"
                                   {{ old('is_published', '1') == '1' ? 'checked' : '' }}
                                   class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-100 rounded-full peer
                                        peer-checked:after:translate-x-full peer-checked:after:border-white
                                        after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                        after:bg-white after:border-gray-300 after:border after:rounded-full
                                        after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                </div>

            </div>

            {{-- Modal Footer --}}
            <div class="px-6 py-4 border-t border-gray-100 flex items-center gap-3 shrink-0">
                <button type="submit"
                        class="flex-1 flex items-center justify-center gap-2 bg-blue-600
                         hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-semibold py-3 rounded-xl
                          transition-colors shadow-md shadow-blue-200 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                    Create Announcement
                </button>
                <button type="button"
                        onclick="closeModal()"
                        class="px-5 py-3 rounded-xl border border-gray-200 text-sm font-medium
                         text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors
                          cursor-pointer">
                    Discard
                </button>
            </div>

        </form>
    </div>

    {{-- ── Delete Confirmation Modal ── --}}
    <div id="deleteModal" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4">
        <div id="deleteModalBackdrop"
             onclick="closeDeleteModal()"
             class="absolute inset-0 bg-black/30 backdrop-blur-sm opacity-0 transition-opacity duration-200"></div>
        <div id="deleteModalBox"
             class="relative bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 opacity-0 translate-y-3 transition-all duration-200">

            {{-- Icon + heading --}}
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900">Delete Announcement</p>
                    <p class="text-xs text-gray-400 mt-0.5">This action cannot be undone.</p>
                </div>
            </div>

            <p class="text-sm text-gray-600 mb-5">
                Are you sure you want to delete <span id="deleteModalTitle" class="font-semibold text-gray-800"></span>?
            </p>

            <div class="flex items-center gap-3">
                <button type="button"
                        onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium text-gray-500 hover:bg-gray-50 transition-colors cursor-pointer">
                    Cancel
                </button>
                <button type="button"
                        id="deleteModalConfirm"
                        class="flex-1 px-4 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white text-sm font-semibold transition-colors cursor-pointer">
                    Delete
                </button>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    // ── New Announcement slide-in panel ──────────────────────────
    const modal    = document.getElementById('announcementModal');
    const backdrop = document.getElementById('modalBackdrop');

    function openModal() {
        backdrop.classList.remove('hidden');
        requestAnimationFrame(() => {
            backdrop.classList.remove('opacity-0');
            modal.classList.remove('translate-x-full');
        });
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        backdrop.classList.add('opacity-0');
        modal.classList.add('translate-x-full');
        setTimeout(() => {
            backdrop.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300);
    }

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', () => openModal());
    @endif

    // ── Delete confirmation modal ────────────────────────────────
    const deleteModal   = document.getElementById('deleteModal');
    const deleteBox     = document.getElementById('deleteModalBox');
    const deleteBg      = document.getElementById('deleteModalBackdrop');
    let   pendingForm   = null;

    function openDeleteModal(btn) {
        pendingForm = btn.closest('form');
        document.getElementById('deleteModalTitle').textContent = '"' + btn.dataset.title + '"';
        deleteModal.classList.remove('hidden');
        requestAnimationFrame(() => {
            deleteBg.classList.remove('opacity-0');
            deleteBox.classList.remove('opacity-0', 'translate-y-3');
        });
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        deleteBg.classList.add('opacity-0');
        deleteBox.classList.add('opacity-0', 'translate-y-3');
        setTimeout(() => {
            deleteModal.classList.add('hidden');
            document.body.style.overflow = '';
            pendingForm = null;
        }, 200);
    }

    document.getElementById('deleteModalConfirm').addEventListener('click', () => {
        if (pendingForm) pendingForm.submit();
    });

    // Escape closes whichever modal is open
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') { closeModal(); closeDeleteModal(); }
    });
</script>
@endpush 