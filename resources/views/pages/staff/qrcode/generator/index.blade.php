@extends('layouts.main')

@section('title', "Qrcode Generator")

@section('content')
    <section>
        <div class="d-flex justify-content-between w-100 flex-wrap py-4 px-3">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Qr Code >> Generator</h1>
                <p class="mb-0">
                    Pindai qrcode ini melalui ponsel anda!
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
                <div class="card-header">
                    <div class="col-md-6">
                        <p class="h5" id="currentDevice"></p>
                    </div>
                </div>

                <div class="card-body text-center">
                    <img
                        src="{{ asset('assets/img/oksetda-absensi-logo.png') }}"
                        alt="logo-with-title"
                        class="img-fluid align-content-center mb-2"
                        height="150"
                        width="150"
                    >
                    <p>
                        <span class="h4 font-weight-bold"> Electronic Attendance </span> <br>
                        <span class="font-italic" id="currentDatetime"> - </span>
                    </p>
                    <div id="qrcode"></div>
                    <p class="font-weight-bold" id="qrcodeRefreshTime">-</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom-script')
    <script src="{{ asset('assets/js/qrcode-generator.js') }}"></script>
    <script src="{{ asset('assets/js/axios.min.js') }}"></script>

    <script>
        const locale = `Asia/Makassar`

        let qrcode = new QRCode(document.getElementById("qrcode"), {
            width: 230,
            height: 230,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        })

        window.onload = () => {
            setInterval(initCurrentDatetime, 1000)

            generateSessionQrcode()
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

        function generateSessionQrcode() {
            axios({
                method: 'GET',
                url: `{{ route('api.web.stream') }}`,
                headers: {'Content-Type': 'application/json' }
            }).then((response) => {
                console.log(response.data)

                let data = "{'device_uuid':'"+response.data.unique_id+
                    "','session_token':'"+response.data.session_token+"'}"

                qrcode.clear()
                qrcode.makeCode(data)

                document.getElementById('currentDevice')
                    .innerHTML = `<b>Stream on - ${response.data.name.toUpperCase()} DEVICE</b>`

                countingSessionQrcode(response.data.refresh_time, response.data.refresh_time_mode)
            }).catch((error) => {
                alert(error)
            })
        }

        function countingSessionQrcode(sessionRefreshTime, sessionRefreshTimeMode) {
            let refreshTime

            if (sessionRefreshTimeMode === 'MINUTES') {
                refreshTime = parseInt(sessionRefreshTime) * 60 * 1000
            }

            if (sessionRefreshTimeMode === 'SECONDS') {
                refreshTime = parseInt(sessionRefreshTime) * 1000
            }

            let counting = setInterval(() => {
                refreshTime -= 1000

                let seconds = Math.floor((refreshTime / 1000) % 60)
                let minutes = Math.floor((refreshTime / (1000 * 60)) % 60)
                seconds = (seconds < 10) ? "0" + seconds : seconds
                minutes = (minutes < 10) ? "0" + minutes : minutes

                document
                    .getElementById('qrcodeRefreshTime')
                    .innerHTML = `Refresh : ${minutes}:${seconds}`

                if (seconds === '02') {
                    document
                        .getElementById('qrcodeRefreshTime')
                        .innerHTML = 'refreshing . . .'

                    clearInterval(counting)

                    window.location.reload()
                }
            }, 1000)
        }
    </script>
@endsection
