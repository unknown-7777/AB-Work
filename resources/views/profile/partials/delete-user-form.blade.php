<section>
    <header class="mb-4">
        <h3 class="h5 fw-bold text-danger">
            {{ __('Delete Account') }}
        </h3>
        <p class="text-muted small">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button type="button" class="btn btn-danger py-2 px-3 rounded-3 fw-semibold small" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        {{ __('Delete Account') }}
    </button>

    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-3">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
                    @csrf
                    @method('delete')

                    <h5 class="fw-bold text-dark mb-2" id="confirmUserDeletionModalLabel">
                        {{ __('Are you sure you want to delete your account?') }}
                    </h5>

                    <p class="text-muted small mb-4">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold small text-secondary visually-hidden">Password</label>
                        <input id="password"
                               type="password"
                               name="password"
                               class="form-control py-2 rounded-3 @error('password', 'userDeletion') is-invalid @enderror"
                               placeholder="{{ __('Password') }}"
                               required />

                        @error('password', 'userDeletion')
                            <div class="invalid-feedback small fw-medium mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light py-2 px-3 rounded-3 fw-semibold small border" data-bs-dismiss="modal">
                            {{ __('Cancel') }}
                        </button>

                        <button type="submit" class="btn btn-danger py-2 px-3 rounded-3 fw-semibold small">
                            {{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@if($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var deleteModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
        deleteModal.show();
    });
</script>
@endif