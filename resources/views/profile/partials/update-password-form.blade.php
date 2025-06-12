<section class="card shadow-sm p-4 mb-4" style="background-color: #212529; color: #f8f9fa;">
    <header class="mb-4">
        <h2 class="h5 mb-2 text-info">
            {{ __('Update Password') }}
        </h2>

        <p class="text-sm text-white-50">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label text-white">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control bg-dark text-white border-secondary" autocomplete="current-password" />
            @error('current_password', 'updatePassword')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label text-white">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="form-control bg-dark text-white border-secondary" autocomplete="new-password" />
            @error('password', 'updatePassword')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="update_password_password_confirmation" class="form-label text-white">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control bg-dark text-white border-secondary" autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-3">
            {{-- Mengganti x-primary-button dengan btn btn-primary Bootstrap --}}
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-2"></i>{{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-success small" {{-- Menggunakan text-success untuk pesan sukses --}}
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>