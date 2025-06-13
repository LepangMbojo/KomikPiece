<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0 text-white">{{ __('Profile') }}</h2>
        </div>
    </x-slot>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                @if (session('status') === 'profile-updated')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ __('Your profile has been updated.') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif (session('status') === 'password-updated')
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ __('Your password has been updated.') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif (session('status') === 'verification-link-sent')
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle me-2"></i>{{ __('A new verification link has been sent to your email address.') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->userDeletion->isNotEmpty() || $errors->updatePassword->isNotEmpty() || $errors->hasAny(['username', 'email']))
                    <div class="alert alert-danger">
                        <h6><i class="bi bi-exclamation-triangle me-2"></i>Terjadi Kesalahan:</h6>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

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
                                    <p class="text-sm text-warning">
                                        {{ __('Your email address is unverified.') }}

                                        <button form="send-verification" class="btn btn-link text-warning p-0 text-decoration-underline align-baseline">
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
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>{{ __('Save') }}
                            </button>
                        </div>
                    </form>
                </section>

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
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>{{ __('Save') }}
                            </button>
                        </div>
                    </form>
                </section>

                <section class="card shadow-sm p-4 mb-4" style="background-color: #212529; color: #f8f9fa;">
                    <header class="mb-4">
                        <h2 class="h5 mb-2 text-danger">
                            {{ __('Delete Account') }}
                        </h2>

                        <p class="text-sm text-white-50">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                        </p>
                    </header>

                    <button type="button" class="btn btn-danger"
                        data-bs-toggle="modal"
                        data-bs-target="#confirmUserDeletionModal">
                        <i class="bi bi-trash me-2"></i>{{ __('Delete Account') }}
                    </button>

                    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="background-color: #343a40; color: #f8f9fa;">
                                <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
                                    @csrf
                                    @method('delete')

                                    <div class="modal-header border-bottom-0">
                                        <h5 class="modal-title h5" id="confirmUserDeletionModalLabel">
                                            {{ __('Are you sure you want to delete your account?') }}
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <p class="text-sm text-white-50">
                                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                        </p>

                                        <div class="mt-3">
                                            <label for="password_delete" class="form-label visually-hidden">{{ __('Password') }}</label>
                                            <input
                                                id="password_delete"
                                                name="password"
                                                type="password"
                                                class="form-control bg-dark text-white border-secondary"
                                                placeholder="{{ __('Password') }}"
                                            />
                                            @error('password', 'userDeletion')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="modal-footer border-top-0 d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="bi bi-x-lg me-1"></i>{{ __('Cancel') }}
                                        </button>

                                        <button type="submit" class="btn btn-danger ms-2">
                                            <i class="bi bi-trash me-1"></i>{{ __('Delete Account') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
</x-app-layout>