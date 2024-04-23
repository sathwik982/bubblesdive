"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import React from "react";

const DetailMyTripBooking = () => {
  const { isDarkMode } = useThemeContext();
  const trip = {
    title: "Diving Trip",
    image:
      "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/e6/68/e66895efa2e7543ee762a6e045cf97b8.webp",
    locations: "Kubbar Island",

    price: 55,
    description: `
    Join us on an unforgettable diving adventure! Our diving trip takes you to the most breathtaking underwater destinations, where you'll encounter vibrant coral reefs, diverse marine life, and stunning underwater landscapes. Dive into crystal-clear waters teeming with tropical fish, explore memderizing underwater caves, and swim alongside majestic sea turtles. 
    Our experienced guides will lead you on exhilarating dives, ensuring your safety while providing expert knowledge about the marine ecosystems you'll explore. Whether you're a seasoned diver or new to the underwater world, our diving trip offers something for everyone.
    Highlights of the trip include:
    - Guided dives at renowned dive sites
    - Opportunities for underwater photography
    - Relaxing surface intervals on pristine beaches
    - Delicious meals featuring local cuisine
    - Evening entertainment and social gatherings
    Don't miss out on this incredible diving experience! Book your spot now and embark on the adventure of a lifetime.`,
  };

  const bookingDetails = {
    name: "Anirudh Kille",
    email: "anirudh@gmail.com",
    phoneNumber: "+91-9876543210",
    selectedRoom: "lower deck shared",
    shoeSize: "9",
    tShirtSize: "L",
    passportNumber: "ABCD123456",
    startDate: "April 24, 2023",
    endDate: "April 24, 2023",
    bookingDate: "April 20, 2023",
  };

  return (
    <div
      className={`min-h-screen pb-20 ${
        isDarkMode ? "bg-gray-900" : "bg-white"
      } `}
    >
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

      <div className="px-3 md:px-5">
        <div className="flex flex-col gap-5 md:gap-10 max-w-[1200px] mx-auto mt-5 ">
          <div className="flex gap-3 flex-col">
            <h3
              className={`font-semibold text-lg md:text-xl lg:text-2xl  ${
                isDarkMode ? "text-blue-700" : "text-primary"
              }`}
            >
              Included:
            </h3>
            <p
              className={`px-1 ${
                isDarkMode ? "text-gray-400" : "text-gray-700"
              }`}
            >
              All the trips include snacks (sandwiches) and drinks (hot and
              cold).
            </p>
          </div>

          <div className="flex items-center gap-x-10 md:gap-x-20 gap-y-5 md:gap-y-10 flex-wrap">
            <div
              className="flex gap-5 
        flex-wrap items-center"
            >
              <h3
                className={`font-semibold text-lg md:text-xl lg:text-2xl  ${
                  isDarkMode ? "text-blue-700" : "text-primary"
                }`}
              >
                Locations:
              </h3>
              <p
                className={`px-1 ${
                  isDarkMode ? "text-gray-400" : "text-gray-700"
                }`}
              >
                {trip?.locations}
              </p>
            </div>

            <div className="flex gap-5 items-center flex-wrap">
              <h3
                className={`font-semibold text-lg md:text-xl lg:text-2xl  ${
                  isDarkMode ? "text-blue-700" : "text-primary"
                }`}
              >
                Price:
              </h3>
              <p
                className={`${isDarkMode ? "text-gray-400" : "text-gray-700"} `}
              >
                {trip?.price}
              </p>
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

        <div
          className={` max-w-[1200px] mx-auto mt-10  p-5 rounded-lg shadow-lg  ${
            isDarkMode ? "bg-gray-800" : "bg-white border"
          }`}
        >
          <h3
            className={`font-semibold text-lg md:text-xl lg:text-2xl  ${
              isDarkMode ? "text-blue-700" : "text-primary"
            }`}
          >
            Order Details:
          </h3>

          <div className="flex flex-col px-5 md:px-10 py-5 gap-5">
            <div className="flex  flex-col md:flex-row md:items-center gap-5">
              <div className="flex items-center gap-x-5 gap-y-3 flex-wrap md:w-1/2">
                <h2
                  className={`${
                    isDarkMode ? "text-gray-300" : "text-gray-900"
                  } font-medium text-lg`}
                >
                  Name:
                </h2>
                <p
                  className={`${
                    isDarkMode ? "text-gray-400" : "text-gray-600"
                  } `}
                >
                  {bookingDetails.name}
                </p>
              </div>

              <div className="flex items-center gap-x-5 gap-y-3 flex-wrap md:w-1/2">
                <h2
                  className={`${
                    isDarkMode ? "text-gray-300" : "text-gray-900"
                  } font-medium text-lg`}
                >
                  Email:
                </h2>
                <p
                  className={`${
                    isDarkMode ? "text-gray-400" : "text-gray-600"
                  } `}
                >
                  {bookingDetails.email}
                </p>
              </div>
            </div>

            <div className="flex  flex-col md:flex-row md:items-center gap-5">
              <div className="flex items-center gap-x-5 gap-y-3 flex-wrap md:w-1/2">
                <h2
                  className={`${
                    isDarkMode ? "text-gray-300" : "text-gray-900"
                  } font-medium text-lg`}
                >
                  Phone No:
                </h2>
                <p
                  className={`${
                    isDarkMode ? "text-gray-400" : "text-gray-600"
                  } `}
                >
                  {bookingDetails.phoneNumber}
                </p>
              </div>

              <div className="flex items-center gap-x-5 gap-y-3 flex-wrap md:w-1/2">
                <h2
                  className={`${
                    isDarkMode ? "text-gray-300" : "text-gray-900"
                  } font-medium text-lg`}
                >
                  Room Selected:
                </h2>
                <p
                  className={`${
                    isDarkMode ? "text-gray-400" : "text-gray-600"
                  } `}
                >
                  {bookingDetails.selectedRoom}
                </p>
              </div>
            </div>

            <div className="flex  flex-col md:flex-row md:items-center gap-5">
              <div className="flex items-center gap-x-5 gap-y-3 flex-wrap md:w-1/2">
                <h2
                  className={`${
                    isDarkMode ? "text-gray-300" : "text-gray-900"
                  } font-medium text-lg`}
                >
                  T-shirt Size:
                </h2>
                <p
                  className={`${
                    isDarkMode ? "text-gray-400" : "text-gray-600"
                  } `}
                >
                  {bookingDetails.tShirtSize}
                </p>
              </div>

              <div className="flex items-center gap-x-5 gap-y-3 flex-wrap md:w-1/2">
                <h2
                  className={`${
                    isDarkMode ? "text-gray-300" : "text-gray-900"
                  } font-medium text-lg`}
                >
                  Shoe Size:
                </h2>
                <p
                  className={`${
                    isDarkMode ? "text-gray-400" : "text-gray-600"
                  } `}
                >
                  {bookingDetails.shoeSize}
                </p>
              </div>
            </div>

            <div className="flex  flex-col md:flex-row md:items-center gap-5">
              <div className="flex items-center gap-x-5 gap-y-3 flex-wrap md:w-1/2">
                <h2
                  className={`${
                    isDarkMode ? "text-gray-300" : "text-gray-900"
                  } font-medium text-lg`}
                >
                  Passport Number:
                </h2>
                <p
                  className={`${
                    isDarkMode ? "text-gray-400" : "text-gray-600"
                  } `}
                >
                  {bookingDetails.passportNumber}
                </p>
              </div>

              <div className="flex items-center gap-x-5 gap-y-3 flex-wrap md:w-1/2">
                <h2
                  className={`${
                    isDarkMode ? "text-gray-300" : "text-gray-900"
                  } font-medium text-lg`}
                >
                  Gear Needed:
                </h2>
                <p
                  className={`${
                    isDarkMode ? "text-gray-400" : "text-gray-600"
                  } `}
                >
                  No
                </p>
              </div>
            </div>

            <div className="flex  flex-col md:flex-row md:items-center gap-5">
              <div className="flex items-center gap-x-5 gap-y-3 flex-wrap md:w-1/2">
                <h2
                  className={`${
                    isDarkMode ? "text-gray-300" : "text-gray-900"
                  } font-medium text-lg`}
                >
                  Start Date:
                </h2>
                <p
                  className={`${
                    isDarkMode ? "text-gray-400" : "text-gray-600"
                  } `}
                >
                  {bookingDetails.startDate}
                </p>
              </div>

              <div className="flex items-center gap-x-5 gap-y-3 flex-wrap md:w-1/2">
                <h2
                  className={`${
                    isDarkMode ? "text-gray-300" : "text-gray-900"
                  } font-medium text-lg`}
                >
                  End Date:
                </h2>
                <p
                  className={`${
                    isDarkMode ? "text-gray-400" : "text-gray-600"
                  } `}
                >
                  {bookingDetails.endDate}
                </p>
              </div>
            </div>

            <div className="flex  flex-col md:flex-row md:items-center gap-5">
              <div className="flex items-center gap-x-5 gap-y-3 flex-wrap md:w-1/2">
                <h2
                  className={`${
                    isDarkMode ? "text-gray-300" : "text-gray-900"
                  } font-medium text-lg`}
                >
                  Booking Date:
                </h2>
                <p
                  className={`${
                    isDarkMode ? "text-gray-400" : "text-gray-600"
                  } `}
                >
                  {bookingDetails.bookingDate}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default DetailMyTripBooking;
