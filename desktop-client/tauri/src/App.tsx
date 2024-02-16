import { useEffect, useState } from "react";
import { QRCodeSVG } from "qrcode.react";
import { QrScanner } from "@yudiel/react-qr-scanner";
import { Button } from "./components/ui/button";
import { RefreshCw } from "lucide-react";
import CurrentTime from "./components/current-time";
import RefreshCountdown from "./components/refresh-countdown";
import SettingDrawer from "./components/setting-drawer";
import ConfirmExitDrawer from "./components/confirm-exit-drawer";
import { cn } from "./libs/class-merge";
import { Skeleton } from "./components/ui/skeleton";

function App() {
  const [refresh, setRefresh] = useState(false);
  const [settings, setSettings] = useState(null);
  const [mediaStream, setMediaStream] = useState<MediaStream | null>(null);

  useEffect(() => {
    appSetting();
  }, []);

  const refreshApp = () => {
    setRefresh(!refresh);
    setTimeout(() => setRefresh(refresh), 2500);
    appSetting();
  };

  const appSetting = () => {
    const storedData = localStorage.getItem("settings");
    if (storedData) {
      const object = JSON.parse(storedData);
      setSettings(object);
      if (object?.device_mode === "scanner") {
        startCamera();
      } else {
        // Stop all tracks in the media stream
        mediaStream?.getTracks().forEach((track) => {
          track.stop();
          // Release any other references to the track
          track.onended = null;
        });
        // Reset the media stream state variable
        setMediaStream(null);
      }
    }
  };

  const startCamera = async () => {
    try {
      if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        setMediaStream(stream);
      } else {
        alert("Kamera tidak ditemukan. Pastikan kamera sudah terpasang.");
      }
    } catch (err) {
      alert("Gagal mengakses kamera. Pastikan kamera sudah diizinkan.");
    }
  };

  return (
    <div className="relative flex h-screen w-screen flex-col p-2">
      <section className="item-center flex flex-row items-center justify-between">
        <SettingDrawer callback={refreshApp} />
        <ConfirmExitDrawer />
      </section>
      <section className="m-auto mb-4 mt-0 flex flex-col items-center">
        <div className="flex flex-col items-center">
          <img className="mb-2 w-16" src="./src/assets/absensi.png" alt="logo" />
          {refresh ? (
            <Skeleton className="mt-1 h-6 w-28" />
          ) : (
            <h3 className="text-lg font-semibold">Biro Umum</h3>
          )}
          {refresh ? (
            <Skeleton className="mt-1 h-4 w-32" />
          ) : (
            <p className="font-mono text-xs italic">[DC] Kantor LT.3</p>
          )}
          {refresh ? <Skeleton className="mt-1 h-2 w-36" /> : <CurrentTime />}
          {refresh ? (
            <Skeleton className="mt-4 h-36 w-36" />
          ) : (
            <>
              {settings?.device_mode === "scanner" ? (
                <div className="mt-4  h-36 w-36">
                  <QrScanner
                    onDecode={(result) => console.log(result)}
                    onError={(error) => console.log(error?.message)}
                  />
                </div>
              ) : (
                <QRCodeSVG className="mt-4 h-36 w-36" value="https://reactjs.org/" />
              )}
            </>
          )}
          {refresh ? <Skeleton className="mt-4 h-2 w-20" /> : <RefreshCountdown />}
        </div>
      </section>
      <Button
        size="icon"
        className="absolute bottom-0 right-0 mb-4 mr-4 rounded-full transition-colors duration-300 ease-in-out hover:bg-gray-500 active:bg-gray-700"
        onClick={refreshApp}
        disabled={refresh}
      >
        <RefreshCw className={cn(refresh ? "animate-spin" : "", "h-4 w-4")} />
      </Button>
    </div>
  );
}

export default App;
