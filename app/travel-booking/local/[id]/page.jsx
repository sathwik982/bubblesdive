"use client";
import DetailDiveBooking from "@/components/travel-booking/DetailDiveBookingCard";
import DiveBookingForm from "@/components/travel-booking/DiveBookingForm";
import { useThemeContext } from "@/hooks/ThemeContext";
import React from "react";

const DetailLocalTripBooking = () => {
  const { isDarkMode } = useThemeContext();
  const trip = {
    title: "Diving Trip",
    image:
      "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/e6/68/e66895efa2e7543ee762a6e045cf97b8.webp",
    locations: ["Kubbar Island", " tailor rock ", " AJ wreck", "Garouh Island"],
    prices: [
      {
        price: "40",
        locations: ["Kubbar Island", " tailor rock ", " AJ wreck"],
      },
      {
        price: "32",
        locations: ["Garouh Island", "Umm Al Maradim Island"],
      },
    ],
    price: 55,
    description: `
    Join us on an unforgettable diving adventure! Our diving trip takes you to the most breathtaking underwater destinations, where you'll encounter vibrant coral reefs, diverse marine life, and stunning underwater landscapes. Dive into crystal-clear waters teeming with tropical fish, explore mesmerizing underwater caves, and swim alongside majestic sea turtles. 

    Our experienced guides will lead you on exhilarating dives, ensuring your safety while providing expert knowledge about the marine ecosystems you'll explore. Whether you're a seasoned diver or new to the underwater world, our diving trip offers something for everyone.

    Highlights of the trip include:
    - Guided dives at renowned dive sites
    - Opportunities for underwater photography
    - Relaxing surface intervals on pristine beaches
    - Delicious meals featuring local cuisine
    - Evening entertainment and social gatherings

    Don't miss out on this incredible diving experience! Book your spot now and embark on the adventure of a lifetime.`,
  };
  return (
    <div
      className={`pb-20 flex flex-col gap-10 ${
        isDarkMode ? "bg-gray-900" : "bg-white"
      }`}
    >
      <DetailDiveBooking trip={trip} />
      <DiveBookingForm trip={trip} />
    </div>
  );
};

export default DetailLocalTripBooking;
