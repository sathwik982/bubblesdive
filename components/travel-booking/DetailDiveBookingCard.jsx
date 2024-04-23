"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import React from "react";

const DetailDiveBooking = ({ trip }) => {
  const { isDarkMode } = useThemeContext();
  return (
    <div className="min-h-screen">
      <div className="relative overflow-hidden">
        <img
          src={trip.image}
          className="w-full h-[60vh] filter brightness-50 overflow-hidden object-cover"
          alt="trip image"
        />
        <div className="mx-auto max-w-[1200px]">
          <div className="text-white bottom-5 absolute w-full">
            <h3 className="my-3 px-3 font-semibold text-2xl md:text-3xl lg:text-4xl">
              {trip?.title}
            </h3>
          </div>
        </div>
      </div>

      <div className="flex flex-col gap-5 md:gap-10 max-w-[1200px] mx-auto mt-5 px-3">
        <div className="flex gap-3 flex-col">
          <h3
            className={`font-semibold text-lg md:text-xl lg:text-2xl  ${
              isDarkMode ? "text-blue-700" : "text-primary"
            }`}
          >
            Included:
          </h3>
          <p
            className={`px-1 ${isDarkMode ? "text-gray-400" : "text-gray-700"}`}
          >
            All the trips include snacks (sandwiches) and drinks (hot and cold).
          </p>
        </div>

        <div className="flex gap-3 flex-col">
          <h3
            className={`font-semibold text-lg md:text-xl lg:text-2xl  ${
              isDarkMode ? "text-blue-700" : "text-primary"
            }`}
          >
            Locations:
          </h3>
          <div
            className={`px-1 ${isDarkMode ? "text-gray-400" : "text-gray-700"}`}
          >
            {trip?.locations.map((location, idx) => (
              <span key={idx}>{location}, </span>
            ))}
          </div>
        </div>

        <div className="flex gap-3 flex-col">
          <h3
            className={`font-semibold text-lg md:text-xl lg:text-2xl  ${
              isDarkMode ? "text-blue-700" : "text-primary"
            }`}
          >
            Price:
          </h3>
          <div
            className={`px-1 md:px-3  ${
              isDarkMode ? "text-gray-400" : "text-gray-700"
            }`}
          >
            <table className="border border-gray-300">
              <thead>
                <tr className="border-b">
                  <th className="px-5 py-1 ">Location</th>
                  <th className="px-5 py-1 ">Price</th>
                </tr>
              </thead>
              <tbody>
                {trip?.prices.map((price, idx) => (
                  <tr
                    key={idx}
                    className={
                      idx % 2 === 0
                        ? `  ${
                            isDarkMode
                              ? "bg-gray-800 text-blue-500"
                              : "bg-gray-100"
                          }`
                        : ""
                    }
                  >
                    <td className="px-5 py-1 border-b">
                      {price.locations.map((location, idx) => (
                        <span key={idx} className="pl-1">
                          {location},{" "}
                        </span>
                      ))}
                    </td>
                    <td className="px-5 py-1 border-b">{price.price}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>

        <div className="flex flex-col gap-3 flex-wrap">
          <h3
            className={`font-semibold text-lg md:text-xl lg:text-2xl  ${
              isDarkMode ? "text-blue-700" : "text-primary"
            }`}
          >
            Description:
          </h3>
          <p className={`${isDarkMode ? "text-gray-400" : "text-gray-700"} `}>
            {trip?.description}
          </p>
        </div>
      </div>
    </div>
  );
};

export default DetailDiveBooking;
