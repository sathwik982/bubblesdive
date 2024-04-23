"use client";
import DetailTravelBookingCard from "@/components/travel-booking/DetailTravelBookingCard";
import DetailTravelBookingForm from "@/components/travel-booking/DetailTravelBookingForm";
import { useThemeContext } from "@/hooks/ThemeContext";
import React from "react";

const DetailInternationalTrip = () => {
  const { isDarkMode } = useThemeContext();
  const destination = {
    id: "1",
    title: "Liveaboard to the red sea - Egypt",
    image:
      "https://media.istockphoto.com/id/157317898/photo/exotic-beach-with-parasols-and-bougainvillea-sharm-el-sheikh-egypt.jpg?s=1024x1024&w=is&k=20&c=dBIyaHkLTvGA8mQWEATJLdrQnSkba04iHwy8Yq9Ram4=",
    description:
      "This liveaboard adventure offers an unparalleled opportunity to explore some of the most iconic dive sites in the Red Sea, accompanied by experienced guides and with all logistical aspects taken care of. Whether you're a seasoned diver seeking new challenges or a beginner eager to discover the wonders of the underwater world, this expedition promises an unforgettable experience.",
  };
  return (
    <div className={`min-h-screen ${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
      <DetailTravelBookingCard destination={destination} />
      <div className="max-w-[1100px] mx-auto px-3 md:px-5 py-10 md:py-14 lg:py-20">
        <DetailTravelBookingForm trip={destination} />
      </div>
    </div>
  );
};

export default DetailInternationalTrip;
