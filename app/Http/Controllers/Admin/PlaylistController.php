<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\TingkatStres;
use App\Services\AuditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlaylistController extends Controller
{
    public function __construct(private AuditService $auditService) {}

    public function index(): View
    {
        $playlist = Playlist::with('tingkatStres')->orderBy('urutan')->paginate(15);

        return view('admin.playlist.index', compact('playlist'));
    }

    public function create(): View
    {
        $tingkatStres = TingkatStres::orderBy('urutan')->get();

        return view('admin.playlist.create', compact('tingkatStres'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tingkat_stres_id'      => ['required', 'exists:tingkat_stres,id'],
            'judul_lagu'            => ['required', 'string', 'max:200'],
            'artis'                 => ['required', 'string', 'max:150'],
            'keterangan_terapeutik' => ['nullable', 'string'],
            'spotify_url'           => ['nullable', 'url'],
            'youtube_url'           => ['nullable', 'url'],
            'cover_url'             => ['nullable', 'url'],
            'urutan'                => ['integer'],
        ]);

        $playlist = Playlist::create($validated);

        $this->auditService->log('create', 'playlist', $playlist->id, null, $playlist->toArray());

        return redirect()
            ->route('admin.playlist.index')
            ->with('success', 'Lagu berhasil ditambahkan ke playlist.');
    }

    public function edit(Playlist $playlist): View
    {
        $tingkatStres = TingkatStres::orderBy('urutan')->get();

        return view('admin.playlist.edit', compact('playlist', 'tingkatStres'));
    }

    public function update(Request $request, Playlist $playlist): RedirectResponse
    {
        $validated = $request->validate([
            'tingkat_stres_id'      => ['required', 'exists:tingkat_stres,id'],
            'judul_lagu'            => ['required', 'string', 'max:200'],
            'artis'                 => ['required', 'string', 'max:150'],
            'keterangan_terapeutik' => ['nullable', 'string'],
            'spotify_url'           => ['nullable', 'url'],
            'youtube_url'           => ['nullable', 'url'],
            'cover_url'             => ['nullable', 'url'],
            'urutan'                => ['integer'],
        ]);

        $old = $playlist->toArray();
        $playlist->update($validated);

        $this->auditService->log('update', 'playlist', $playlist->id, $old, $playlist->toArray());

        return redirect()
            ->route('admin.playlist.index')
            ->with('success', 'Lagu berhasil diperbarui.');
    }

    public function destroy(Playlist $playlist): RedirectResponse
    {
        $old = $playlist->toArray();
        $playlist->delete();

        $this->auditService->log('delete', 'playlist', $playlist->id, $old, null);

        return redirect()
            ->route('admin.playlist.index')
            ->with('success', 'Lagu berhasil dihapus dari playlist.');
    }
}