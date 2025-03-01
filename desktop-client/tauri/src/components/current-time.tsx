import { useState, useEffect } from "react";
import moment from "moment";
import "moment/locale/id";

function CurrentTime() {
  const [currentTime, setCurrentTime] = useState(moment().locale("id"));

  useEffect(() => {
    const interval = setInterval(() => {
      setCurrentTime(moment().locale("id"));
    }, 1000);

    return () => clearInterval(interval);
  }, []);

  return (
    <>
      <p className="text-xs font-light">{currentTime.format("D MMMM YYYY - HH:mm:ss")}</p>
    </>
  );
}

export default CurrentTime;
