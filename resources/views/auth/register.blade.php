<x-guest-layout>
    <h1 class="auth-title">Buat akun</h1>
    <p class="auth-sub">Dapatkan riwayat lengkap dan rekomendasi penanganan stres.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="field">
            <label for="name">Nama</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama lengkap">
            @error('name') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com">
            @error('email') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
            @error('password') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
            @error('password_confirmation') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-block" style="margin-top:.5rem;">Daftar</button>

        <div class="auth-footer">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
        </div>
    </form>
</x-guest-layout>