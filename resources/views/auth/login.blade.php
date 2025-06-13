<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h2 class="mb-4 text-center text-orange-500 text-2xl font-bold">Login</h2>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label text-white">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                 class="w-full bg-white text-black rounded-2xl shadow p-2 @error('email') is-invalid @enderror" placeholder="email@example.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label text-white">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                 class="w-full bg-white text-black rounded-2xl shadow p-2 @error('password') is-invalid @enderror" placeholder="Password">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
        </div>

        <!-- Show Password -->
        <div class="mb-4">
            <label for="show_password" class="inline-flex items-center">
                <input id="show_password" type="checkbox" onclick="togglePasswordCheckbox('password')"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                <span class="ms-2 text-sm text-gray-300">Show Password</span>
            </label>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between align-items-center">
            @if (Route::has('password.request'))
                <a class="text-light small" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif

            <button type="submit" class="btn btn-primary">
                Login
            </button>
        </div>
    </form>

    <!-- Script toggle password -->
    <script>
        function togglePasswordCheckbox(fieldId) {
            const field = document.getElementById(fieldId);
            const checkbox = document.getElementById('show_password');

            if (checkbox.checked) {
                field.type = "text";
            } else {
                field.type = "password";
            }
        }
    </script>
</x-guest-layout>
