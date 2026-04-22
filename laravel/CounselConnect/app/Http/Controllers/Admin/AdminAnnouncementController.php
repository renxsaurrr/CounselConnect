<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAnnouncementController extends Controller
{
    // ─── List Announcements ──────────────────────────────────────
    public function index(Request $request)
    {
        $query = Announcement::with('author');

        match ($request->input('sort')) {
            'oldest'    => $query->oldest(),
            'published' => $query->orderBy('is_published', 'desc')->latest(),
            'drafts'    => $query->orderBy('is_published', 'asc')->latest(),
            default     => $query->latest(),
        };

        $announcements = $query->paginate(15)->withQueryString();

        return view('CounselConnect.admin.announcements.index', compact('announcements'));
    }

    // ─── Show Create Form ────────────────────────────────────────
    // The create form is embedded as a modal in the index page.
    // This route simply redirects back to index — the modal is
    // opened via JS on the frontend.
    public function create()
    {
        return redirect()->route('admin.announcements.index');
    }

    // ─── Store Announcement ──────────────────────────────────────
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'body'         => ['required', 'string'],
            'audience'     => ['required', 'in:all,students,counselors'],
            'is_published' => ['boolean'],
        ]);

        Announcement::create([
            'posted_by'    => Auth::id(),
            'title'        => $data['title'],
            'body'         => $data['body'],
            'audience'     => $data['audience'],
            'is_published' => $data['is_published'] ?? false,
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement created successfully.');
    }

    // ─── Show Single Announcement ────────────────────────────────
    public function show(Announcement $announcement)
    {
        return view('CounselConnect.admin.announcements.show', compact('announcement'));
    }

    // ─── Show Edit Form ──────────────────────────────────────────
    public function edit(Announcement $announcement)
    {
        return view('CounselConnect.admin.announcements.edit', compact('announcement'));
    }

    // ─── Update Announcement ─────────────────────────────────────
    public function update(Request $request, Announcement $announcement)
    {
        $data = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'body'         => ['required', 'string'],
            'audience'     => ['required', 'in:all,students,counselors'],
            'is_published' => ['boolean'],
        ]);

        $announcement->update($data);

        return redirect()->route('admin.announcements.show', $announcement)
            ->with('success', 'Announcement updated successfully.');
    }

    // ─── Delete Announcement ─────────────────────────────────────
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted.');
    }
}