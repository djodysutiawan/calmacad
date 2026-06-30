<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gejala;
use App\Services\AuditService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GejalaController extends Controller
{
    public function __construct(private AuditService $auditService) {}

    public function index(): View
    {
        $gejala = Gejala::ordered()->paginate(15);

        return view('admin.gejala.index', compact('gejala'));
    }

    public function create(): View
    {
        return view('admin.gejala.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode'        => ['required', 'string', 'max:5', 'unique:gejala,kode'],
            'nama_gejala' => ['required', 'string'],
            'kategori'    => ['required', 'in:fisik,emosi,kognitif,perilaku,kritis'],
            'cf_pakar'    => ['required', 'numeric', 'between:0,1'],
            'deskripsi'   => ['nullable', 'string'],
            'is_active'   => ['boolean'],
            'urutan'      => ['integer'],
        ]);

        $gejala = Gejala::create($validated);

        $this->auditService->log('create', 'gejala', $gejala->id, null, $gejala->toArray());

        return redirect()
            ->route('admin.gejala.index')
            ->with('success', 'Gejala berhasil ditambahkan.');
    }

    public function edit(Gejala $gejala): View
    {
        return view('admin.gejala.edit', compact('gejala'));
    }

    public function update(Request $request, Gejala $gejala): RedirectResponse
    {
        $validated = $request->validate([
            'kode'        => ['required', 'string', 'max:5', 'unique:gejala,kode,' . $gejala->id],
            'nama_gejala' => ['required', 'string'],
            'kategori'    => ['required', 'in:fisik,emosi,kognitif,perilaku,kritis'],
            'cf_pakar'    => ['required', 'numeric', 'between:0,1'],
            'deskripsi'   => ['nullable', 'string'],
            'is_active'   => ['boolean'],
            'urutan'      => ['integer'],
        ]);

        $old = $gejala->toArray();
        $gejala->update($validated);

        $this->auditService->log('update', 'gejala', $gejala->id, $old, $gejala->toArray());

        return redirect()
            ->route('admin.gejala.index')
            ->with('success', 'Gejala berhasil diperbarui.');
    }

    public function destroy(Gejala $gejala): RedirectResponse
    {
        $old = $gejala->toArray();
        $gejala->delete();

        $this->auditService->log('delete', 'gejala', $gejala->id, $old, null);

        return redirect()
            ->route('admin.gejala.index')
            ->with('success', 'Gejala berhasil dihapus.');
    }

    /**
     * Nonaktifkan gejala tanpa hapus permanen (soft toggle).
     */
    public function toggleActive(Gejala $gejala): RedirectResponse
    {
        $old = $gejala->toArray();
        $gejala->update(['is_active' => ! $gejala->is_active]);

        $this->auditService->log('update', 'gejala', $gejala->id, $old, $gejala->toArray());

        return back()->with('success', 'Status gejala berhasil diubah.');
    }
}