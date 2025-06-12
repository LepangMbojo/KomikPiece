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
                                class="form-control bg-dark text-white border-secondary" {{-- Sesuaikan warna input --}}
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