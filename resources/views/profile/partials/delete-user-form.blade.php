<section>
    <header class="mb-4">
        <h3 class="h5 fw-bold text-danger">
            {{ __('app.delete_account') }}
        </h3>
        <p class="text-muted small">
            {{ __('app.delete_account_warning') }}
        </p>
    </header>

    <button type="button" class="btn btn-danger py-2 px-3 rounded-3 fw-semibold small" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        {{ __('app.delete_account') }}
    </button>

    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-3">
                <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
                    @csrf
                    @method('delete')

                    <h5 class="fw-bold text-dark mb-2" id="confirmUserDeletionModalLabel">
                        {{ __('app.confirm_delete_account_title') }}
                    </h5>

                    <p class="text-muted small mb-4">
                        {{ __('app.confirm_delete_account_desc') }}
                    </p>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold small text-secondary visually-hidden">{{ __('app.password') }}</label>
                        <input id="password"
                               type="password"
                               name="password"
                               class="form-control py-2 rounded-3 @error('password', 'userDeletion') is-invalid @enderror"
                               placeholder="{{ __('app.password') }}"
                               required />

                        @error('password', 'userDeletion')
                            <div class="invalid-feedback small fw-medium mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-light py-2 px-3 rounded-3 fw-semibold small border" data-bs-dismiss="modal">
                            {{ __('app.cancel') }}
                        </button>

                        <button type="submit" class="btn btn-danger py-2 px-3 rounded-3 fw-semibold small">
                            {{ __('app.delete_account') }}
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