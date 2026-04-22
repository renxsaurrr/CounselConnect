@extends('CounselConnect.layouts.admin')

@section('title', 'Edit Announcement')
@section('page-title', 'Announcements')

@section('content')

    {{-- ── Breadcrumb ── --}}
    <div class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="{{ route('admin.announcements.index') }}" class="hover:text-blue-600 transition-colors">Announcements</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <a href="{{ route('admin.announcements.show', $announcement) }}" class="hover:text-blue-600 transition-colors truncate max-w-xs">{{ $announcement->title }}</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
        <span class="text-gray-600 font-medium">Edit</span>
    </div>

    {{-- ── Page Header ── --}}
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Edit Announcement</h2>
        <p class="text-sm text-gray-400 mt-1">Update the content and settings for this announcement.</p>
    </div>

    <div class="max-w-2xl mx-auto">

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

        <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}">
            @csrf @method('PATCH')

            <div class="bg-white rounded-2xl border border-gray-100 p-7 space-y-6">

                {{-- Current Announcement Badge --}}
                <div class="flex items-center gap-3 p-3.5 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                        <svg class="w-4.5 h-4.5 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $announcement->title }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Posted {{ $announcement->created_at->format('M d, Y') }} · by {{ $announcement->author?->name ?? 'Unknown' }}</p>
                    </div>
                </div>

                {{-- Title --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Announcement Title</label>
                    <input type="text"
                           name="title"
                           value="{{ old('title', $announcement->title) }}"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition @error('title') border-red-300 bg-red-50 @enderror">
                </div>

                {{-- Target Audience --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Target Audience</label>
                    <select name="audience"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition appearance-none cursor-pointer @error('audience') border-red-300 bg-red-50 @enderror">
                        <option value="all"        {{ old('audience', $announcement->audience) === 'all'        ? 'selected' : '' }}>All Users</option>
                        <option value="students"   {{ old('audience', $announcement->audience) === 'students'   ? 'selected' : '' }}>Students Only</option>
                        <option value="counselors" {{ old('audience', $announcement->audience) === 'counselors' ? 'selected' : '' }}>Counselors Only</option>
                    </select>
                </div>

                {{-- Body --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">Body Message</label>
                    <textarea name="body"
                              rows="8"
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-400 transition resize-none @error('body') border-red-300 bg-red-50 @enderror">{{ old('body', $announcement->body) }}</textarea>
                </div>

                {{-- Publish Toggle --}}
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
                               {{ old('is_published', $announcement->is_published ? '1' : '0') == '1' ? 'checked' : '' }}
                               class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-100 rounded-full peer
                                    peer-checked:after:translate-x-full peer-checked:after:border-white
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:border-gray-300 after:border after:rounded-full
                                    after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </div>

            </div>

            {{-- Form Actions --}}
            <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-between gap-3 mt-5">
                <a href="{{ route('admin.announcements.show', $announcement) }}"
                   class="flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl border
                    border-gray-200 text-sm font-medium text-gray-500 hover:bg-gray-100
                     hover:text-gray-700 transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Discard Changes
                </a>
                <button type="submit"
                        class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700
                         active:bg-blue-800 text-white text-sm font-semibold px-6 py-2.5
                          rounded-xl transition-colors shadow-md shadow-blue-200 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Save Changes
                </button>
            </div>

        </form>

    </div>

@endsection