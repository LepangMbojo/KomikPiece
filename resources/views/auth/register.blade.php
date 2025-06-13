<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h2 class="mb-4 text-center text-orange-500 text-2xl font-bold">Buat Akun Baru</h2>

        <!-- Username -->
        <div class="mb-3">
            <label for="username" class="form-label text-white">Username</label>
            <div class="input-group">
                <span class="input-group-text bg-dark text-white">
                    <i class="bi bi-person"></i>
                </span>
                <input id="username" type="text" class="form-control bg-white text-black @error('username') is-invalid @enderror" 
                    name="username" value="{{ old('username') }}" required autofocus autocomplete="username" 
                    placeholder="Username unik Anda">
            </div>
            @error('username')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label text-white">Email</label>
            <div class="input-group">
                <span class="input-group-text bg-dark text-white">
                    <i class="bi bi-envelope"></i>
                </span>
                <input id="email" type="email" class="form-control bg-white text-black @error('email') is-invalid @enderror" 
                    name="email" value="{{ old('email') }}" required autocomplete="username" 
                    placeholder="email@example.com">
            </div>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label text-white">Password</label>
            <div class="input-group">
                <span class="input-group-text bg-dark text-white">
                    <i class="bi bi-lock"></i>
                </span>
                <input id="password" type="password" class="form-control bg-white text-black @error('password') is-invalid @enderror" 
                       name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
                <span class="input-group-text password-toggle bg-dark text-white" onclick="togglePassword('password', 'iconPassword')">
                    <i class="bi bi-eye" id="iconPassword" style="cursor: pointer;"></i>
                </span>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label text-white">Konfirmasi Password</label>
            <div class="input-group">
                <span class="input-group-text bg-dark text-white">
                    <i class="bi bi-lock-fill"></i>
                </span>
                <input id="password_confirmation" type="password" 
                       class="form-control bg-white text-black @error('password_confirmation') is-invalid @enderror" 
                       name="password_confirmation" required autocomplete="new-password" 
                       placeholder="Ulangi password Anda">
                <span class="input-group-text password-toggle bg-dark text-white" onclick="togglePassword('password_confirmation', 'iconPasswordConfirm')">
                    <i class="bi bi-eye" id="iconPasswordConfirm" style="cursor: pointer;"></i>
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
