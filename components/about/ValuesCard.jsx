import { useThemeContext } from "@/hooks/ThemeContext";
import React from "react";

const ValuesCard = ({ value }) => {
  const { isDarkMode } = useThemeContext();
  return (
    <div
      className={`${
        isDarkMode ? "bg-gray-800 hover:outline-blue-700" : "bg-blue-50 hover:outline-primary"
      } p-3 sm:p-5 rounded-lg flex flex-col gap-3  hover:outline-2 hover:outline`}
    >
      <h2
        className={`${
          isDarkMode ? "text-gray-300" : ""
        } text-lg md:text-xl font-medium`}
      >
        {value.title}
      </h2>
      <h2 className={`${isDarkMode ? "text-gray-400" : "text-gray-800"} `}>
        {value.description}
      </h2>
    </div>
  );
};

export default ValuesCard;
