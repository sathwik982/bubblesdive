"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import { useTripContext } from "@/hooks/TripContext";
import React, { useState } from "react";

const DiveBookingForm = ({ trip }) => {
  const { isDarkMode } = useThemeContext();
  const { addTripToCart } = useTripContext();
  const [formData, setFormData] = useState({
    fullName: "",
    email: "",
    phoneNumber: "",
    tShirtSize: "",
    shoeSize: "",
    passportNumber: "",
    certificationNumber: "",
    certificationDocument: null,
    gearNeeded: "yes",
  });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleFileChange = (e) => {
    const file = e.target.files[0];
    setFormData({ ...formData, certificationDocument: file });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    addTripToCart({ ...trip, formData });
  };

  return (
    <div className="px-3 sm:px-5">
      <div
        className={`${
          isDarkMode ? " bg-gray-800" : "bg-white border"
        } rounded-lg pb-5 md:pb-10  shadow-lg max-w-[1100px] mx-auto`}
      >
        <h2
          className={`font-semibold text-left px-5 py-3 text-2xl  border-b ${
            isDarkMode ? "text-blue-700" : "text-primary"
          }`}
        >
          Dive Booking
        </h2>
        <form className="mt-5 md:mt-8 lg:mt-10 px-5 md:px-8 lg:px-10 flex flex-col gap-5">
          <div className="w-full flex items-center gap-5 sm:gap-10 flex-col sm:flex-row">
            <div className="flex flex-col gap-1 flex-1 w-full">
              <label
                htmlFor="name"
                className={`font-medium ${
                  isDarkMode ? "text-blue-700" : "text-primary "
                }`}
              >
                Full Name:
              </label>
              <input
                type="text"
                id="name"
                name="fullName"
                value={formData.fullName}
                onChange={handleChange}
                className={` ${
                  isDarkMode ? "courseBookingInputDark" : "courseBookingInput"
                } `}
                placeholder="Enter the Full Name"
              />
            </div>

            <div className="flex flex-col gap-1 flex-1 w-full">
              <label
                htmlFor="email"
                className={`font-medium ${
                  isDarkMode ? "text-blue-700" : "text-primary "
                }`}
              >
                Email:
              </label>
              <input
                type="email"
                id="email"
                name="email"
                value={formData.email}
                onChange={handleChange}
                className={`${
                  isDarkMode ? "courseBookingInputDark" : "courseBookingInput"
                }`}
                placeholder="Enter the Full Name"
              />
            </div>
          </div>

          <div className="w-full flex items-center gap-5 sm:gap-10 flex-col sm:flex-row">
            <div className="flex flex-col gap-1 flex-1 w-full">
              <label
                htmlFor="tShirtSize"
                className={`font-medium ${
                  isDarkMode ? "text-blue-700" : "text-primary "
                }`}
              >
                T-Shirt Size:
              </label>
              <select
                id="tShirtSize"
                className={`${
                  isDarkMode ? "courseBookingInputDark" : "courseBookingInput"
                }`}
                name="tShirtSize"
                value={formData.tShirtSize}
                onChange={handleChange}
              >
                <option className={`${isDarkMode && "bg-gray-800"}`}>XS</option>
                <option className={`${isDarkMode && "bg-gray-800"}`}>S</option>
                <option className={`${isDarkMode && "bg-gray-800"}`}>M</option>
                <option className={`${isDarkMode && "bg-gray-800"}`}>ML</option>
                <option className={`${isDarkMode && "bg-gray-800"}`}>L</option>
                <option className={`${isDarkMode && "bg-gray-800"}`}>XL</option>
              </select>
            </div>

            <div className="flex flex-col gap-1 flex-1 w-full">
              <label
                htmlFor="shoeSize"
                className={`font-medium ${
                  isDarkMode ? "text-blue-700" : "text-primary "
                }`}
              >
                Shoe Size:
              </label>
              <input
                id="shoeSize"
                className={`${
                  isDarkMode ? "courseBookingInputDark" : "courseBookingInput"
                }`}
                name="shoeSize"
                placeholder="Enter the Shoe Size"
                value={formData.shoeSize}
                onChange={handleChange}
              />
            </div>
          </div>

          <div className="w-full flex items-center gap-5 sm:gap-10 flex-col sm:flex-row">
            <div className="flex flex-col gap-1 flex-1 w-full">
              <label
                htmlFor="passportNo"
                className={`font-medium ${
                  isDarkMode ? "text-blue-700" : "text-primary "
                }`}
              >
                Passport Number:
              </label>
              <input
                type="text"
                id="passportNo"
                name="passportNumber"
                value={formData.passportNumber}
                onChange={handleChange}
                className={`${
                  isDarkMode ? "courseBookingInputDark" : "courseBookingInput"
                }`}
                placeholder="Enter the Passport Number"
              />
            </div>

            <div className="flex flex-col gap-1 flex-1 w-full">
              <label
                htmlFor="padiNumber"
                className={`font-medium ${
                  isDarkMode ? "text-blue-700" : "text-primary "
                }`}
              >
                Padi Certification No:
              </label>
              <input
                type="tel"
                id="padiNumber"
                name="certificationNumber"
                value={formData.certificationNumber}
                onChange={handleChange}
                className={`${
                  isDarkMode ? "courseBookingInputDark" : "courseBookingInput"
                } `}
                placeholder="Enter the  Padi Certification Number"
              />
            </div>
          </div>

          <div className="w-full flex items-center gap-5 md:gap-10 flex-col md:flex-row">
            <div className="flex flex-col gap-1 flex-1 w-full">
              <label
                htmlFor="certificationDocument"
                className={`font-medium ${
                  isDarkMode ? "text-blue-700" : "text-primary "
                }`}
              >
                Cetification Document:
              </label>
              <input
                type="file"
                id="certificationDocument"
                name="certificationNumber"
                onChange={handleFileChange}
                className={`${
                  isDarkMode ? "courseBookingInputDark" : "courseBookingInput"
                }`}
                placeholder="Enter the Passport Number"
              />
            </div>

            <div className="flex flex-col gap-1 flex-1 w-full">
              <label
                htmlFor="certificationDocument"
                className={`font-medium ${
                  isDarkMode ? "text-blue-700" : "text-primary "
                }`}
              >
                Do you need Gear? <span className="font-normal text-gray-500 text-sm px-3">
                BCD and Regulator
              </span>
              </label>
             
              <select
                className={`${
                  isDarkMode ? "courseBookingInputDark" : "courseBookingInput"
                } `}
                value={formData.gearNeeded}
                name="gearNeeded"
                onChange={handleChange}
              >
                <option className={`${isDarkMode && "bg-gray-800"}`}>
                  Yes
                </option>
                <option className={`${isDarkMode && "bg-gray-800"}`}>No</option>
              </select>
            </div>
          </div>

          <div className="flex items-center justify-center">
            <button
              className={`px-3 py-3 rounded-lg  shadow-md md:w-80 text-white hover:bg-gray-700 ${
                isDarkMode ? "bg-blue-700" : "bg-primary"
              }`}
              type="submit"
              onClick={handleSubmit}
            >
              Add to Cart
            </button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default DiveBookingForm;
