const axios = require('axios')
const {machineIdSync} = require('node-machine-id');
const { getCurrentWindow } = require('electron').remote;

let reload = () => getCurrentWindow().reload();

// initialize qrcodejs
let qrcode = new QRCode(document.getElementById("qrcode"), {
  width: 200,
  height: 200,
  colorDark: "#000000",
  colorLight: "#ffffff",
  correctLevel: QRCode.CorrectLevel.H
});

// counting interval
let counting

// current build version
let buildVersion = "v2021.1.0"

// do run on window first load
window.onload = () => {
  document.getElementById('build-version').innerHTML = `${buildVersion}`

  // init current date time
  setInterval(initCurrentDatetime, 1000)

  let mode = localStorage.getItem('mode') ?? 'GENERATOR'
  let uuid = localStorage.getItem('uuid') ?? 'default'
  let pass = localStorage.getItem('pass') ?? 'default'
  let branch = localStorage.getItem('branch_name') ?? 'load . . .'
  let device = localStorage.getItem('device_name') ?? 'load . . .'

  // initialized credentials modal
  initCredentialsModal()

  if (uuid === 'default' || pass === 'default') {
    document
      .getElementById('buttonCredential')
      .click()
  } else {
    if (localStorage.getItem("access_token") != null) {
      authenticate()

      generateSessionQrcode()

      document.getElementById('currentBranch')
          .innerHTML = branch
      document.getElementById('currentDevice')
          .innerHTML = device
    } else authenticate()
  }

  if (mode === 'GENERATOR') {
    document.getElementById('qrcode').classList.remove('d-none')
    document.getElementById('qrcodeRefresh').classList.remove('d-none')
    document.getElementById('qrcodeReader').classList.add('d-none')
  }

  if (mode === 'SCANNER') {
    document.getElementById('qrcode').classList.add('d-none')
    document.getElementById('qrcodeRefresh').classList.add('d-none')
    document.getElementById('qrcodeReader').classList.remove('d-none')
    qrcodeReader()
  }
}

/**
 *
 * function to run and watch modal credetials
 * when credentials data is not set
 *
 * @credential device_uuid
 * @credential device_password
 *
 */
function initCredentialsModal() {
  let credentialModalView = document.getElementById('modalCredential')
  let modalInputModeView = document.getElementById('inputMODE')
  let modalInputUUIDView = document.getElementById('inputUUID')
  let modalInputPasswordView = document.getElementById('inputSECRET')
  let modalInputAPIURLView = document.getElementById('inputAPIURL')
  let buttonSaveView = document.getElementById('buttonSaveCredentials')

  modalInputUUIDView.value = localStorage.getItem('uuid') ?? 'default'
  modalInputPasswordView.value = localStorage.getItem('pass') ?? 'default'
  modalInputAPIURLView.value = localStorage.getItem('api_url') ?? 'default'

  credentialModalView.addEventListener('show.bs.modal', () => {
    modalInputUUIDView.focus()
    buttonSaveView.addEventListener('click', () => {
      if (!isNotEmpty(modalInputUUIDView)) return
      else if (!isNotEmpty(modalInputPasswordView)) return
      else if (!isNotEmpty(modalInputAPIURLView)) return
      else {
        localStorage.setItem('mode', modalInputModeView.value)
        localStorage.setItem('uuid', modalInputUUIDView.value)
        localStorage.setItem('pass', modalInputPasswordView.value)
        localStorage.setItem('api_url', modalInputAPIURLView.value)
        localStorage.removeItem("access_token");
        alert('Data diperbaharui!')
        reload()
      }
    })
  })
}

function isNotEmpty(field) {
  let fieldData = field.value;

  if (fieldData.length === 0 || fieldData === "") {
    alert(`kolom: ${field.id} tidak boleh kosong`);
    return false;
  } else {
    return true;
  }
}

/**
 *
 * Current datetime initalizer
 *
 */
