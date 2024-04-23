"use client";
import BreadCrumbs from "@/components/BreadCrumbs";
import DiveBookingCard from "@/components/travel-booking/DiveBookingCard";
import TravelBookingCard from "@/components/travel-booking/TravelBookingCard";
import { useThemeContext } from "@/hooks/ThemeContext";
import React from "react";

const LocalTripBooking = () => {
  const { isDarkMode } = useThemeContext();
  const trips = [
    {
      id: "1",
      title: "Snorkel Trip",
      category: "local",
      date: "20-05-2024",
      description:
        "Explore coral reefs and marine life while gliding through crystal-clear waters on our snorkel adventure.",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/37/ae/37aee8e204107ba68e22baf3cba1ad08.webp",
    },
    {
      id: "2",
      title: "Discover Scuba Diving Trip",
      category: "local",
      date: "22-05-2024",
      description:
        "Experience the thrill of diving beneath the waves with expert guidance during our Discover Scuba Diving excursion.",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/e6/68/e66895efa2e7543ee762a6e045cf97b8.webp",
    },
    {
      id: "3",
      title: "Diving Trip",
      category: "local",
      date: "25-05-2024",
      description:
        "Immerse yourself in ocean depths, exploring captivating dive sites and encountering diverse marine creatures.",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/6d/bc/6dbcca413b14352c8bfcb4ff6dc7d357.webp",
    },
  ];

  return (
    <div className={`min-h-screen ${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
      <BreadCrumbs heading={"Local Trip Booking"} />
      <div className="max-w-[1300px] mx-auto py-10 md:py-14 px-5">
        <div className="flex justify-center flex-wrap gap-8  ">
          {trips.map((trip) => (
            <TravelBookingCard destination={trip} key={trip.id} />
          ))}
        </div>
      </div>
    </div>
  );
};

export default LocalTripBooking;
