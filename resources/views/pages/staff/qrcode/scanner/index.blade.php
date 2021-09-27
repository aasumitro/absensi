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

        window.onload = () => {
            setInterval(initCurrentDatetime, 1000)
        }

        // let attend_token = null
        // let html5QrCode = new Html5Qrcode("qrcodeReader");
        // Html5Qrcode.getCameras().then(devices => {
        //     if (devices && devices.length) {
        //         html5QrCode.start(
        //             devices[0].id,
        //             {fps: 3, qrbox: 200},
        //             qrCodeMessage => {
        //                 const qrData = String(qrCodeMessage.slice(1,-1))
        //                 let dataObj = JSON.parse(qrData)
        //
        //                 if (attend_token == null) {
        //                     if (attend_token !== dataObj.attend_token) {
        //                         attend_token = dataObj.user_uuid
        //
        //                         console.log(dataObj)
        //
        //                         makeAttendanceFromQrcodeReader(
        //                             dataObj.user_uuid,
        //                             dataObj.attend_token
        //                         )
        //
        //                         html5QrCode.clear()
        //                     }
        //                 }
        //             },
        //             errorMessage => { }).catch(err => { alert(err) }
        //         )
        //     }
        // }).catch(err => {
        //     alert(err);
        // });

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "qrcodeReader", { fps: 10, qrbox: 200 }
        );

        function onScanSuccess(decodedText, decodedResult) {
            alert(decodedText)
            alert(decodedResult)
            document.getElementById('audioBeepSuccess').play();

            let dataObj = JSON.parse(decodedText)

            // window.location.replace(`${uri}=${dataObj.code}`)

            // html5QrcodeScanner.clear();
            // ^ this will stop the scanner (video feed) and clear the scan area.
        }

        html5QrcodeScanner.render(onScanSuccess);

        {{--function makeAttendanceFromQrcodeReader(user_uuid, attend_token) {--}}
        {{--    let bodyFormData = new FormData();--}}
        {{--    // ini langsung saja yang tipe desktop--}}
        {{--    // bodyFormData.append('device_uuid', device_uuid);--}}
        {{--    bodyFormData.append('user_uuid', user_uuid);--}}
        {{--    bodyFormData.append('attend_token', attend_token);--}}

        {{--    axios({--}}
        {{--        method: 'POST',--}}
        {{--        url: `{{ route('api.web.scan') }}`,--}}
        {{--        data: bodyFormData,--}}
        {{--        headers: {--}}
        {{--            'Content-Type': 'multipart/form-data',--}}
        {{--        }--}}
        {{--    }).then((response) => {--}}
        {{--        console.log(response);--}}

        {{--        document.getElementById('audioAttendSuccess').play();--}}

        {{--        setTimeout(function(){--}}
        {{--            window.location.reload()--}}
        {{--        }, 1500);--}}
        {{--    }).catch((error) => {--}}
        {{--        document.getElementById('audioAttendFailed').play();--}}

        {{--        setTimeout(function(){--}}
        {{--            alert(error)--}}
        {{--            window.location.reload()--}}
        {{--        }, 1500);--}}
        {{--    })--}}
        {{--}--}}

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
