<section class="card shadow-sm p-4 mb-4" style="background-color: #212529; color: #f8f9fa;">
    <header class="mb-4">
        <h2 class="h5 mb-2 text-primary">
            {{ __('Profile Information') }}
        </h2>

        <p class="text-sm text-white-50">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="username" class="form-label text-white">{{ __('Username') }}</label>
            <input id="username" name="username" type="text" class="form-control bg-dark text-white border-secondary" value="{{ old('username', $user->username) }}" required autofocus autocomplete="username" />
            @error('username')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="form-label text-white">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control bg-dark text-white border-secondary" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="text-sm text-warning"> {{-- Menggunakan text-warning untuk pesan verifikasi --}}
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="btn btn-link text-warning p-0 text-decoration-underline align-baseline"> {{-- Menggunakan btn-link Bootstrap --}}
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            {{-- Mengganti x-primary-button dengan btn btn-primary Bootstrap --}}
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-2"></i>{{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
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