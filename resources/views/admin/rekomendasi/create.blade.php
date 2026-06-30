<x-layouts.admin title="Tambah Rekomendasi">

    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.rekomendasi.index') }}" class="t2 hover:opacity-70 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
        </a>
        <div>
            <h1 class="font-display text-2xl font-semibold t1">Tambah Rekomendasi</h1>
            <p class="t2 mt-1 text-sm">Buat saran baru untuk tingkat stres tertentu.</p>
        </div>
    </div>

    <div class="max-w-8xl rounded-2xl glass p-7">
        <form method="POST" action="{{ route('admin.rekomendasi.store') }}">
            @csrf

            @include('admin.rekomendasi._form', ['rekomendasi' => null, 'tingkatStres' => $tingkatStres])

            <div class="flex items-center gap-3 pt-7 mt-2 border-t hairline">
                <button type="submit"
                        class="inline-flex items-center rounded-full px-5 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
                        style="background: linear-gradient(135deg, #7FA98D, #3FA796); box-shadow: 0 4px 16px rgba(127,169,141,0.35);">
                    Simpan Rekomendasi
                </button>
                <a href="{{ route('admin.rekomendasi.index') }}" class="text-sm t2 hover:opacity-80 transition">Batal</a>
            </div>
        </form>
    </div>

</x-layouts.admin>s