<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h2 class="mb-4 text-center">Buat Akun Baru</h2>

        <!-- Username -->
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-person"></i>
                </span>
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" 
                       name="username" value="{{ old('username') }}" required autofocus autocomplete="username" 
                       placeholder="Username unik Anda">
            </div>
            @error('username')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-envelope"></i>
                </span>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                       name="email" value="{{ old('email') }}" required autocomplete="username" 
                       placeholder="email@example.com">
            </div>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-lock"></i>
                </span>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                       name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                <span class="input-group-text password-toggle" onclick="togglePassword('password', 'iconPassword')">
                    <i class="bi bi-eye" id="iconPassword"></i>
                </span>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-lock-fill"></i>
                </span>
                <input id="password_confirmation" type="password" 
                       class="form-control @error('password_confirmation') is-invalid @enderror" 
                       name="password_confirmation" required autocomplete="new-password" 
                       placeholder="Ulangi password Anda">
                <span class="input-group-text password-toggle" onclick="togglePassword('password_confirmation', 'iconPasswordConfirm')">
                    <i class="bi bi-eye" id="iconPasswordConfirm"></i>
                </span>
            </div>
            @error('password_confirmation')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('login') }}" class="text-light small">
                Sudah punya akun?
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-person-plus me-1"></i> Daftar
            </button>
        </div>
    </form>

    <!-- Script toggle password -->
    <script>
        function togglePassword(fieldId, iconId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);
            if (field.type === "password") {
                field.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                field.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        }
    </script>
</x-guest-layout>