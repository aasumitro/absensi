<div class="mb-4 text-center">
    <label for="one-time-password">
        Masukkan kode verifikasi
        <span class="d-block fw-light">
            Kode verifikasi telah dikirim,
            silahakn periksa pada Telegram messenger atau Alamat Email Anda
        </span>
    </label>
    <input
        id="one-time-password"
        class="one-time-password  @error('password') is-invalid @enderror"
        maxlength='7'
        wire:model="password"
    />

    @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="d-flex justify-content-center align-items-center mb-4">
    <span class="fw-normal d-none" id="resend-button">
        Tidak menerima kode verifikasi?
        <a
            wire:click="resend"
            class="fw-bold"
        >Kirim lagi!</a>
    </span>
    <span
        class="fw-bold d-inline"
        id="counting-before-retry"
    >-</span>
</div>

<script>
    window.addEventListener('recountingTime', event => {
        console.log("called")
        if (event.detail.next_time >= 1) {
            console.log("called12")
            countingTime(event.detail.next_time)
        }
    })

    function countingTime(time) {
        console.log('calledss')
        let countingSection = document
            .getElementById('counting-before-retry')
        let trySendOTPButton = document
            .getElementById('resend-button')

        countingSection.classList.remove("d-none")
        trySendOTPButton.classList.add("d-none")

        let resendRemainingTime = parseInt(time) * 60 * 1000

        let counting = setInterval(() => {
            resendRemainingTime -= 1000

            let seconds = Math.floor((resendRemainingTime / 1000) % 60)
            let minutes = Math.floor((resendRemainingTime / (1000 * 60)) % 60)
            seconds = (seconds < 10) ? "0" + seconds : seconds
            minutes = (minutes < 10) ? "0" + minutes : minutes

            countingSection.innerHTML = `Resend in : ${minutes}:${seconds}`

            if (minutes === "00" && seconds === '00') {
                clearInterval(counting)
                countingSection.classList.add("d-none")
                trySendOTPButton.classList.remove("d-none")
            }
        }, 1000)
    }
</script>
