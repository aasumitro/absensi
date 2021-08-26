<div
    wire:ignore.self
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="addUserModal"
>
    <div
        class="modal-dialog modal-md"
        role="document"
        tabindex="-1"
    >
        <form wire:submit.prevent="submit">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add new Member</h5>
                </div>
                <div class="modal-body">
                    @include('components.input.username-input')
                    @include('components.input.email-input')
                    @include('components.input.phone-input')
                    @include('components.input.name-input')
                    @include('components.input.role-select')
                    @include('components.input.department-select')
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-dark"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="btn btn-danger"
                    >
                        Create
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
