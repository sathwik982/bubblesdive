import { useThemeContext } from "@/hooks/ThemeContext";
import React from "react";

const DetailTravelBookingCard = ({ destination }) => {
  const { isDarkMode } = useThemeContext();
  return (
    <div className="  min-h-screen">
      <div className="relative overflow-hidden">
        <img
          src={destination.image}
          className="w-full h-[60vh] filter brightness-50  overflow-hidden object-cover"
          alt="travel image"
        />
        <div className="mx-auto max-w-[1200px]">
          <div className="text-white bottom-10  absolute   w-full">
            <h3 className="my-3 px-3 font-semibold text-2xl md:text-3xl lg:text-4xl">
              {destination?.title}
            </h3>
          </div>
        </div>
      </div>

      <div className="flex flex-col gap-5 md:gap-10 max-w-[1100px] mx-auto mt-5 md:mt-8    px-3">
        <div className="flex justify-between items-start flex-wrap gap-5">
          <div className="flex flex-col  flex-wrap gap-2 ">
            <h3
              className={`font-semibold ${
                isDarkMode ? "text-blue-700" : "text-primary"
              }  text-lg md:text-xl lg:text-2xl`}
            >
              Week 1:
            </h3>
            <p
              className={`${
                isDarkMode ? "text-gray-300" : "text-gray-700"
              } px-3 font-medium `}
            >
              Ending Point Hurghada
            </p>
            <p  className={`${
                isDarkMode ? "text-gray-400" : "text-gray-700"
              } px-3 font-medium `}>
              Dates:
              <span
                className={`${
                  isDarkMode ? "text-blue-700" : "text-primary"
                }  px-3 font-semibold`}
              >
                27/06/2024 - 04/07/2024
              </span>
            </p>
            <ul
              className={`${
                isDarkMode ? "text-gray-400" : "text-gray-700"
              } pl-10 list-disc `}
            >
              <li>Dahab</li>
              <li>Tiran</li>
              <li>Ras Mohammad</li>
              <li>Rosalie Moller Wreck</li>
              <li>Thistlegorm Wreck</li>
              <li>Abu Nahas Wreck</li>
            </ul>
          </div>

          <div className="flex flex-col  flex-wrap gap-2 ">
            <h3
              className={`font-semibold ${
                isDarkMode ? "text-blue-700" : "text-primary"
              }  text-lg md:text-xl lg:text-2xl`}
            >
              Week 2:
            </h3>
            <p
              className={`${
                isDarkMode ? "text-gray-300" : "text-gray-700"
              } px-3 font-medium `}
            >
              Ending Point Port Ghalib
            </p>
            <p
              className={`${
                isDarkMode ? "text-gray-400" : "text-gray-700"
              } px-3 font-medium `}
            >
              Dates:
              <span
                className={`${
                  isDarkMode ? "text-blue-700" : "text-primary"
                }  px-3 font-semibold`}
              >
                04/07/2024 - 11/07/2024
              </span>
            </p>
            <ul
              className={`${
                isDarkMode ? "text-gray-400" : "text-gray-700"
              } pl-10  list-disc `}
            >
              <li>Salim Express Wreck</li>
              <li>Brothers Islands</li>
              <li>Deadalus Reef</li>
              <li>Elphinstone</li>
            </ul>
          </div>
        </div>

        <div className="flex gap-3 flex-wrap flex-col">
          <h3
            className={`font-semibold ${
              isDarkMode ? "text-blue-700" : "text-primary"
            }  text-lg md:text-xl lg:text-2xl`}
          >
            Included:
          </h3>
          <ul
            className={`${
              isDarkMode ? "text-gray-400" : "text-gray-700"
            } pl-6  list-decimal `}
          >
            <li>3-4 guided dives per day.</li>
            <li>Transportation inside Egypt to and from Airport.</li>
            <li>All meals on boat + soft drinks, Coffee and Snacks.</li>
            <li>Nitrox only for certified divers /BCD, Regulator.</li>
          </ul>
        </div>

        <div className="flex flex-col gap-3 flex-wrap">
          <h3
            className={`font-semibold ${
              isDarkMode ? "text-blue-700" : "text-primary"
            }  text-lg md:text-xl lg:text-2xl`}
          >
            Description:
          </h3>
          <p
            className={`${
              isDarkMode ? "text-gray-400" : "text-gray-700"
            }  px-1 md:px-3`}
          >
            {destination?.description}
          </p>
        </div>
      </div>
    </div>
  );
};

export default DetailTravelBookingCard;
