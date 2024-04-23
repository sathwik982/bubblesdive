"use client";
import React, { useState, useEffect, createContext, useContext } from "react";

const ThemeContext = createContext();

export const useThemeContext = () => {
  const context = useContext(ThemeContext);
  return context;
};

export const ThemeContextProvider = ({ children }) => {
  const [isDarkMode, setIsDarkMode] = useState(false);

  useEffect(() => {
    const themeData = localStorage.getItem("dark");
    if (themeData === "true") {
      setIsDarkMode(true);
    } else {
      setIsDarkMode(false);
    }
  }, []);

  const toggleMode = () => {
    localStorage.setItem("dark", !isDarkMode);
    setIsDarkMode(!isDarkMode);
  };

  return (
    <ThemeContext.Provider value={{ isDarkMode, toggleMode }}>
      <div className={`${isDarkMode ? "dark" : "light"}`}>{children}</div>
    </ThemeContext.Provider>
  );
};
