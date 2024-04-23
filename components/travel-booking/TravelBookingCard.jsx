"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import Link from "next/link";
import React from "react";
import { FaCalendar, FaClock } from "react-icons/fa";

const TravelBookingCard = ({ destination }) => {
  const { isDarkMode } = useThemeContext();
  return (
    <Link
      href={`/travel-booking/${destination.category}/${destination.id}`}
      className={`rounded-xl max-w-[380px] shadow-lg  ${
        isDarkMode ? "bg-gray-800" : "bg-white border"
      }`}
    >
      <img
        src={destination.image}
        alt="travel Image"
        className="w-full h-[250px] rounded-t-xl"
      />
      <div className="flex flex-col mt-3 gap-4 px-3 lg:px-5 mb-10">
        <h2
          className={`font-semibold text-lg  ${
            isDarkMode ? "text-gray-300" : "text-gray-700"
          }`}
        >
          {destination.title}
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
          <p className="font-medium"> {destination.date}</p>
        </div>
        <p
          className={`font-semibold  text-right ${
            isDarkMode ? "text-blue-700" : "text-primary"
          }`}
        >
          KD 1000
        </p>
      </div>
    </Link>
  );
};

export default TravelBookingCard;
