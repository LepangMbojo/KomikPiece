<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h2 class="mb-4 text-center" style="color: var(--primary-color); font-size: 1.8rem; font-weight: bold;">
            Login
        </h2>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="form-control @error('email') is-invalid @enderror" 
                   placeholder="email@example.com">
            
            {{-- Mengganti <x-input-error> dengan directive @error standar --}}
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="form-control @error('password') is-invalid @enderror" 
                   placeholder="Password">

            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-check mb-4">
            <input id="show_password" type="checkbox" onclick="togglePasswordCheckbox('password')"
                   class="form-check-input">
            <label for="show_password" class="form-check-label ms-2 small">
                Show Password
            </label>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            @if (Route::has('password.request'))
                <a class="small" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif

            <button type="submit" class="btn btn-primary">
                Login
            </button>
        </div>
    </form>

<<<<<<< HEAD
    <script>
        function togglePasswordCheckbox(fieldId) {
            const field = document.getElementById(fieldId);
            if (field.type === "password") {
=======
    <!-- Script toggle password -->
    <script>
        function togglePasswordCheckbox(fieldId) {
            const field = document.getElementById(fieldId);
            const checkbox = document.getElementById('show_password');

            if (checkbox.checked) {
>>>>>>> ec888fdcf14b9edaa8c43bfa203dcb335d8fed73
                field.type = "text";
            } else {
                field.type = "password";
            }
        }
    </script>
<<<<<<< HEAD
</x-guest-layout>
=======
</x-guest-layout>
>>>>>>> ec888fdcf14b9edaa8c43bfa203dcb335d8fed73
