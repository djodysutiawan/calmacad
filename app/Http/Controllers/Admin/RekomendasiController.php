<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rekomendasi;
use App\Models\TingkatStres;
use App\Services\AuditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RekomendasiController extends Controller
{
    public function __construct(private AuditService $auditService) {}

    public function index(): View
    {
        $rekomendasi = Rekomendasi::with('tingkatStres')->orderBy('urutan')->paginate(15);

        return view('admin.rekomendasi.index', compact('rekomendasi'));
    }

    public function create(): View
    {
        $tingkatStres = TingkatStres::orderBy('urutan')->get();

        return view('admin.rekomendasi.create', compact('tingkatStres'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tingkat_stres_id' => ['required', 'exists:tingkat_stres,id'],
            'kategori'         => ['required', 'in:penanganan,healing,darurat'],
            'judul'            => ['required', 'string', 'max:200'],
            'konten'           => ['required', 'string'],
            'urutan'           => ['integer'],
        ]);

        $rekomendasi = Rekomendasi::create($validated);

        $this->auditService->log('create', 'rekomendasi', $rekomendasi->id, null, $rekomendasi->toArray());

        return redirect()
            ->route('admin.rekomendasi.index')
            ->with('success', 'Rekomendasi berhasil ditambahkan.');
    }

    public function edit(Rekomendasi $rekomendasi): View
    {
        $tingkatStres = TingkatStres::orderBy('urutan')->get();

        return view('admin.rekomendasi.edit', compact('rekomendasi', 'tingkatStres'));
    }

    public function update(Request $request, Rekomendasi $rekomendasi): RedirectResponse
    {
        $validated = $request->validate([
            'tingkat_stres_id' => ['required', 'exists:tingkat_stres,id'],
            'kategori'         => ['required', 'in:penanganan,healing,darurat'],
            'judul'            => ['required', 'string', 'max:200'],
            'konten'           => ['required', 'string'],
            'urutan'           => ['integer'],
        ]);

        $old = $rekomendasi->toArray();
        $rekomendasi->update($validated);

        $this->auditService->log('update', 'rekomendasi', $rekomendasi->id, $old, $rekomendasi->toArray());

        return redirect()
            ->route('admin.rekomendasi.index')
            ->with('success', 'Rekomendasi berhasil diperbarui.');
    }

    public function destroy(Rekomendasi $rekomendasi): RedirectResponse
    {
        $old = $rekomendasi->toArray();
        $rekomendasi->delete();

        $this->auditService->log('delete', 'rekomendasi', $rekomendasi->id, $old, null);

        return redirect()
            ->route('admin.rekomendasi.index')
            ->with('success', 'Rekomendasi berhasil dihapus.');
    }
}