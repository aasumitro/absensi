<div
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="logoutModal"
>
    <div
        class="modal-dialog modal-sm"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Are you sure to remove this account?</h5>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-dark"
                    data-bs-dismiss="modal"
                >
                    Cancel
                </button>
                <a  href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                    class="btn btn-danger"
                >
                    Remove!
                </a>
            </div>
        </div>
    </div>
</div>
