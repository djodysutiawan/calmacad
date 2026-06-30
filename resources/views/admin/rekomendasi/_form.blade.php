
@php
    $kategoriOptions = [
        'penanganan' => 'Penanganan',
        'healing'    => 'Healing',
        'darurat'    => 'Darurat',
    ];
@endphp

<div class="grid sm:grid-cols-2 gap-5">

    <div>
        <label for="tingkat_stres_id" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Tingkat Stres</label>
        <select id="tingkat_stres_id" name="tingkat_stres_id" required
                class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
                style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
            <option value="" style="background: var(--option-bg); color: var(--option-text);">Pilih tingkat</option>
            @foreach ($tingkatStres as $t)
                <option value="{{ $t->id }}" style="background: var(--option-bg); color: var(--option-text);"
                    {{ (string) old('tingkat_stres_id', $rekomendasi->tingkat_stres_id ?? '') === (string) $t->id ? 'selected' : '' }}>
                    {{ $t->nama }}
                </option>
            @endforeach
        </select>
        @error('tingkat_stres_id')
            <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="kategori" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Kategori</label>
        <select id="kategori" name="kategori" required
                class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
                style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
            <option value="" style="background: var(--option-bg); color: var(--option-text);">Pilih kategori</option>
            @foreach ($kategoriOptions as $value => $label)
                <option value="{{ $value }}" style="background: var(--option-bg); color: var(--option-text);"
                    {{ old('kategori', $rekomendasi->kategori ?? '') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('kategori')
            <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-5">
    <label for="judul" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Judul</label>
    <input id="judul" name="judul" type="text" maxlength="200" required
           value="{{ old('judul', $rekomendasi->judul ?? '') }}"
           placeholder="cth. Atur jadwal istirahat yang cukup"
           class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
           style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
    @error('judul')
        <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
    @enderror
</div>

<div class="mt-5">
    <label for="konten" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Konten</label>
    <textarea id="konten" name="konten" rows="5" required
              placeholder="Jelaskan rekomendasi secara lengkap..."
              class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2 resize-none"
              style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">{{ old('konten', $rekomendasi->konten ?? '') }}</textarea>
    @error('konten')
        <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
    @enderror
</div>

<div class="mt-5 sm:w-48">
    <label for="urutan" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Urutan Tampil</label>
    <input id="urutan" name="urutan" type="number" min="0"
           value="{{ old('urutan', $rekomendasi->urutan ?? 0) }}"
           class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2 font-mono"
           style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
    @error('urutan')
        <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
    @enderror
</div>