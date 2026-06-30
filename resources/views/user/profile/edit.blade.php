{{--
    resources/views/user/profile/edit.blade.php

    Diterima dari User\ProfileController@edit:
    - auth()->user() — digunakan langsung untuk mengisi nilai form
    Submit ke:
    - User\ProfileController@update         (route: user.profile.update)
    - User\ProfileController@updatePassword (route: user.profile.password)
--}}
<x-layouts.user title="Profil Saya">

    <div class="max-w-3xl mx-auto" x-data="{ tab: 'profile', photoPreview: null }">

        <h1 class="font-display text-3xl font-semibold t1 mb-1">Profil Saya</h1>
        <p class="t2 text-sm mb-7">Kelola informasi akun dan keamanan password kamu.</p>

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="rounded-xl mb-6 px-4 py-3 text-sm flex items-center gap-2"
                 style="background: rgba(127,169,141,0.12); border: 1px solid rgba(127,169,141,0.3); color: #7FA98D;">
                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Tabs --}}
        <div class="flex gap-1 mb-6 p-1 rounded-full glass w-fit">
            <button type="button"
                    @click="tab = 'profile'"
                    class="inline-flex items-center gap-2 px-5 py-2 text-sm rounded-full font-medium transition"
                    :style="tab === 'profile'
                        ? 'background: linear-gradient(135deg, #7FA98D, #3FA796); color: white; box-shadow: 0 2px 10px rgba(127,169,141,0.35);'
                        : 'color: var(--t2, inherit);'">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                </svg>
                Profil
            </button>
            <button type="button"
                    @click="tab = 'password'"
                    class="inline-flex items-center gap-2 px-5 py-2 text-sm rounded-full font-medium transition"
                    :style="tab === 'password'
                        ? 'background: linear-gradient(135deg, #7FA98D, #3FA796); color: white; box-shadow: 0 2px 10px rgba(127,169,141,0.35);'
                        : 'color: var(--t2, inherit);'">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
                Password
            </button>
        </div>

        {{-- ===================== TAB: PROFIL ===================== --}}
        <div x-show="tab === 'profile'" x-cloak class="rounded-2xl glass p-8 md:p-10">
            <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data" class="space-y-7">
                @csrf
                @method('PUT')

                {{-- Foto profil --}}
                <div class="flex items-center gap-5 pb-7" style="border-bottom: 1px solid var(--border-glass);">
                    <div class="relative shrink-0">
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="w-20 h-20 rounded-full object-cover" style="border: 2px solid var(--border-glass);">
                        </template>
                        <template x-if="!photoPreview">
                            @if (auth()->user()->photo ?? null)
                                <img src="{{ Storage::url(auth()->user()->photo) }}" class="w-20 h-20 rounded-full object-cover" style="border: 2px solid var(--border-glass);">
                            @else
                                <div class="w-20 h-20 rounded-full flex items-center justify-center text-2xl font-semibold text-white"
                                     style="background: linear-gradient(135deg, #7FA98D, #3FA796);">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </template>
                    </div>

                    <div class="flex-1">
                        <p class="text-sm font-medium t1 mb-2">{{ auth()->user()->name }}</p>
                        <label class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-xs font-medium cursor-pointer transition hover:opacity-80"
                               style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass); color: var(--t1, inherit);">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 7.5L12 3m0 0L7.5 7.5M12 3v13.5" />
                            </svg>
                            Ganti Foto
                            <input type="file" name="photo" accept="image/*" class="hidden"
                                   @change="photoPreview = $event.target.files.length ? URL.createObjectURL($event.target.files[0]) : null">
                        </label>
                        <p class="text-xs t3 mt-2">PNG/JPG, maksimal 2MB.</p>
                        @error('photo')
                            <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label for="name" class="block text-xs font-mono uppercase tracking-wide t3 mb-2">Nama</label>
                        <input id="name" name="name" type="text" required autofocus maxlength="100"
                               value="{{ old('name', auth()->user()->name) }}"
                               class="profile-input w-full rounded-xl px-4 py-3 text-sm t1 outline-none transition">
                        @error('name')
                            <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="email" class="block text-xs font-mono uppercase tracking-wide t3 mb-2">Email</label>
                        <input id="email" name="email" type="email" required maxlength="150"
                               value="{{ old('email', auth()->user()->email) }}"
                               class="profile-input w-full rounded-xl px-4 py-3 text-sm t1 outline-none transition">
                        @error('email')
                            <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center gap-4 pt-3" style="border-top: 1px solid var(--border-glass);">
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-full px-6 py-3 text-sm font-medium text-white transition hover:opacity-90 hover:-translate-y-0.5"
                            style="background: linear-gradient(135deg, #7FA98D, #3FA796); box-shadow: 0 4px 16px rgba(127,169,141,0.35);">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('user.dashboard') }}" class="text-sm t2 hover:opacity-80 transition">Batal</a>
                </div>
            </form>
        </div>

        {{-- ===================== TAB: PASSWORD ===================== --}}
        <div x-show="tab === 'password'" x-cloak
             x-data="{
                showCurrent: false,
                showNew: false,
                showConfirm: false,
                pwd: '',
                get strength() {
                    let s = 0;
                    if (this.pwd.length >= 8) s++;
                    if (/[A-Z]/.test(this.pwd)) s++;
                    if (/[0-9]/.test(this.pwd)) s++;
                    if (/[^A-Za-z0-9]/.test(this.pwd)) s++;
                    return s;
                },
                get strengthLabel() {
                    return ['Lemah', 'Lemah', 'Cukup', 'Baik', 'Kuat'][this.strength];
                },
                get strengthColor() {
                    return ['#E8775A', '#E8775A', '#E0B341', '#7FA98D', '#3FA796'][this.strength];
                }
             }"
             class="rounded-2xl glass p-8 md:p-10">

            <div class="grid md:grid-cols-5 gap-10">

                {{-- Form --}}
                <form method="POST" action="{{ route('user.profile.password') }}" class="md:col-span-3 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="current_password" class="block text-xs font-mono uppercase tracking-wide t3 mb-2">Password Saat Ini</label>
                        <div class="relative">
                            <input :type="showCurrent ? 'text' : 'password'" id="current_password" name="current_password" required
                                   class="profile-input w-full rounded-xl px-4 py-3 pr-11 text-sm t1 outline-none transition">
                            <button type="button" @click="showCurrent = !showCurrent"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 t3 hover:opacity-70">
                                <svg x-show="!showCurrent" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <svg x-show="showCurrent" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-mono uppercase tracking-wide t3 mb-2">Password Baru</label>
                        <div class="relative">
                            <input :type="showNew ? 'text' : 'password'" id="password" name="password" required minlength="8"
                                   x-model="pwd"
                                   class="profile-input w-full rounded-xl px-4 py-3 pr-11 text-sm t1 outline-none transition">
                            <button type="button" @click="showNew = !showNew"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 t3 hover:opacity-70">
                                <svg x-show="!showNew" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <svg x-show="showNew" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                            </button>
                        </div>

                        {{-- Strength meter --}}
                        <div x-show="pwd.length > 0" x-cloak class="mt-2.5">
                            <div class="flex gap-1 mb-1.5">
                                <template x-for="i in 4" :key="i">
                                    <div class="h-1 flex-1 rounded-full transition-colors"
                                         :style="i <= strength ? `background:${strengthColor}` : 'background: var(--bg-glass-hover)'"></div>
                                </template>
                            </div>
                            <p class="text-xs" x-text="strengthLabel" :style="`color:${strengthColor}`"></p>
                        </div>

                        @error('password')
                            <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-mono uppercase tracking-wide t3 mb-2">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input :type="showConfirm ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required
                                   class="profile-input w-full rounded-xl px-4 py-3 pr-11 text-sm t1 outline-none transition">
                            <button type="button" @click="showConfirm = !showConfirm"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 t3 hover:opacity-70">
                                <svg x-show="!showConfirm" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <svg x-show="showConfirm" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="inline-flex items-center gap-2 rounded-full px-6 py-3 text-sm font-medium text-white transition hover:opacity-90 hover:-translate-y-0.5"
                                style="background: linear-gradient(135deg, #7FA98D, #3FA796); box-shadow: 0 4px 16px rgba(127,169,141,0.35);">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            Ubah Password
                        </button>
                    </div>
                </form>

                {{-- Panel tips keamanan --}}
                <div class="md:col-span-2 rounded-xl p-5 h-fit"
                     style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-4 h-4" style="color: #7FA98D;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                        <p class="text-sm font-medium t1">Tips Keamanan</p>
                    </div>
                    <ul class="space-y-2.5 text-xs t3">
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-1 h-1 rounded-full shrink-0" style="background: #7FA98D;"></span>
                            Gunakan minimal 8 karakter, kombinasi huruf besar, kecil, dan angka.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-1 h-1 rounded-full shrink-0" style="background: #7FA98D;"></span>
                            Hindari password yang sama dengan akun lain.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-1 h-1 rounded-full shrink-0" style="background: #7FA98D;"></span>
                            Jangan bagikan password kamu kepada siapa pun, termasuk tim CalmAcad.
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 w-1 h-1 rounded-full shrink-0" style="background: #7FA98D;"></span>
                            Ganti password secara berkala untuk keamanan ekstra.
                        </li>
                    </ul>
                </div>

            </div>
        </div>

    </div>

    <style>
        .profile-input {
            background: var(--bg-glass-hover);
            border: 1px solid var(--border-glass);
        }
        .profile-input:focus {
            border-color: #7FA98D;
            box-shadow: 0 0 0 3px rgba(127, 169, 141, 0.18);
        }
    </style>

</x-layouts.user>