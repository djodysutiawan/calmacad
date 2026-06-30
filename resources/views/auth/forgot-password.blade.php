<x-guest-layout>
    <h1 class="auth-title">Lupa password?</h1>
    <p class="auth-sub">Masukkan emailmu, kami akan kirim tautan reset password.</p>

    @if (session('status'))
        <div class="auth-status">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="field">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
            @error('email') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-block">Kirim tautan reset</button>

        <div class="auth-footer">
            <a href="{{ route('login') }}">Kembali ke halaman masuk</a>
        </div>
    </form>
</x-guest-layout>