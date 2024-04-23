"use client";
// WindStatistics.js

import React, { useEffect, useRef } from "react";

const WindStatistics = () => {
  const widgetRef = useRef();

  useEffect(() => {
    // Check if the script is already loaded
    const scriptExists = document.querySelector(
      'script[src^="https://www.windfinder.com/widget/statistics/js/kuwait_city"]'
    );

    if (!scriptExists) {
      const script = document.createElement("script");
      script.src =
        "https://www.windfinder.com/widget/statistics/js/kuwait_city?unit_wind=kts&unit_temperature=c";
      script.async = true;
      widgetRef.current.appendChild(script);

      return () => {
        // Check if widgetRef.current is truthy before accessing its properties
        if (widgetRef.current) {
          widgetRef.current.removeChild(script);
        }
      };
    }
  }, []);

  return (
    <div className="-mt-[70px]">
      <div ref={widgetRef}></div>
    </div>
  );
};

export default WindStatistics;
