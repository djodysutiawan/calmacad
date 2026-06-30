@php
    $kategoriOptions = [
        'fisik'     => 'Fisik',
        'emosi'     => 'Emosi',
        'kognitif'  => 'Kognitif',
        'perilaku'  => 'Perilaku',
        'kritis'    => 'Kritis',
    ];
@endphp

<div class="grid sm:grid-cols-2 gap-5">

    <div>
        <label for="kode" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Kode</label>
        <input id="kode" name="kode" type="text" maxlength="5" required
               value="{{ old('kode', $gejala->kode ?? '') }}"
               placeholder="cth. G01"
               class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2 font-mono"
               style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
        @error('kode')
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
                    {{ old('kategori', $gejala->kategori ?? '') === $value ? 'selected' : '' }}>
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
    <label for="nama_gejala" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Nama Gejala</label>
    <input id="nama_gejala" name="nama_gejala" type="text" required
           value="{{ old('nama_gejala', $gejala->nama_gejala ?? '') }}"
           placeholder="cth. Sulit berkonsentrasi"
           class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
           style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
    @error('nama_gejala')
        <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
    @enderror
</div>

<div class="mt-5">
    <label for="deskripsi" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Deskripsi (opsional)</label>
    <textarea id="deskripsi" name="deskripsi" rows="3"
              placeholder="Penjelasan tambahan tentang gejala ini"
              class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2 resize-none"
              style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">{{ old('deskripsi', $gejala->deskripsi ?? '') }}</textarea>
    @error('deskripsi')
        <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
    @enderror
</div>

<div class="grid sm:grid-cols-2 gap-5 mt-5">

    <div>
        <label for="cf_pakar" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">
            CF Pakar <span class="t3 normal-case">(0.00 – 1.00)</span>
        </label>
        <input id="cf_pakar" name="cf_pakar" type="number" step="0.01" min="0" max="1" required
               value="{{ old('cf_pakar', $gejala->cf_pakar ?? '') }}"
               placeholder="cth. 0.80"
               class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2 font-mono"
               style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
        @error('cf_pakar')
            <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="urutan" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Urutan Tampil</label>
        <input id="urutan" name="urutan" type="number" min="0"
               value="{{ old('urutan', $gejala->urutan ?? 0) }}"
               class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2 font-mono"
               style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
        @error('urutan')
            <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-5">
    <label class="inline-flex items-center gap-2.5 cursor-pointer">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1"
               class="w-[18px] h-[18px] rounded-md accent-current"
               style="color: #7FA98D;"
               {{ old('is_active', $gejala->is_active ?? true) ? 'checked' : '' }}>
        <span class="text-sm t2">Aktifkan gejala ini (akan tampil di form konsultasi)</span>
    </label>
</div>