function initCurrentDatetime() {
  let currentDatetimeView = document.getElementById('currentDatetime')
 
  const today = new Date()

  const date = today.toLocaleDateString('id-ID', {
    year: "numeric",
    month: "long",
    day: "2-digit",
    timeZone: currentTimezone()
  })

  const time = today.toLocaleTimeString('en-US', {
    formatMatcher: 'best fit',
    hour12: false,
    timeZone: currentTimezone()
  })

  currentDatetimeView.innerHTML = [date, time].join(' - ')
}

function authenticate() {
  let token = localStorage.getItem('access_token')
  let token_expired = localStorage.getItem('access_token_expired')
  let uuid = localStorage.getItem('uuid')
  let pass = localStorage.getItem('pass')
  let api_url = localStorage.getItem('api_url')

  if (token != null) {
    let current = new Date()
    let expired = new Date(parseInt(token_expired) * 1000);

    if (current > expired) {login(
      api_url,
      uuid,
      pass
    )}
  } else {login(
    api_url,
    uuid,
    pass
  )}
}

function login(url, uuid, pwd) {
  let machineId = machineIdSync({original: true})

  let bodyFormData = new FormData();
  bodyFormData.append('unique_id', uuid);
  bodyFormData.append('password', pwd);
  bodyFormData.append('device_id', machineId);

  axios({
    method: 'POST',
    url:`${url}/api/v1/devices/login`,
    data: bodyFormData,
    headers: {'Content-Type': 'multipart/form-data' }
  }).then((response) => {
    localStorage.setItem('access_token', response.data.data.access.token)
    localStorage.setItem('access_token_expired', response.data.data.access.expires_in)
    localStorage.setItem('session_token', response.data.data.session.token)
    localStorage.setItem('session_refresh', response.data.data.session.refresh_time)
    localStorage.setItem('session_refresh_mode', response.data.data.session.refresh_time_mode)
    localStorage.setItem('branch_name', response.data.data.branch_name)
    localStorage.setItem('device_name', response.data.data.device_name)
    localStorage.setItem('timezone', response.data.data.timezone.area)
    reload()
  }).catch((error) => {
    clearQr()

    errorMapping(error)

    document
      .getElementById('buttonCredential')
      .click()
  })
}

/**
 *
 * this function is to generate new qrcode
 * from stream data or from current data
 *
 */
function generateSessionQrcode() {
  let uuid = localStorage.getItem('uuid')
  let session_token = localStorage.getItem('session_token')
  let session_expired = localStorage.getItem('session_refresh')
  let session_counting_mode = localStorage.getItem('session_refresh_mode')

  let data = "{'device_uuid':'"+uuid+"','session_token':'"+session_token+"'}"

  qrcode.clear()
  qrcode.makeCode(data)

  countingSessionQrcode(session_expired, session_counting_mode)
}

/**
 *
 * this function to counting down current qrcode
 * session time before it will be refreshed
 *
 */
function countingSessionQrcode(sessionRefreshTime, sessionRefreshTimeMode) {
  let refreshTime

  if (sessionRefreshTimeMode === 'MINUTES') {
    refreshTime = parseInt(sessionRefreshTime) * 60 * 1000
  }

  if (sessionRefreshTimeMode === 'SECONDS') {
    refreshTime = parseInt(sessionRefreshTime) * 1000
  }

  counting = setInterval(() => {
    refreshTime -= 1000

    let seconds = Math.floor((refreshTime / 1000) % 60)
    let minutes = Math.floor((refreshTime / (1000 * 60)) % 60)
    seconds = (seconds < 10) ? "0" + seconds : seconds
    minutes = (minutes < 10) ? "0" + minutes : minutes

    document
      .getElementById('qrcodeRefresh')
      .innerHTML = `Refresh : ${minutes}:${seconds}`

    if (seconds === '02') {
      document
        .getElementById('qrcodeRefresh')
        .innerHTML = 'refreshing . . .'

      refreshSession()

      clearInterval(counting)
    }
  }, 1000)
}

/**
 *
 * this function will do stream on websocket
 *
 */
