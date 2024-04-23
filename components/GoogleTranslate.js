import React, { useEffect } from "react";

const GoogleTranslate = () => {
  useEffect(() => {
    const script = document.createElement("script");
    script.src =
      "//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
    script.async = true;
    document.head.appendChild(script);
    return () => {
      document.head.removeChild(script);
    };
  }, []);

  return <div id="google_translate_element"></div>;
};

export default GoogleTranslate;
