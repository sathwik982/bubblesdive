"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import { useCourseContext } from "../../hooks/CourseContext";
import React, { useState } from "react";

const CourseBooking = ({ course }) => {
  const { addCourseToCart } = useCourseContext();
  const { isDarkMode } = useThemeContext();
  const [formData, setFormData] = useState({
    fullName: "",
    email: "",
    phoneNumber: "",
    language: "English",
    diverStatus: "Padi",
    passportNumber: "",
    certificationNumber: "",
    certificationDocument: null, // Store file object in state
  });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({ ...formData, [name]: value });
  };

  const handleFileChange = (e) => {
    const file = e.target.files[0]; // Get the first selected file
    setFormData({ ...formData, certificationDocument: file });
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    addCourseToCart({ ...course.course, formData });
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
          Course Booking
        </h2>
        <form className="mt-5 md:mt-8 lg:mt-10 px-5 md:px-8 lg:px-10 flex flex-col gap-5">
          <div className="w-full flex items-center gap-5 sm:gap-10 flex-col sm:flex-row">
            <div className="flex flex-col gap-1 flex-1 w-full">
              <label
                htmlFor="name"
                className={`font-medium ${
                  isDarkMode ? "text-blue-700" : " text-primary"
                } `}
              >
                Full Name:
              </label>
              <input
                type="text"
                id="name"
                name="fullName"
                className={` ${
                  isDarkMode ? "courseBookingInputDark" : "courseBookingInput"
                } `}
                placeholder="Enter the Full Name"
                value={formData.fullName}
                onChange={handleChange}
              />
            </div>

            <div className="flex flex-col gap-1 flex-1 w-full">
              <label
                htmlFor="name"
                className={`font-medium ${
                  isDarkMode ? "text-blue-700" : " text-primary"
                } `}
              >
                Email:
              </label>
              <input
                type="email"
                id="email"
                name="email"
                className={` ${
                  isDarkMode ? "courseBookingInputDark" : "courseBookingInput"
                }`}
                placeholder="Enter the Email"
                value={formData.email}
                onChange={handleChange}
              />
            </div>
          </div>

          <div className="w-full flex items-center gap-5 sm:gap-10 flex-col sm:flex-row">
            <div className="flex flex-col gap-1 flex-1 w-full">
              <label
                htmlFor="phno"
                className={`font-medium ${
                  isDarkMode ? "text-blue-700" : " text-primary"
                }`}
              >
                Phone Number:
              </label>
              <input
                type="text"
                id="phno"
                name="phoneNumber"
                className={` ${
                  isDarkMode ? "courseBookingInputDark" : "courseBookingInput"
                } `}
                placeholder="Enter the Phone No."
                value={formData.phoneNumber}
                onChange={handleChange}
              />
            </div>

            <div className="flex flex-col gap-1 sm:flex-1 w-full">
              <label
                htmlFor="diverStatus"
                className={`font-medium ${
                  isDarkMode ? "text-blue-700" : " text-primary"
                }`}
              >
                Diver Status:
              </label>
              <select
                id="diverStatus"
                name="diverStatus"
                className={` ${
                  isDarkMode ? "courseBookingInputDark" : "courseBookingInput"
                }`}
                value={formData.diverStatus}
                onChange={handleChange}
              >
                <option className={`${isDarkMode && "bg-gray-800"}`}>
                  PADI
                </option>
                <option className={`${isDarkMode && "bg-gray-800"}`}>
                  Non-PADI
                </option>
              </select>
            </div>
          </div>

          <div className="flex items-center gap-5 sm:gap-10 flex-wrap">
            <div className="flex flex-col gap-1 sm:flex-1 w-full">
              <label
                htmlFor="language"
                className={`font-medium ${
                  isDarkMode ? "text-blue-700" : " text-primary"
                }`}
              >
                Preferable Language:
              </label>
              <select
                id="language"
                name="language"
                className={` ${
                  isDarkMode ? "courseBookingInputDark" : "courseBookingInput"
                }`}
                value={formData.language}
                onChange={handleChange}
              >
                <option className={`${isDarkMode && "bg-gray-800"}`}>
                  English
                </option>
                <option className={`${isDarkMode && "bg-gray-800"}`}>
                  Arabic
                </option>
              </select>
            </div>

            <div className="flex flex-col gap-1 flex-1 w-full">
              <label
                htmlFor="passportNumber"
                className={`font-medium ${
                  isDarkMode ? "text-blue-700" : " text-primary"
                }`}
              >
                Passport Number:
              </label>
              <input
                type="text"
                id="passportNumber"
                name="passportNumber"
                className={` ${
                  isDarkMode ? "courseBookingInputDark" : "courseBookingInput"
                } `}
                placeholder="Enter the Passport No."
                value={formData.passportNumber}
                onChange={handleChange}
              />
            </div>
          </div>

          <div className="flex items-center gap-5 sm:gap-10 flex-wrap">
            <div className="flex flex-col gap-1 flex-1 w-full">
              <label
                htmlFor="certificationNumber"
                className={`font-medium ${
                  isDarkMode ? "text-blue-700" : " text-primary"
                }`}
              >
                Padi Certification Number:
              </label>
              <input
                type="text"
                id="certificationNumber"
                name="certificationNumber"
                className={` ${
                  isDarkMode ? "courseBookingInputDark" : "courseBookingInput"
                } `}
                placeholder="Enter the Padi Certification No."
                value={formData.certificationNumber}
                onChange={handleChange}
              />
            </div>

            <div className="flex flex-col gap-1 flex-1 w-full">
              <label
                htmlFor="certificationDocument"
                className={`font-medium ${
                  isDarkMode ? "text-blue-700" : " text-primary"
                }`}
              >
                Certification Document:
              </label>
              <input
                type="file"
                id="certificationDocument"
                name="certificationDocument"
                onChange={handleFileChange}
                className={` ${
                  isDarkMode ? "courseBookingInputDark" : "courseBookingInput"
                } `}
                placeholder="Enter the Passport Number"
              />
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

export default CourseBooking;
