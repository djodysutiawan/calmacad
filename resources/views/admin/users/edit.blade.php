{{--
    resources/views/admin/users/edit.blade.php

    Diterima dari Admin\UserController@edit:
    - $user (User)
--}}
<x-layouts.admin title="Edit Pengguna">

    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.users.index') }}" class="t2 hover:opacity-70 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
        </a>
        <div>
            <h1 class="font-display text-2xl font-semibold t1">Edit Pengguna</h1>
            <p class="t2 mt-1 text-sm">Perbarui data <span class="font-medium">{{ $user->name }}</span>.</p>
        </div>
    </div>

    <div class="max-w-8xl rounded-2xl glass p-7 mb-6">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Foto Profil</label>
                <div class="flex items-center gap-4"
                     x-data="{ preview: {{ $user->photo ? "'" . Storage::url($user->photo) . "'" : 'null' }} }">
                    <span class="w-16 h-16 shrink-0 rounded-full overflow-hidden flex items-center justify-center font-mono text-lg font-semibold t1"
                          style="background: linear-gradient(135deg, rgba(127,169,141,0.25), rgba(139,127,209,0.25)); box-shadow: inset 0 0 0 1px var(--border-glass);">
                        <template x-if="preview">
                            <img :src="preview" class="w-full h-full object-cover">
                        </template>
                        <template x-if="!preview">
                            <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </template>
                    </span>
                    <div>
                        <label for="photo" class="inline-flex items-center rounded-full px-4 py-2 text-xs font-medium t1 hover-surf cursor-pointer transition"
                               style="border: 1px solid var(--border-glass);">
                            Ganti Foto
                        </label>
                        <input id="photo" name="photo" type="file" accept="image/png,image/jpeg,image/webp" class="hidden"
                               @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : preview">
                        <p class="text-xs t3 mt-1.5">JPG, PNG, atau WEBP. Maks 2MB.</p>
                    </div>
                </div>
                @error('photo')
                    <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="name" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Nama</label>
                <input id="name" name="name" type="text" required autofocus
                       value="{{ old('name', $user->name) }}"
                       class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
                       style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
                @error('name')
                    <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Email</label>
                <input id="email" name="email" type="email" required
                       value="{{ old('email', $user->email) }}"
                       class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
                       style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
                @error('email')
                    <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="role" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Role</label>
                <select id="role" name="role" required
                        {{ $user->id === auth()->id() ? 'disabled' : '' }}
                        class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
                        style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass); color-scheme: light dark;">
                    <option value="user" style="background: var(--option-bg); color: var(--option-text);" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" style="background: var(--option-bg); color: var(--option-text);" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @if ($user->id === auth()->id())
                    {{-- Karena diisi `disabled`, browser tidak mengirim field ini sama sekali, jadi perlu hidden input agar tetap terkirim --}}
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <p class="text-xs t3 mt-1.5">Tidak bisa mengubah role akun sendiri.</p>
                @endif
                @error('role')
                    <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center rounded-full px-5 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
                        style="background: linear-gradient(135deg, #7FA98D, #3FA796); box-shadow: 0 4px 16px rgba(127,169,141,0.35);">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.users.index') }}" class="text-sm t2 hover:opacity-80 transition">Batal</a>
            </div>
        </form>
    </div>

    {{-- Reset Password --}}
    <div class="max-w-xl rounded-2xl glass p-7"
         x-data="{ open: false }">
        <button type="button" @click="open = !open" class="flex items-center justify-between w-full text-left">
            <div>
                <h2 class="font-display text-base font-semibold t1">Reset Password</h2>
                <p class="text-xs t3 mt-0.5">Atur ulang password pengguna ini secara manual.</p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 t3 transition-transform" :class="open ? 'rotate-180' : ''"
                 viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m6 9 6 6 6-6"/>
            </svg>
        </button>

        <form method="POST" action="{{ route('admin.users.reset-password', $user) }}"
              x-show="open" x-transition class="space-y-4 mt-5 pt-5 border-t hairline"
              onsubmit="return confirm('Reset password untuk &quot;{{ $user->name }}&quot;? Pengguna harus login ulang dengan password baru.');">
            @csrf
            @method('PUT')

            <div>
                <label for="reset-password" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Password Baru</label>
                <input id="reset-password" name="password" type="password" required minlength="8"
                       class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
                       style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
                @error('password', 'resetPassword')
                    <p class="text-xs mt-1.5" style="color: #E8775A;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="reset-password-confirmation" class="block text-xs font-mono uppercase tracking-wide t3 mb-1.5">Konfirmasi Password Baru</label>
                <input id="reset-password-confirmation" name="password_confirmation" type="password" required minlength="8"
                       class="w-full rounded-xl px-4 py-2.5 text-sm t1 outline-none transition focus:ring-2"
                       style="background: var(--bg-glass-hover); border: 1px solid var(--border-glass);">
            </div>

            <button type="submit"
                    class="inline-flex items-center rounded-full px-5 py-2.5 text-sm font-medium text-white transition hover:opacity-90"
                    style="background: linear-gradient(135deg, #E8775A, #c45f47); box-shadow: 0 4px 16px rgba(232,119,90,0.3);">
                Reset Password
            </button>
        </form>
    </div>

</x-layouts.admin>