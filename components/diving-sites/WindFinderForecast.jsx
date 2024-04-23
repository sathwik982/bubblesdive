"use client";
import React, { useEffect, useRef } from "react";

const WindFinderForecast = () => {
  const widgetRef = useRef();

  useEffect(() => {
    // Check if the script is already loaded
    const scriptExists = document.querySelector(
      'script[src^="https://www.windfinder.com/widget/forecast/js/kuwait_city"]'
    );

    if (!scriptExists) {
      const script = document.createElement("script");
      script.src =
        "https://www.windfinder.com/widget/forecast/js/kuwait_city?unit_wave=m&unit_rain=mm&unit_temperature=c&unit_wind=kts&unit_pressure=hPa&days=2&show_day=1&show_waves=0";
      script.async = true;
      widgetRef.current.appendChild(script);

      return () => {
        // Cleanup function
        if (widgetRef.current) {
          widgetRef.current.removeChild(script);
        }
      };
    }
  }, []); // Empty dependency array to run useEffect only once

  return (
    <div className="-mt-[70px]">
      <div ref={widgetRef}></div>
    </div>
  );
};

export default React.memo(WindFinderForecast);
