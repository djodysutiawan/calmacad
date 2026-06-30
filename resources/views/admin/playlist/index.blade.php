
<x-layouts.admin title="Playlist">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-display text-2xl font-semibold t1">Playlist Terapeutik</h1>
            <p class="t2 mt-1 text-sm">Kelola lagu-lagu yang direkomendasikan untuk tiap tingkat stres.</p>
        </div>
        <a href="{{ route('admin.playlist.create') }}"
           class="inline-flex items-center gap-2 rounded-full px-5 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
           style="background: linear-gradient(135deg, #7FA98D, #3FA796); box-shadow: 0 4px 16px rgba(127,169,141,0.35);">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            Tambah Lagu
        </a>
    </div>

    <div class="rounded-2xl glass overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm border-separate border-spacing-0">
                <thead>
                    <tr class="text-left text-[11px] t3 font-mono uppercase tracking-wide surf-1">
                        <th class="px-6 py-3 font-medium">Lagu</th>
                        <th class="px-6 py-3 font-medium">Tingkat Stres</th>
                        <th class="px-6 py-3 font-medium">Tautan</th>
                        <th class="px-6 py-3 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($playlist as $p)
                        <tr class="group transition hover-surf">
                            <td class="px-6 py-3.5 border-t hairline">
                                <button type="button"
                                        onclick="openPlayer(@js($p->judul_lagu), @js($p->artis), @js($p->youtube_url), @js($p->spotify_url))"
                                        class="flex items-center gap-3 text-left w-full group/play {{ (!$p->youtube_url && !$p->spotify_url) ? 'cursor-default' : '' }}"
                                        {{ (!$p->youtube_url && !$p->spotify_url) ? 'disabled' : '' }}>
                                    <span class="relative w-10 h-10 rounded-lg shrink-0 overflow-hidden">
                                        @if ($p->cover_url)
                                            <img src="{{ $p->cover_url }}" alt="{{ $p->judul_lagu }}"
                                                 class="w-10 h-10 rounded-lg object-cover shrink-0" style="box-shadow: inset 0 0 0 1px var(--border-glass);"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <span class="w-10 h-10 rounded-lg shrink-0 items-center justify-center surf-2 hidden">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 t3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
                                            </span>
                                        @else
                                            <span class="w-10 h-10 rounded-lg shrink-0 flex items-center justify-center surf-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 t3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
                                            </span>
                                        @endif
                                        @if ($p->youtube_url || $p->spotify_url)
                                            <span class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover/play:opacity-100 transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                                            </span>
                                        @endif
                                    </span>
                                    <span class="min-w-0">
                                        <p class="t1 font-medium truncate">{{ $p->judul_lagu }}</p>
                                        <p class="text-xs t3 truncate">{{ $p->artis }}</p>
                                    </span>
                                </button>
                            </td>
                            <td class="px-6 py-3.5 border-t hairline">
                                @if ($p->tingkatStres)
                                    <span class="inline-flex items-center gap-1.5 text-xs t2">
                                        <span class="w-1.5 h-1.5 rounded-full shrink-0" style="background: {{ $p->tingkatStres->warna_hex }}; box-shadow: 0 0 6px {{ $p->tingkatStres->warna_hex }};"></span>
                                        {{ $p->tingkatStres->nama }}
                                    </span>
                                @else
                                    <span class="text-xs t3">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-3.5 border-t hairline">
                                <div class="flex items-center gap-3">
                                    @if ($p->spotify_url)
                                        <a href="{{ $p->spotify_url }}" target="_blank" rel="noopener" class="t2 hover:opacity-70 transition" title="Buka di Spotify">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.6.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.42 1.56-.299.421-1.02.599-1.559.3z"/></svg>
                                        </a>
                                    @endif
                                    @if ($p->youtube_url)
                                        <a href="{{ $p->youtube_url }}" target="_blank" rel="noopener" class="t2 hover:opacity-70 transition" title="Buka di YouTube">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                        </a>
                                    @endif
                                    @if (!$p->spotify_url && !$p->youtube_url)
                                        <span class="text-xs t3">—</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-3.5 border-t hairline text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.playlist.edit', $p) }}" class="t2 hover:opacity-70 transition" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.playlist.destroy', $p) }}"
                                          onsubmit="return confirm('Hapus lagu &quot;{{ $p->judul_lagu }}&quot; dari playlist?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="t3 hover:text-[#E8775A] transition" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center border-t hairline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 mx-auto t3 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
                                </svg>
                                <p class="t3 text-sm mb-4">Belum ada lagu di playlist.</p>
                                <a href="{{ route('admin.playlist.create') }}" class="text-sm font-medium" style="color: #7FA98D;">
                                    + Tambah lagu pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($playlist->hasPages())
            <div class="px-6 py-4 border-t hairline">
                {{ $playlist->links() }}
            </div>
        @endif
    </div>

    {{-- Modal Player --}}
    <div id="playerModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4" style="background: rgba(0,0,0,0.6);">
        <div class="w-full max-w-lg rounded-2xl glass p-6 relative">
            <button type="button" onclick="closePlayer()" class="absolute top-4 right-4 t2 hover:opacity-70 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>

            <p id="playerTitle" class="t1 font-medium pr-8 truncate"></p>
            <p id="playerArtist" class="text-xs t3 mb-4 truncate"></p>

            <div id="playerEmbedWrap" class="rounded-xl overflow-hidden" style="background: var(--bg-glass-hover);"></div>

            <p id="playerEmpty" class="text-xs t3 text-center py-10 hidden">
                Tautan lagu ini tidak valid atau tidak didukung untuk diputar langsung.
            </p>
        </div>
    </div>

    <script>
        function youtubeEmbedUrl(url) {
            if (!url) return null;
            const match = url.match(/(?:youtu\.be\/|[?&]v=|\/embed\/|\/shorts\/)([A-Za-z0-9_-]{11})/);
            if (!match) return null;
            return `https://www.youtube.com/embed/${match[1]}?autoplay=1`;
        }

        function spotifyEmbedUrl(url) {
            if (!url) return null;
            const match = url.match(/open\.spotify\.com\/(track|album|playlist|episode)\/([A-Za-z0-9]+)/);
            if (!match) return null;
            return `https://open.spotify.com/embed/${match[1]}/${match[2]}?utm_source=generator`;
        }

        function openPlayer(title, artist, youtubeUrl, spotifyUrl) {
            const yt = youtubeEmbedUrl(youtubeUrl);
            const sp = spotifyEmbedUrl(spotifyUrl);

            if (!yt && !sp) return;

            document.getElementById('playerTitle').textContent = title;
            document.getElementById('playerArtist').textContent = artist;

            const wrap = document.getElementById('playerEmbedWrap');
            const empty = document.getElementById('playerEmpty');
            empty.classList.add('hidden');
            wrap.classList.remove('hidden');

            if (yt) {
                wrap.innerHTML = `<iframe width="100%" height="280" src="${yt}" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen></iframe>`;
            } else if (sp) {
                wrap.innerHTML = `<iframe src="${sp}" width="100%" height="152" frameborder="0"
                    allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>`;
            } else {
                wrap.classList.add('hidden');
                empty.classList.remove('hidden');
            }

            const modal = document.getElementById('playerModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closePlayer() {
            document.getElementById('playerEmbedWrap').innerHTML = ''; // hentikan playback
            const modal = document.getElementById('playerModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Tutup modal saat klik di luar konten / tekan Escape
        document.getElementById('playerModal').addEventListener('click', function (e) {
            if (e.target === this) closePlayer();
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closePlayer();
        });
    </script>

</x-layouts.admin>