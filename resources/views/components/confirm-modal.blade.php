<div class="modal fade" id="confirmActionModal" tabindex="-1" aria-labelledby="confirmActionModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content admin-confirm-modal">
            <div class="modal-header border-0 pb-0">
                <div>
                    <span class="admin-page-eyebrow text-danger">Konfirmasi</span>
                    <h5 class="modal-title fw-bold text-dark mt-1" id="confirmActionModalTitle">Lanjutkan aksi?</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup konfirmasi"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-0" id="confirmActionModalMessage">
                    Aksi ini membutuhkan konfirmasi sebelum dilanjutkan.
                </p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger rounded-pill px-4" id="confirmActionModalSubmit">
                    Lanjutkan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEl = document.getElementById('confirmActionModal');
        const titleEl = document.getElementById('confirmActionModalTitle');
        const messageEl = document.getElementById('confirmActionModalMessage');
        const submitButton = document.getElementById('confirmActionModalSubmit');
        let pendingForm = null;

        if (!modalEl || !submitButton || !window.bootstrap) {
            return;
        }

        const modal = new bootstrap.Modal(modalEl);

        document.addEventListener('submit', function (event) {
            const form = event.target;

            if (!form.matches('[data-confirm]') || form.dataset.confirmed === 'true') {
                return;
            }

            if (!form.checkValidity()) {
                return;
            }

            event.preventDefault();
            pendingForm = form;

            titleEl.textContent = form.dataset.confirmTitle || 'Lanjutkan aksi?';
            messageEl.textContent = form.dataset.confirmMessage || 'Aksi ini membutuhkan konfirmasi sebelum dilanjutkan.';
            submitButton.textContent = form.dataset.confirmLabel || 'Lanjutkan';
            submitButton.className = 'btn rounded-pill px-4 ' + (form.dataset.confirmButton || 'btn-danger');

            modal.show();
        });

        submitButton.addEventListener('click', function () {
            if (!pendingForm) {
                return;
            }

            pendingForm.dataset.confirmed = 'true';
            pendingForm.submit();
        });

        modalEl.addEventListener('hidden.bs.modal', function () {
            if (pendingForm) {
                delete pendingForm.dataset.confirmed;
            }
            pendingForm = null;
        });
    });
</script>
