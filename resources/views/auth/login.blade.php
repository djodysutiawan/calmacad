<x-guest-layout>
    <h1 class="auth-title">Selamat datang kembali</h1>
    <p class="auth-sub">Masuk untuk melihat riwayat dan rekomendasi stresmu.</p>

    @if (session('status'))
        <div class="auth-status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com">
            @error('email') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            @error('password') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <label class="check-row" for="remember_me">
            <input id="remember_me" type="checkbox" name="remember">
            <span>Ingat saya</span>
        </label>

        <button type="submit" class="btn btn-primary btn-block">Masuk</button>

        <div class="auth-footer">
            @if (Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">Lupa password?</a>
            @endif
            <p style="margin-top:.75rem;">
                Belum punya akun? <a href="{{ route('register') }}">Daftar gratis</a>
            </p>
        </div>
    </form>
</x-guest-layout>