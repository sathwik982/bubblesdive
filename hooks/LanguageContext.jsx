"use client";
import { createContext, useContext, useEffect, useState } from "react";

const LanguageContext = createContext();

export const useLanguageContext = () => {
  const context = useContext(LanguageContext);
  return context;
};

export const LanguageContextProvider = ({ children }) => {
  const [selectedLanguage, setSelectedLanguage] = useState("");
  const [direction, setDirection] = useState("ltr");

  useEffect(() => {
    const storedLanguage = localStorage.getItem("language");

    if (storedLanguage) {
      setSelectedLanguage(storedLanguage);
      setDirection(storedLanguage === "arabic" ? "rtl" : "ltr");
    }
  }, []);

  const changeLanguage = (lang) => {
    setSelectedLanguage(lang);
    localStorage.setItem("language", lang); // Corrected the key here
    setDirection(lang === "arabic" ? "rtl" : "ltr");
  };

  return (
    <LanguageContext.Provider value={{ selectedLanguage, changeLanguage }}>
      <div dir={direction}>{children}</div>
    </LanguageContext.Provider>
  );
};
