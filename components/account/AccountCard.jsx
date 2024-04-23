"use client";
import Image from "next/image";
import React from "react";
import {
  MdModeEdit,
  MdEmail,
  MdLocalPhone,
  MdShoppingCart,
  MdOutlineScubaDiving,
} from "react-icons/md";
import bg from "../../lib/assets/home/home-1.jpg";
import { IoBagHandleSharp, IoLogOut } from "react-icons/io5";
import Link from "next/link";
import { useThemeContext } from "@/hooks/ThemeContext";

const AccountCard = () => {
  const { isDarkMode } = useThemeContext();
  return (
    <>
      <div className="w-full h-20 lg:h-[6.5rem] bg-primary"></div>
      <div
        className={`min-h-screen ${isDarkMode ? "bg-gray-900" : "bg-white"}`}
      >
        <div className="max-w-[1300px] mx-auto py-10 px-3 md:px-5">
          <div className="w-full pt-3 min-h-screen relative ">
            <div
              className={`${
                isDarkMode ? "bg-gray-800" : "bg-white"
              }  flex justify-center items-center flex-col mx-auto  rounded-lg shadow-xl relative`}
            >
              <Image
                src={bg}
                className="w-full object-cover h-[150px] rounded-t-lg"
              />
              <div
                className={`absolute top-[80px] ${
                  isDarkMode ? "bg-gray-700" : "bg-white"
                } rounded-full`}
              >
                <Image
                  src={bg}
                  className={`rounded-full object-cover object-center size-28  ${
                    isDarkMode ? "text-gray-300" : "text-gray-500"
                  }`}
                />
              </div>
              <div className="mt-12 text-center w-full">
                <h2
                  className={`${
                    isDarkMode && "text-gray-300"
                  } text-xl font-semibold mt-2`}
                >
                  Anirudh Kille
                </h2>
                <div
                  className={`${
                    isDarkMode ? "text-gray-400" : " text-gray-600 "
                  } flex justify-center items-center gap-2 mt-1`}
                >
                  <MdEmail />
                  <p>example@example.com</p>
                </div>
                <div
                  className={`${
                    isDarkMode ? "text-gray-400" : " text-gray-600 "
                  } flex justify-center items-center gap-2 mt-1`}
                >
                  <MdLocalPhone />
                  <p>+1234567890</p>
                </div>

                <>
                  <div className="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-5 md:grid-cols-3  mb-20">
                    <Link
                      href={"/account/edit-profile"}
                      className={`${
                        isDarkMode
                          ? "text-gray-400 hover:bg-gray-700 hover:text-white"
                          : "text-gray-700 hover:bg-sky-100 hover:text-primary"
                      } flex w-full shadow-sm  py-2 gap-5 0  px-10 md:px-16 lg:px-20`}
                    >
                      <MdModeEdit size={24} />
                      <p className="font-medium ">Edit Details</p>
                    </Link>

                    <Link
                      href={"/account/orders"}
                      className={`${
                        isDarkMode
                          ? "text-gray-400 hover:bg-gray-700 hover:text-white"
                          : "text-gray-700 hover:bg-sky-100 hover:text-primary"
                      } flex w-full shadow-sm  py-2 gap-5 0  px-10 md:px-16 lg:px-20`}
                    >
                      <IoBagHandleSharp size={24} />
                      <p className="font-medium ">My orders</p>
                    </Link>

                    <Link
                      href={"/cart"}
                      className={`${
                        isDarkMode
                          ? "text-gray-400 hover:bg-gray-700 hover:text-white"
                          : "text-gray-700 hover:bg-sky-100 hover:text-primary"
                      } flex w-full shadow-sm  py-2 gap-5 0  px-10 md:px-16 lg:px-20`}
                    >
                      <MdShoppingCart size={24} />
                      <p className="font-medium ">Cart</p>
                    </Link>

                    <Link
                      href={"/account/travel-booking"}
                      className={`${
                        isDarkMode
                          ? "text-gray-400 hover:bg-gray-700 hover:text-white"
                          : "text-gray-700 hover:bg-sky-100 hover:text-primary"
                      } flex w-full shadow-sm  py-2 gap-5 0  px-10 md:px-16 lg:px-20`}
                    >
                      <MdOutlineScubaDiving size={24} />
                      <p className="font-medium ">Trip Booking</p>
                    </Link>

                    <Link
                      href={"/auth"}
                      className={`${
                        isDarkMode
                          ? "text-gray-400 hover:bg-gray-700 hover:text-white"
                          : "text-gray-700 hover:bg-sky-100 hover:text-primary"
                      } flex w-full shadow-sm  py-2 gap-5 0  px-10 md:px-16 lg:px-20`}
                    >
                      <IoLogOut size={24} />
                      <p className="font-medium ">Logout</p>
                    </Link>
                  </div>
                </>
              </div>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};

export default AccountCard;
