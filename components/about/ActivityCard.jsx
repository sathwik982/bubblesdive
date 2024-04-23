"use client";
import { useThemeContext } from "@/hooks/ThemeContext";

const ActivityCard = ({ activity, index }) => {
  const { isDarkMode } = useThemeContext();
  const evenStyle = index % 2 === 0;
  return (
    <div
      className={`${
        evenStyle
          ? "bg-primary hover:border hover:border-black"
          : ` ${
              isDarkMode
                ? "bg-gray-800 shadow-lg hover:border-blue-700"
                : "bg-white hover:border-primary"
            }  hover:border `
      }  rounded-lg shadow-lg  max-w-[280px] py-2 `}
    >
      <div className="px-3 mt-3 mb-5">
        <h3
          className={`text-lg font-semibold ${
            evenStyle
              ? "text-white"
              : `${isDarkMode ? "text-blue-700" : "text-primary"}`
          }  mb-2`}
        >
          {activity.title}
        </h3>
        <p
          className={`${
            evenStyle
              ? `${isDarkMode ? "text-gray-300 " : "text-gray-300"}  `
              : "text-gray-500   "
          } `}
        >
          {activity.description}
        </p>
      </div>
    </div>
  );
};
export default ActivityCard;
