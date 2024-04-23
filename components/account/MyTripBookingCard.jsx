"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import { truncate } from "@/lib/trucate";
import Link from "next/link";
import React from "react";
import BreadCrumbs from "../BreadCrumbs";

const MyTripBookingCard = () => {
  const { isDarkMode } = useThemeContext();
  const orders = [
    {
      orderNumber: "1222",
      date: "April 20, 2023",
      startDate: "April 24, 2023",
      endDate: "April 24, 2023",
      totalAmt: 100,
      title: "Snorkel Trip",
      category: "local trip",
      tripId: 1,
      price: 49.99,
      image:
        "https://media.istockphoto.com/id/576724556/photo/underwater-scuba-diver-making-self-portrait-or-selfie.jpg?s=1024x1024&w=is&k=20&c=OZ9nu6PLY-bDHtnQ3hI1D-7WR07BL-BvWdv8U1lNku4=",
      quantity: 2,
    },
    {
      orderNumber: "23322",
      date: "April 10, 2023",
      startDate: "April 24, 2023",
      endDate: "May 04, 2023",
      totalAmt: 200,
      title: "Liveaboard to the red sea - Egypt",
      category: "international",
      tripId: 1,
      price: 79.99,
      quantity: 1,
      image:
        "https://media.istockphoto.com/id/157317898/photo/exotic-beach-with-parasols-and-bougainvillea-sharm-el-sheikh-egypt.jpg?s=1024x1024&w=is&k=20&c=dBIyaHkLTvGA8mQWEATJLdrQnSkba04iHwy8Yq9Ram4=",
    },
  ];
  return (
    <div className={`${isDarkMode ? "bg-gray-900" : "bg-blue-100"}`}>
      <BreadCrumbs heading={"My Trip Booking"} />
      <div className="mx-auto max-w-[1300px] pt-5 pb-10 md:pb-20 px-3 md:px-5 ">
        <>
          {orders.map((order) => (
            <div
              key={order.orderNumber}
              className="flex flex-col  py-5 md:py-10 "
            >
              <div
                className={`flex justify-between  ${
                  isDarkMode ? "bg-gray-800 border-gray-500" : "bg-white "
                } p-5 flex-wrap gap-5 border-b rounded-t-lg`}
              >
                <div className="flex flex-col gap-2">
                  <h3 className={`font-semibold ${isDarkMode && "text-white"}`}>
                    Order number
                  </h3>
                  <p
                    className={`px-1 ${
                      isDarkMode ? "text-gray-300" : "text-gray-700"
                    } font-medium`}
                  >
                    {order.orderNumber}
                  </p>
                </div>
                <div className="flex flex-col gap-2">
                  <h3 className={`font-semibold ${isDarkMode && "text-white"}`}>
                    Date placed
                  </h3>
                  <p
                    className={`px-1 ${
                      isDarkMode ? "text-gray-300" : "text-gray-700"
                    } font-medium`}
                  >
                    {order.date}
                  </p>
                </div>
                <div className="flex flex-col gap-2">
                  <h3 className={`font-semibold ${isDarkMode && "text-white"}`}>
                    Total Amount
                  </h3>
                  <p
                    className={`px-1 ${
                      isDarkMode ? "text-gray-300" : "text-gray-700"
                    } font-medium`}
                  >
                    KD {order.totalAmt}
                  </p>
                </div>
              </div>

              <div
                className={`${
                  isDarkMode ? "bg-gray-800" : "bg-white"
                } rounded-b-lg`}
              >
                <Link
                  href={`/account/travel-booking/${order.orderNumber}`}
                  key={order.title}
                  className={`flex gap-5 py-3 px-5  ${
                    !isDarkMode && "border-b"
                  } flex-wrap `}
                >
                  <img
                    src={order.image}
                    alt={order.title}
                    className="h-48 w-48 object-cover "
                  />
                  <div className="p-4 ">
                    <h2
                      className={`text-lg font-semibold mb-2 ${
                        isDarkMode && "text-white"
                      }`}
                    >
                      {order.title}
                    </h2>

                    <div
                      className={`${
                        isDarkMode ? "text-gray-400" : "text-gray-500"
                      } mb-2 font-medium `}
                    >
                      <p>{order.category}</p>
                    </div>

                    <div
                      className={`${
                        isDarkMode ? "text-gray-400" : "text-gray-500"
                      } mb-2 font-medium  `}
                    >
                      <p>
                        {order.startDate} - {order.endDate}
                      </p>
                    </div>

                    <p
                      className={`${
                        isDarkMode ? "text-blue-700" : "text-primary"
                      }  mb-2 font-semibold`}
                    >
                      KD {order.price.toFixed(2)}
                    </p>

                    <div
                      className={`${
                        isDarkMode ? "text-gray-400" : "text-gray-500"
                      } mb-2 font-medium `}
                    >
                      <p>Quantity: {order.quantity}</p>
                    </div>
                  </div>
                </Link>
              </div>
            </div>
          ))}
        </>
      </div>
    </div>
  );
};

export default MyTripBookingCard;
