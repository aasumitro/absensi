<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
</div>

@section('custom-script')
    <script>
        // let addDeviceModal = document.getElementById('addDepartmentDeviceModal')
        // let bsAddDeviceModalModal = new bootstrap.Modal(addDeviceModal)
        // let updateDeviceDataModal = document.getElementById('editDepartmentDeviceModal')
        // let bsUpdateDeviceDataModal = new bootstrap.Modal(updateDeviceDataModal)
        // let updateDevicePasswordModal = document.getElementById('updateDevicePasswordModal')
        // let bsUpdateDevicePasswordModal = new bootstrap.Modal(updateDevicePasswordModal)
        // let deleteDeviceModal = document.getElementById('deleteModal')
        // let bsDeleteDeviceModal = new bootstrap.Modal(deleteDeviceModal)
        // let detailDeviceModal = document.getElementById('detailDepartmentDeviceModal')
        // let bsDetailDeviceActivityModal = new bootstrap.Modal(detailDeviceModal)

        window.addEventListener('openModal', event => {
            // if (event.detail.type === "DESTROY") {
            //     bsDeleteDeviceModal.show()
            // }

            // if (event.detail.type === "UPDATE") {
            //     bsUpdateDeviceDataModal.show()
            // }

            // if (event.detail.type === "UPDATE_PASSWORD") {
            //     bsUpdateDevicePasswordModal.show()
            // }

            // if (event.detail.type === "DETAIL") {
            //     console.log('test')
            //     bsDetailDeviceActivityModal.show()
            // }
        })

        window.addEventListener('closeModal', event => {
            // if (event.detail.type === "DESTROY") {
            //     bsDeleteDeviceModal.hide()
            // }

            // if (event.detail.type === "CREATE") {
            //     bsAddDeviceModalModal.hide()
            // }

            // if (event.detail.type === "UPDATE") {
            //     bsUpdateDeviceDataModal.hide()
            // }

            // if (event.detail.type === "UPDATE_PASSWORD") {
            //     bsUpdateDevicePasswordModal.hide()
            // }
        })

        window.addEventListener('showNotify', event => {
            showNotification(
                event.detail.type,
                event.detail.message
            )
        })

        // function obscureSecretText() {
        //     let passwordInput = document.getElementById("password");
        //     let passwordObscureIcon = document.getElementById("password_obscure_icon");
        //
        //     if (passwordInput.type === "password") {
        //         passwordInput.type = "text";
        //         passwordObscureIcon.classList.remove('fa-eye')
        //         passwordObscureIcon.classList.add('fa-eye-slash')
        //     } else {
        //         passwordInput.type = "password";
        //         passwordObscureIcon.classList.remove('fa-eye-slash')
        //         passwordObscureIcon.classList.add('fa-eye')
        //     }
        // }
    </script>
@endsection
