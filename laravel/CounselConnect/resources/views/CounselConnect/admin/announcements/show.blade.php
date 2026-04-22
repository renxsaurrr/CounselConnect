@extends('CounselConnect.layouts.admin')

@section('title', $announcement->title)
@section('page-title', 'Announcements')

@section('content')

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="{{ route('admin.announcements.index') }}" class="hover:text-blue-600 transition-colors">Announcements</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <span class="text-gray-600 font-medium truncate max-w-xs">{{ $announcement->title }}</span>
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

    <div class="max-w-3xl">

        {{-- ── Main Card ── --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">

            {{-- Card Header --}}
            <div class="px-7 py-6 border-b border-gray-50">
                <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                    <div class="flex-1">

                        {{-- Badges --}}
                        <div class="flex items-center gap-2 mb-3">
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
                            <span class="flex items-center gap-1.5 text-xs {{ $announcement->is_published ? 'text-green-600' : 'text-gray-400' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $announcement->is_published ? 'bg-green-500' : 'bg-gray-300' }}"></span>
                                {{ $announcement->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </div>

                        <h2 class="text-xl font-bold text-gray-900 leading-snug">{{ $announcement->title }}</h2>

                        <div class="flex items-center gap-3 mt-3 text-xs text-gray-400">
                            <div class="flex items-center gap-1.5">
                                <div class="w-5 h-5 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 text-xs font-bold shrink-0">
                                    {{ strtoupper(substr($announcement->author?->name ?? 'A', 0, 1)) }}
                                </div>
                                <span>{{ $announcement->author?->name ?? 'Unknown' }}</span>
                            </div>
                            <span>·</span>
                            <span>{{ $announcement->created_at->format('F d, Y \a\t g:i A') }}</span>
                            @if($announcement->updated_at->ne($announcement->created_at))
                                <span>· Edited {{ $announcement->updated_at->diffForHumans() }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 shrink-0 sm:self-start">
                        <a href="{{ route('admin.announcements.edit', $announcement) }}"
                           class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                            </svg>
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}"
                              onsubmit="return confirm('Delete this announcement permanently?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-gray-200 text-gray-400
                                     hover:bg-red-50 hover:text-red-500 hover:border-red-200 text-xs font-semibold 
                                     transition-colors cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="px-7 py-6">
                <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $announcement->body }}</div>
            </div>

        </div>

        {{-- ── Back Link ── --}}
        <div class="mt-5">
            <a href="{{ route('admin.announcements.index') }}"
               class="flex items-center gap-2 text-sm text-gray-400 hover:text-gray-600 transition-colors w-fit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                Back to Announcements
            </a>
        </div>

    </div>

@endsection