function refreshSession() {
  let access_token = localStorage.getItem('access_token')
  let api_url = localStorage.getItem('api_url')

  console.log("Starting refreshing device session")

  axios({
    method: 'GET',
    url:`${api_url}/api/v1/devices/stream`,
    headers: {'Authorization': `Bearer ${access_token}`}
  }).then((response) => {
    localStorage.setItem('session_token', response.data.data.token)
    localStorage.setItem('session_refresh', response.data.data.refresh_time)
    localStorage.setItem('session_refresh_mode', response.data.data.refresh_time_mode)
    reload()

    console.log("success refreshing device session")
  }).catch((error) => {
    clearQr()

    errorMapping(error)
  })
}

function clearQr() {
  qrcode.clear()
  clearInterval(counting)
  document
      .getElementById('qrcodeRefresh')
      .innerHTML = 'refreshing . . .'
}

function qrcodeReader() {
  let attend_token = null 
  var html5QrCode = new Html5Qrcode("qrcodeReader");

  Html5Qrcode.getCameras().then(devices => {
    if (devices && devices.length) {
      html5QrCode.start(
        devices[0].id, 
        {fps: 3, qrbox: 175},
        qrCodeMessage => {
          const qrData = String(qrCodeMessage.slice(1,-1))
          let dataObj = JSON.parse(qrData)
          
          if (attend_token == null) {
            if (attend_token != dataObj.attend_token) {
              attend_token = dataObj.user_uuid
            
              makeAttendanceFromQrcodeReader(
                dataObj.user_uuid, 
                dataObj.attend_token
              )

              html5QrCode.clear()
            }
          }
        },
        errorMessage => { }).catch(err => { alert(err) }
      )
    }
  }).catch(err => {
    // handle err
    alert(err);
  });
}

function makeAttendanceFromQrcodeReader(user_uuid, attend_token) {
  let access_token = localStorage.getItem('access_token')
  let api_url = localStorage.getItem('api_url')
  let device_uuid = localStorage.getItem('uuid')

  let bodyFormData = new FormData();
  bodyFormData.append('device_uuid', device_uuid);
  bodyFormData.append('user_uuid', user_uuid);
  bodyFormData.append('attend_token', attend_token);

  axios({
    method: 'POST',
    url:`${api_url}/api/v1/devices/scan`,
    data: bodyFormData,
    headers: {
      'Content-Type': 'multipart/form-data',
      'Authorization': `Bearer ${access_token}`
    }
  }).then((response) => {
    console.log(response); 

    document.getElementById('audioAttendSuccess').play();

    setTimeout(function(){
      reload()
    }, 1500);
  }).catch((error) => {
    console.log(error)
    
    document.getElementById('audioAttendFailed').play();
   
    setTimeout(function(){
      reload()
    }, 1500);
  })
}

const closeBtn = document.getElementById('buttonCloseWindow')
closeBtn.addEventListener('click', function () {
  getCurrentWindow().close()
})

const reloadBtn = document.getElementById('buttonReloadPage')
reloadBtn.addEventListener('click', function () {
  localStorage.removeItem("access_token");
  reload()
})

function currentTimezone() {
  let timezone = localStorage.getItem('timezone') ?? "WITA"
  
  switch(timezone) { 
    case "WIB":
      return "Asia/Jakarta"
    case "WITA": 
      return "Asia/Makassar"
    case "WIT": 
      return "Asia/Jayapura"
  }
}

function errorMapping(error) {
  switch(error.message) {
    case "Network Error": 
      alert("Tidak dapat menghubungkan ke server, mohon periksa koneksi internet atau API_URL!")
      break
    case "Request failed with status code 404":
      alert("API_URL tidak valid, mohon periksa kembali!")
      break
    case "Request failed with status code 422":
      alert("Tidak dapat memproses data, mohon periksa kembali!")
      break
    case "Request failed with status code 500":
      alert("Terjadi masalah pada server, mohon hubungi tim IT!")
      break
    default: 
      alert(`Terjadi kesalahan tak terduga: ${error}, ${error.response.data.errors}, mohon difoto dan kirim ke tim IT`)
  }
}
