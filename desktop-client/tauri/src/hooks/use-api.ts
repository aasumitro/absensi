function getCredentials(): any | null {
  return localStorage.getItem("settings");
}

function getAuthNHeader(): string | null {
  return localStorage.getItem("access_token");
}

async function aquireAccessToken() {
  const credential = getCredentials();
  if (!credential) {
    throw new Error("No credentials found");
  }

  try {
    const request = await fetch(`${credential?.api_url}/api/v1/devices/login`, {
      method: "POST",
      body: JSON.stringify({
        device_id: "", // get machine ID
        unique_id: credential?.device_id,
        password: credential?.device_key,
      }),
      headers: { "Content-Type": "multipart/form-data" },
    });
    const response = await request.json();
    localStorage.setItem("access_token", response.data.access_token);
    localStorage.setItem("access_token_expired", response.data.access_token);
    localStorage.setItem("session_token", response.data.session.token);
    localStorage.setItem("session_refresh", response.data.session.refresh_time);
    localStorage.setItem("session_refresh_mode", response.data.session.refresh_time_mode);
    localStorage.setItem("branch_name", response.data.branch_name);
    localStorage.setItem("device_name", response.data.device_name);
    localStorage.setItem("timezone", response.data.timezone);
  } catch (error) {
    throw error;
  }
}

async function generateQRCodeData() {}

async function refreshSession() {}

async function attendFromQRCodeReader() {}

export {
  getAuthNHeader,
  aquireAccessToken,
  generateQRCodeData,
  refreshSession,
  attendFromQRCodeReader,
};
