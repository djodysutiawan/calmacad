<div class="grid sm:grid-cols-2 gap-5">

    <div>
        <label for="tingkat_stres_id" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Tingkat Stres</label>
        <select id="tingkat_stres_id" name="tingkat_stres_id" required
                class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
                style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
            <option value="" style="background: var(--option-bg); color: var(--option-text);">Pilih tingkat</option>
            @foreach ($tingkatStres as $t)
                <option value="{{ $t->id }}"
                        style="background: var(--option-bg); color: var(--option-text);"
                        {{ (string) old('tingkat_stres_id', $playlist->tingkat_stres_id ?? '') === (string) $t->id ? 'selected' : '' }}>
                    {{ $t->nama }}
                </option>
            @endforeach
        </select>
        @error('tingkat_stres_id')
            <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="urutan" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Urutan Tampil</label>
        <input id="urutan" name="urutan" type="number" min="0"
               value="{{ old('urutan', $playlist->urutan ?? 0) }}"
               class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2 font-mono"
               style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
        @error('urutan')
            <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="grid sm:grid-cols-2 gap-5 mt-5">

    <div>
        <label for="judul_lagu" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Judul Lagu</label>
        <input id="judul_lagu" name="judul_lagu" type="text" maxlength="200" required
               value="{{ old('judul_lagu', $playlist->judul_lagu ?? '') }}"
               placeholder="cth. Weightless"
               class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
               style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
        @error('judul_lagu')
            <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="artis" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Artis</label>
        <input id="artis" name="artis" type="text" maxlength="150" required
               value="{{ old('artis', $playlist->artis ?? '') }}"
               placeholder="cth. Marconi Union"
               class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
               style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
        @error('artis')
            <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-5">
    <label for="keterangan_terapeutik" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Keterangan Terapeutik (opsional)</label>
    <textarea id="keterangan_terapeutik" name="keterangan_terapeutik" rows="3"
              placeholder="Jelaskan efek atau manfaat lagu ini untuk meredakan stres..."
              class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2 resize-none"
              style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">{{ old('keterangan_terapeutik', $playlist->keterangan_terapeutik ?? '') }}</textarea>
    @error('keterangan_terapeutik')
        <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
    @enderror
</div>

<div class="grid sm:grid-cols-3 gap-5 mt-5">

    <div>
        <label for="spotify_url" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Spotify URL</label>
        <input id="spotify_url" name="spotify_url" type="url"
               value="{{ old('spotify_url', $playlist->spotify_url ?? '') }}"
               placeholder="https://open.spotify.com/..."
               class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
               style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
        @error('spotify_url')
            <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="youtube_url" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">YouTube URL</label>
        <input id="youtube_url" name="youtube_url" type="url"
               value="{{ old('youtube_url', $playlist->youtube_url ?? '') }}"
               placeholder="https://youtube.com/..."
               class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
               style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
        @error('youtube_url')
            <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="cover_url" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Cover URL</label>
        <input id="cover_url" name="cover_url" type="url"
               value="{{ old('cover_url', $playlist->cover_url ?? '') }}"
               placeholder="https://..."
               class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
               style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
        @error('cover_url')
            <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
        @enderror
    </div>
</div>