@extends('layouts.main')

@section('title', "Qrcode Scanner")

@section('content')
    <section>
        <div class="d-flex justify-content-between w-100 flex-wrap py-4 px-3">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Qr Code >> Scanner</h1>
                <p class="mb-0">
                    Scan qrcode yang dibuat melalui aplikasi pada ponsel anda!
                </p>
            </div>

            <div class="btn-toolbar mb-2 mb-md-0">
                <button
                    data-bs-toggle="modal"
                    onclick="window.location.reload()"
                    type="button"
                    class="btn btn-dark h-75"
                >Refresh</button>
            </div>
        </div>

        <div class="row col-12 p-3">
            <div class="card">
                <div class="card-body text-center">
                    <img
                        src="{{ asset('assets/img/oksetda-absensi-logo.png') }}"
                        alt="logo-with-title"
                        class="img-fluid align-content-center mb-3 mt-3"
                        height="150"
                        width="150"
                    >
                    <p>
                        <span class="h4 font-weight-bold"> Electronic Attendance </span> <br>
                        <span class="font-italic" id="currentDatetime"> - </span>
                    </p>
                    <div
                        id="qrcodeReader"
                        class="mb-3"
                        style="width: 350px;  margin: 0 auto;"
                    ></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Audio -->
    <audio id="audioAttendSuccess" src="{{asset('assets/sounds/presensi-berhasil-sound.mp3')}}"></audio>
    <audio id="audioAttendFailed" src="{{asset('assets/sounds/presensi-gagal-sound.mp3')}}"></audio>
@endsection

@section('custom-script')
    <script src="{{ asset('assets/js/qrcode-scanner.js') }}"></script>
    <script src="{{ asset('assets/js/axios.min.js') }}"></script>

    <script>
        const locale = `Asia/Makassar`

        const SUCCESS_UNPROCESSED = 'Anda sudah melakukan absensi datang dan pulang';

        window.onload = () => {
            setInterval(initCurrentDatetime, 1000)
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "qrcodeReader", { fps: 10, qrbox: 200 }
        );

        function onScanSuccess(decodedText, decodedResult) {
            // contoh data dalam bentuk JSON
            // {
            //      "device_uuid":"97606230-6030-4b1b-bfe7-1752c9e75903",
            //      "user_uuid":"60c5ec77-1a73-4b0f-b247-dc61994dbf63",
            //      "attend_token":"secret"
            // }
            let dataObj = JSON.parse(decodedText)

            makeAttendanceFromQrcodeReader(dataObj.user_uuid, dataObj.attend_token)
        }

        html5QrcodeScanner.render(onScanSuccess);

        function makeAttendanceFromQrcodeReader(user_uuid, attend_token) {
            let device_uuid = `{{$device_unique_id}}`

            let bodyFormData = new FormData();
            bodyFormData.append('device_uuid', device_uuid);
            bodyFormData.append('user_uuid', user_uuid);
            bodyFormData.append('attend_token', attend_token);

            axios({
                method: 'POST',
                url: `{{ route('api.web.scan') }}`,
                data: bodyFormData,
                headers: {'Content-Type': 'multipart/form-data'}
            }).then((response) => {
                if (response.data === SUCCESS_UNPROCESSED) {
                    document.getElementById('audioAttendFailed').play();
                } else {
                    document.getElementById('audioAttendSuccess').play();
                }

                setTimeout(function(){
                    alert(response.data)
                    // TODO replace reload page with refresh qr-scanner
                    window.location.reload()
                }, 1500);
            }).catch((error) => {
                document.getElementById('audioAttendFailed').play();

                setTimeout(function(){
                    alert(error.data)
                    // TODO replace reload page with refresh qr-scanner
                    window.location.reload()
                }, 1500);
            })
        }

        function initCurrentDatetime() {
            let currentDatetimeView = document
                .getElementById('currentDatetime')

            const today = new Date()

            const date = today.toLocaleDateString('id-ID', {
                year: "numeric",
                month: "long",
                day: "2-digit",
                timeZone: locale
            })

            const time = today.toLocaleTimeString('en-US', {
                formatMatcher: 'best fit',
                hour12: false,
                timeZone: locale
            })

            currentDatetimeView.innerHTML = [date, time].join(' - ')
        }
    </script>
@endsection
