"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import BreadCrumbs from "@/components/BreadCrumbs";
import Link from "next/link";
import React from "react";

const MainTravelBookingCard = ({ travel }) => {
  const { isDarkMode } = useThemeContext();
  const travels = [
    {
      id: "1",
      category: "local",
      image:
        "https://media.istockphoto.com/id/693573392/photo/aerial-drone-photo-of-sivota-with-clear-water-beaches-epirus-greece.jpg?s=1024x1024&w=is&k=20&c=-ZFZfmvROwo9gnCZGlYLFkg_IiUWPJoFrqlOTCkBns0=",
      date: "20-05-2024",
      title: "Local Trip Booking",
      description:
        "Explore the beauty of your local area with our guided tours and activities.",
    },
    {
      id: "2",
      category: "international",
      image:
        "https://media.istockphoto.com/id/497038029/photo/travel.jpg?s=1024x1024&w=is&k=20&c=-28EGY_mn5VH3Hv6r-J1jmOkUGCpxURL6lgzEWLmduU=",
      date: "20-05-2024",
      title: "International Trip Booking",
      description:
        "Embark on an unforgettable journey to exotic destinations around the world.",
    },
  ];

  return (
    <div className={`min-h-screen ${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
      <BreadCrumbs heading={"Travel Booking"} />
      <div className="py-10 md:py-14 mx-auto max-w-[1300px] ">
        <div className="flex flex-wrap justify-center gap-5 md:gap-10 px-3 md:px-5 w-full">
          {travels.map((travel, idx) => (
            <Link href={`/travel-booking/${travel?.category}`} key={idx}>
              <div
                className={`rounded-xl max-w-[550px] ${
                  isDarkMode ? "bg-gray-800" : "bg-white border"
                }  group shadow-md overflow-hidden hover:shadow-lg transition duration-300`}
              >
                <div className="relative">
                  <img
                    src={travel?.image}
                    alt={travel?.title}
                    className="w-full h-48 object-cover rounded-t-lg "
                  />
                </div>

                <div className="px-3 md:px-5 py-3">
                  <h2
                    className={`${
                      isDarkMode ? "text-gray-300" : "text-gray-700"
                    } font-semibold text-xl `}
                  >
                    {travel?.title}
                  </h2>
                  <p
                    className={`${
                      isDarkMode ? "text-gray-400" : "text-gray-500"
                    } mt-2`}
                  >
                    {travel?.description}
                  </p>
                </div>
                <div className="flex items-center justify-center mb-10 mt-5 ">
                  <p
                    className={`${
                      isDarkMode ? "text-blue-700" : "text-primary"
                    } font-semibold text-lg p-2 `}
                  >
                    Explore Now
                  </p>
                </div>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </div>
  );
};

export default MainTravelBookingCard;
