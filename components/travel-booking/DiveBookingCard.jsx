import Link from "next/link";
import React from "react";

const DiveBookingCard = ({ trip }) => {
  return (
    <Link href={`dive-booking/${trip.category}`}>
      <div className="rounded-xl w-[280px] md:w-[320px] min-h-[450px] bg-white group shadow-md overflow-hidden hover:shadow-lg transition duration-300">
        <div className="relative">
          <img
            src={trip.image}
            alt={trip.title}
            className="w-full h-48 object-cover rounded-t-lg "
          />
        </div>

        <div className="px-3 md:px-5 py-3">
          <h2 className="font-medium text-xl text-gray-700">{trip.title}</h2>
          <p className="text-gray-600 mt-2">{trip.description}</p>
        </div>
        <div className="flex items-center justify-center mb-10 mt-5 ">
          <p className="text-primary font-semibold text-lg   p-2 ">Book Now</p>
        </div>
      </div>
    </Link>
  );
};

export default DiveBookingCard;
