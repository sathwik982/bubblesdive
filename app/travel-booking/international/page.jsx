"use client";
import BreadCrumbs from "@/components/BreadCrumbs";
import TravelBookingCard from "@/components/travel-booking/TravelBookingCard";
import { useThemeContext } from "@/hooks/ThemeContext";
import React from "react";

const InternationalBooking = () => {
  const { isDarkMode } = useThemeContext();
  const destinations = [
    {
      id: "1",
      category: "international",
      image:
        "https://media.istockphoto.com/id/157317898/photo/exotic-beach-with-parasols-and-bougainvillea-sharm-el-sheikh-egypt.jpg?s=1024x1024&w=is&k=20&c=dBIyaHkLTvGA8mQWEATJLdrQnSkba04iHwy8Yq9Ram4=",
      date: "27-06-2024",
      title: "Red Sea Liveboard, Egypt",
      description: "",
    },
    {
      id: "6",
      category: "international",
      image:
        "https://media.istockphoto.com/id/1145450965/photo/santorini-island-greece.jpg?s=1024x1024&w=is&k=20&c=CJ5Xq7fI59y9j8TkYweTw0zlwebmrA-pJlvtnA_JjEQ=",
      date: "20-05-2024",
      title: "Santorini, Greece",
      description:
        "Explore the stunning island of Santorini, known for its breathtaking sunsets, white-washed buildings, and crystal-clear waters. Wander through charming villages, visit ancient ruins, and relax on beautiful beaches.",
    },
    {
      id: "7",
      category: "international",
      image:
        "https://media.istockphoto.com/id/1146262403/photo/woman-wearing-japanese-traditional-kimono-walking-at-historic-higashiyama-district-in-spring.jpg?s=1024x1024&w=is&k=20&c=1Hv7MNGuVtPm0rxC2T5cNa4AMvBQRWPXc-K0G1J9rP4=",
      date: "20-05-2024",
      title: "Kyoto, Japan",
      description:
        "Discover the cultural treasures of Kyoto, Japan's former imperial capital. Explore magnificent temples, stroll through peaceful gardens, and experience traditional tea ceremonies.",
    },
    {
      id: "8",
      category: "international",
      image:
        "https://media.istockphoto.com/id/1339071089/photo/machu-picchu-inca-ruins.jpg?s=1024x1024&w=is&k=20&c=P6nxdbVl6_efPDX4vCoGzF7vy7rTveItHuFqd0dD65w=",
      date: "20-05-2024",
      title: "Machu Picchu, Peru",
      description:
        "Embark on an adventure to the ancient Incan citadel of Machu Picchu, nestled in the Andes Mountains. Trek along scenic trails, marvel at the breathtaking ruins, and soak in the majestic mountain views.",
    },
    {
      id: "9",
      category: "international",
      image:
        "https://media.istockphoto.com/id/1136053333/photo/elephant-and-lion.jpg?s=1024x1024&w=is&k=20&c=yl49h_rZ2gOiyieWMXntPG3rxBX5bjRZRzHZHjqVBzY=",
      date: "20-05-2024",
      title: "Serengeti National Park, Tanzania",
      description:
        "Experience the wonder of the Serengeti, home to an incredible diversity of wildlife and the iconic Great Migration. Join a safari adventure to spot lions, elephants, giraffes, and more in their natural habitat.",
    },
    {
      id: "10",
      category: "international",
      image:
        "https://media.istockphoto.com/id/1145422105/photo/eiffel-tower-aerial-view-paris.jpg?s=1024x1024&w=is&k=20&c=cA71j4n2iK3lhHUexm3dkJqZt8Lc0fRYKG_dhwVXBKQ=",
      date: "20-05-2024",
      title: "Paris, France",
      description:
        "Fall in love with the charm and romance of Paris, the City of Light. Explore world-renowned landmarks, indulge in exquisite cuisine, and immerse yourself in the city's rich history and culture.",
    },
  ];

  return (
    <div className={`min-h-screen ${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
      <BreadCrumbs heading={"International Trip Booking"} />
      <div className="max-w-[1300px] mx-auto px-3 md:px-5 ">
        <div className="flex gap-5 md:gap-10 flex-wrap justify-center py-10 md:py-14 ">
          {destinations.map((destination) => (
            <TravelBookingCard destination={destination} key={destination.id} />
          ))}
        </div>
      </div>
    </div>
  );
};

export default InternationalBooking;
