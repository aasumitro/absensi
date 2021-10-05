<div
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="recommendedBrowserModal"
>
    <div
        class="modal-dialog modal-md"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rekomendasi Browser</h5>
            </div>
            <div class="modal-body">
                Diharapkan ketika Anda menggunakan Sistem ini,
                Browser (pramban) Anda adalah versi update tebaru, dan disarankan
                menggunakan sesuai dengan daftar yang ada dibawah ini : <br>
                1. <a href="https://www.google.com/intl/id_id/chrome/" class="text-info text-underline" target="_blank">Google Chrome</a> <br>
                2. <a href="https://brave.com/download/" class="text-info text-underline" target="_blank">Brave</a> <br> <br>
                Hal ini bertujuan untuk meminimalisir Bug pada front-end <br>
                Atas perhatiannya diucapkan terimakasih, <br>
                Salam.
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    data-bs-dismiss="modal"
                    onclick="localStorage.setItem('recommended_browser_display', 'NONE')"
                    class="btn btn-secondary"
                >
                    OK, Jangan tampilkan lagi
                </button>
                <button
                    type="button"
                    data-bs-dismiss="modal"
                    onclick="localStorage.setItem('recommended_browser_display', 'DISPLAY')"
                    class="btn btn-primary ms-auto"
                >
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
