"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import { truncate } from "@/lib/trucate";
import Link from "next/link";
import { MdAddShoppingCart } from "react-icons/md";
import React from "react";
import { FaCalendar, FaClock } from "react-icons/fa";

const UpcomingTrip = ({ trip }) => {
  const { isDarkMode } = useThemeContext();
  return (
    <div
      className={`w-[250px] max-w-[300px]  hover:scale-105 shadow-lg rounded-lg ${
        isDarkMode ? "bg-gray-800" : "bg-white border"
      }`}
    >
      <Link href={`/travel-booking/local/${trip?.id}`}>
        <img
          className="  object-cover h-48 w-full  rounded-t-lg "
          src={trip?.image}
          alt="trip image"
        />
      </Link>
      <div className="px-5 my-3 flex-col flex gap-5">
        <h2 className={`${isDarkMode ? "text-gray-300" : "text-gray-900"} font-semibold`}>
          {truncate(trip?.title, 20)}
        </h2>

        <div
          className={`flex items-center gap-3  ${
            isDarkMode ? "text-gray-400" : "text-gray-600"
          }`}
        >
          <FaClock
            className={`${isDarkMode ? "text-blue-700" : "text-primary"}`}
          />
          <p className="font-medium">9 days</p>
        </div>

        <div
          className={`flex items-center gap-3  ${
            isDarkMode ? "text-gray-400" : "text-gray-600"
          }`}
        >
          <FaCalendar
            className={`${isDarkMode ? "text-blue-700" : "text-primary"}`}
          />
          <p className="font-medium"> {trip.date}</p>
        </div>
        <div
          className={`font-semibold  text-right ${
            isDarkMode ? "text-blue-700" : "text-primary"
          }`}
        >
         {trip?.price}
        </div>
      </div>
    </div>
  );
};

export default UpcomingTrip;
