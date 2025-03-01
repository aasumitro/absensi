import { useState, useEffect } from "react";
import "moment/locale/id";

function RefreshCountdown() {
  const [countdown, setCountdown] = useState(60);

  useEffect(() => {
    const interval = setInterval(() => {
      setCountdown((prevCountdown) => {
        if (prevCountdown === 0) {
          return 60;
        } else {
          return prevCountdown - 1;
        }
      });
    }, 1000);

    return () => clearInterval(interval);
  }, []);

  return (
    <>
      <p className="mt-2 text-xs font-light">Refresh in: {countdown}</p>
    </>
  );
}

export default RefreshCountdown;
