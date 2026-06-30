{{--
    resources/views/consultation/index.blade.php

    Diterima dari ConsultationController@index:
    - $gejala (Collection<Gejala>, semua gejala aktif untuk konsultasi)

    Submit ke ConsultationController@submit (route: konsultasi.submit)

    Field yang dikirim (HARUS match dengan validasi di controller):
    - nama, jenis_kelamin, status_akademik
    - jawaban[gejala_id] = 0 | 0.4 | 0.6 | 0.8 | 1
--}}
<x-layouts.user title="Konsultasi Stres">

    <div
        x-data="konsultasiWizard({{ $gejala->pluck('id') }})"
        x-cloak
        class="max-w-2xl mx-auto"
    >

        {{-- ── Header ── --}}
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl mb-5" style="background: rgba(127,169,141,0.12);">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="#7FA98D" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 21c-4.97 0-9-3.694-9-8.25 0-1.94.752-3.722 2.003-5.13C6.367 5.62 9.039 4.5 12 4.5s5.633 1.12 6.997 3.12C20.248 9.028 21 10.81 21 12.75 21 17.306 16.97 21 12 21z"/>
                    <path d="M9 11.25h.008M15 11.25h.008M9.5 15.5c.75.667 1.75 1 2.5 1s1.75-.333 2.5-1"/>
                </svg>
            </div>
            <h1 class="font-display text-2xl sm:text-3xl font-semibold t1">Konsultasi Tingkat Stres</h1>
            <p class="text-sm t2 mt-3 max-w-md mx-auto leading-relaxed">
                Jawab satu per satu sesuai apa yang kamu rasakan saat ini. Santai saja, tidak ada jawaban yang salah.
            </p>
        </div>

        {{-- ── Progress bar ── --}}
        <div class="mb-8">
            <div class="flex items-center justify-between text-xs t3 font-mono uppercase tracking-wide mb-2">
                <span x-text="step === 0 ? 'Data Diri' : (step > totalGejala ? 'Ringkasan' : `Pertanyaan ${step} dari ${totalGejala}`)"></span>
                <span x-text="`${progressPercent}%`"></span>
            </div>
            <div class="h-1.5 rounded-full overflow-hidden" style="background: var(--bg-glass-hover);">
                <div class="h-full rounded-full transition-all duration-500 ease-out"
                     style="background: linear-gradient(135deg, #7FA98D, #3FA796);"
                     :style="`width: ${progressPercent}%`"></div>
            </div>
        </div>

        {{-- ── Error messages (server-side, hanya tampil saat redirect kembali dgn error) ── --}}
        @if ($errors->any())
            <div class="rounded-xl mb-6 px-4 py-3.5 text-sm" style="background: rgba(232,119,90,0.1); border: 1px solid rgba(232,119,90,0.3); color: #E8775A;">
                <p class="font-medium mb-1.5">Periksa kembali isianmu:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('konsultasi.submit') }}" @submit="onSubmit">
            @csrf

            {{-- Hidden inputs untuk data diri --}}
            <input type="hidden" name="nama" :value="nama">
            <input type="hidden" name="jenis_kelamin" :value="jenisKelamin">
            <input type="hidden" name="status_akademik" :value="statusAkademik">

            {{-- Hidden inputs untuk setiap jawaban gejala --}}
            <template x-for="gid in gejalaIds" :key="gid">
                <input type="hidden" :name="`jawaban[${gid}]`" :value="answers[gid] ?? ''">
            </template>

            <div class="rounded-2xl glass overflow-hidden relative" style="min-height: 340px;">

                {{-- ── STEP 0: Data diri ── --}}
                <div x-show="step === 0"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-x-4"
                     x-transition:enter-end="opacity-100 translate-x-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-x-0"
                     x-transition:leave-end="opacity-0 -translate-x-4"
                     class="p-6 sm:p-8 space-y-5">

                    <h2 class="text-sm font-semibold t1 mb-1">Sebelum mulai, kenalan dulu yuk</h2>
                    <p class="text-xs t3 mb-4">Data ini membantu hasil konsultasimu lebih akurat.</p>

                    <div>
                        <label class="block text-[10px] font-mono uppercase tracking-wider t3 mb-1.5">Nama</label>
                        <input type="text" x-model="nama"
                               class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
                               style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);"
                               placeholder="Nama kamu">
                    </div>

                    <div>
                        <label class="block text-[10px] font-mono uppercase tracking-wider t3 mb-1.5">Jenis Kelamin</label>
                        <div class="flex gap-3">
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" x-model="jenisKelamin" value="L" class="peer hidden">
                                <div class="text-center rounded-xl px-4 py-2.5 text-sm t1 transition peer-checked:text-white"
                                     :style="jenisKelamin === 'L'
                                        ? 'background: linear-gradient(135deg, #7FA98D, #3FA796); border: 1px solid transparent;'
                                        : 'background: var(--bg-glass-hover); border: 1px solid var(--border-glass);'">
                                    Laki-laki
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" x-model="jenisKelamin" value="P" class="peer hidden">
                                <div class="text-center rounded-xl px-4 py-2.5 text-sm t1 transition peer-checked:text-white"
                                     :style="jenisKelamin === 'P'
                                        ? 'background: linear-gradient(135deg, #7FA98D, #3FA796); border: 1px solid transparent;'
                                        : 'background: var(--bg-glass-hover); border: 1px solid var(--border-glass);'">
                                    Perempuan
                                </div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-mono uppercase tracking-wider t3 mb-1.5">
                            Status Akademik <span class="normal-case t3">(opsional)</span>
                        </label>
                        <input type="text" x-model="statusAkademik"
                               class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
                               style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);"
                               placeholder="mis. Pasca sidang skripsi">
                    </div>
                </div>

                {{-- ── STEP 1..N: satu gejala per langkah ── --}}
                @foreach ($gejala as $i => $g)
                    <div x-show="step === {{ $i + 1 }}"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-x-4"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-x-0"
                         x-transition:leave-end="opacity-0 -translate-x-4"
                         class="p-6 sm:p-8">

                        <span class="inline-block text-[10px] font-mono uppercase tracking-wider t3 mb-3">
                            {{ $g->kategori ?? 'Gejala' }}
                        </span>
                        <h2 class="text-base sm:text-lg font-medium t1 leading-relaxed mb-2">
                            {{ $g->nama_gejala ?? $g->nama }}
                        </h2>
                        @if ($g->deskripsi)
                            <p class="text-xs t3 mb-6 leading-relaxed">{{ $g->deskripsi }}</p>
                        @else
                            <div class="mb-6"></div>
                        @endif

                        <div class="space-y-2.5">
                            @foreach ([
                                ['value' => '1',   'label' => 'Pasti'],
                                ['value' => '0.8', 'label' => 'Hampir Pasti'],
                                ['value' => '0.6', 'label' => 'Kemungkinan Besar'],
                                ['value' => '0.4', 'label' => 'Mungkin'],
                                ['value' => '0',   'label' => 'Tidak'],
                            ] as $opt)
                                <label class="block cursor-pointer">
                                    <input type="radio"
                                           name="opt_{{ $g->id }}"
                                           value="{{ $opt['value'] }}"
                                           class="peer hidden"
                                           @click="select({{ $g->id }}, '{{ $opt['value'] }}')">
                                    <div class="flex items-center justify-between rounded-xl px-4 py-3 text-sm transition"
                                         :style="answers[{{ $g->id }}] === '{{ $opt['value'] }}'
                                            ? 'background: rgba(127,169,141,0.14); border: 1px solid #7FA98D; color: var(--text-1);'
                                            : 'background: var(--bg-glass-hover); border: 1px solid var(--border-glass); color: var(--text-1);'">
                                        <span>{{ $opt['label'] }}</span>
                                        <svg x-show="answers[{{ $g->id }}] === '{{ $opt['value'] }}'"
                                             x-transition:enter="transition ease-out duration-150"
                                             x-transition:enter-start="opacity-0 scale-50"
                                             x-transition:enter-end="opacity-100 scale-100"
                                             class="w-4 h-4 shrink-0" viewBox="0 0 24 24" fill="none"
                                             stroke="#7FA98D" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                {{-- ── STEP terakhir: ringkasan ── --}}
                <div x-show="step === totalGejala + 1"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-x-4"
                     x-transition:enter-end="opacity-100 translate-x-0"
                     class="p-6 sm:p-8 text-center flex flex-col items-center justify-center" style="min-height: 340px;">
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl mb-5" style="background: rgba(127,169,141,0.12);">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="#7FA98D" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h2 class="font-display text-xl font-semibold t1 mb-2">Semua pertanyaan terjawab</h2>
                    <p class="text-sm t2 max-w-sm leading-relaxed">
                        Kamu sudah menjawab <span x-text="totalGejala"></span> pertanyaan. Tekan tombol di bawah untuk melihat hasil konsultasimu.
                    </p>
                </div>
            </div>

            {{-- ── Navigasi ── --}}
            <div class="flex items-center justify-between gap-3 mt-6">
                <button type="button" @click="prev"
                        x-show="step > 0"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        class="inline-flex items-center gap-1.5 rounded-full px-5 py-2.5 text-sm font-medium t1 hover-surf transition"
                        style="border: 1px solid var(--border-glass);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 18l-6-6 6-6"/>
                    </svg>
                    Kembali
                </button>
                <div x-show="step === 0" class="flex-1"></div>

                <button type="button" @click="next"
                        x-show="step < totalGejala + 1"
                        :disabled="!canNext"
                        :class="canNext ? 'hover:opacity-90 active:scale-[0.99]' : 'opacity-40 cursor-not-allowed'"
                        class="flex-1 inline-flex items-center justify-center gap-2 rounded-full px-5 py-3 text-sm font-semibold text-white transition"
                        style="background: linear-gradient(135deg, #7FA98D, #3FA796); box-shadow: 0 8px 24px rgba(127,169,141,0.3);">
                    <span x-text="step === 0 ? 'Mulai Konsultasi' : 'Lanjut'"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </button>

                <button type="submit"
                        x-show="step === totalGejala + 1"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="flex-1 inline-flex items-center justify-center gap-2 rounded-full px-5 py-3.5 text-sm font-semibold text-white transition hover:opacity-90 active:scale-[0.99]"
                        style="background: linear-gradient(135deg, #7FA98D, #3FA796); box-shadow: 0 8px 24px rgba(127,169,141,0.3);">
                    Lihat Hasil Konsultasi
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </button>
            </div>

            {{-- ── Step dots (opsional, indikator kecil di bawah) ── --}}
            <div class="flex items-center justify-center gap-1.5 mt-6 flex-wrap">
                <template x-for="i in totalGejala + 2" :key="i">
                    <div class="rounded-full transition-all duration-300"
                         :class="(i - 1) === step ? 'w-5 h-1.5' : 'w-1.5 h-1.5'"
                         :style="(i - 1) <= step
                            ? 'background: #7FA98D;'
                            : 'background: var(--border-glass);'"></div>
                </template>
            </div>
        </form>
    </div>

    <script>
        function konsultasiWizard(gejalaIdsRaw) {
            return {
                gejalaIds: gejalaIdsRaw,
                totalGejala: gejalaIdsRaw.length,
                step: 0,
                nama: '{{ old('nama') }}',
                jenisKelamin: '{{ old('jenis_kelamin') }}',
                statusAkademik: '{{ old('status_akademik') }}',
                answers: {{ json_encode(old('jawaban', [])) }},

                get progressPercent() {
                    const total = this.totalGejala + 2; // data diri + N gejala + ringkasan
                    return Math.round(((this.step + 1) / total) * 100);
                },

                get canNext() {
                    if (this.step === 0) {
                        return this.nama.trim().length > 0 && (this.jenisKelamin === 'L' || this.jenisKelamin === 'P');
                    }
                    const gid = this.gejalaIds[this.step - 1];
                    return this.answers[gid] !== undefined && this.answers[gid] !== '';
                },

                select(gid, value) {
                    this.answers[gid] = value;
                    // auto-lanjut sedikit delay biar animasi pilihan kelihatan dulu
                    setTimeout(() => this.next(), 220);
                },

                next() {
                    if (!this.canNext) return;
                    if (this.step < this.totalGejala + 1) this.step++;
                },

                prev() {
                    if (this.step > 0) this.step--;
                },

                onSubmit(e) {
                    // safety check terakhir sebelum submit
                    for (const gid of this.gejalaIds) {
                        if (this.answers[gid] === undefined || this.answers[gid] === '') {
                            e.preventDefault();
                            this.step = this.gejalaIds.indexOf(gid) + 1;
                            return;
                        }
                    }
                },
            };
        }
    </script>

</x-layouts.user>