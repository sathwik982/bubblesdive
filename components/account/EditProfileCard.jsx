"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import { useRouter } from "next/navigation";
import React, { useState } from "react";
import BreadCrumbs from "../BreadCrumbs";

const EditProfileCard = () => {
  const { isDarkMode } = useThemeContext();
  const router = useRouter();
  const [selectedFile, setSelectedFile] = useState(null);
  const [previewUrl, setPreviewUrl] = useState(null);

  const handleFileChange = (event) => {
    const file = event.target.files[0];
    setSelectedFile(file);
    if (file) {
      const reader = new FileReader();
      reader.onloadend = () => {
        setPreviewUrl(reader.result);
      };
      reader.readAsDataURL(file);
    }
  };

  return (
    <div className={`${isDarkMode ? "bg-gray-900" : "bg-blue-50"}`}>
      <BreadCrumbs heading={"Edit Profile"} />
      <div className="max-w-[1300px] mx-auto px-3 md:px-5 py-10 ">
        <div
          className={`shadow-lg  rounded-lg max-w-[600px] flex flex-col gap-5 mx-auto px-2 py-5 md:px-5 ${
            isDarkMode ? "bg-gray-800" : "bg-white border"
          }`}
        >
          <label className="cursor-pointer w-fit mx-auto">
            <input
              type="file"
              accept="image/*"
              className="hidden"
              onChange={handleFileChange}
            />
            <div
              className={` overflow-hidden h-40 w-40 rounded-full mx-auto ${
                isDarkMode ? "bg-gray-700" : "bg-gray-200 border"
              } flex items-center justify-center`}
            >
              {previewUrl ? (
                <img
                  src={previewUrl}
                  alt="Profile Preview"
                  className="h-full w-full object-cover rounded-full"
                />
              ) : (
                <span className="text-gray-600">Select Profile Photo</span>
              )}
            </div>
          </label>

          <div className="mx-3 flex flex-col gap-5">
            <input
              type="text"
              placeholder="Name"
              className={`${
                isDarkMode
                  ? "bg-gray-700 focus:border-blue-700 text-gray-300"
                  : "bg-white border focus:border-primary"
              }  px-5 py-3 rounded-md  focus:outline-none`}
            />
            <input
              type="email"
              placeholder="Email"
              className={`${
                isDarkMode
                  ? "bg-gray-700 focus:border-blue-700 text-gray-300"
                  : "bg-white border focus:border-primary"
              }   px-5 py-3 rounded-md  focus:outline-none`}
            />
            <input
              type="tel"
              placeholder="Phone"
              className={`${
                isDarkMode
                  ? "bg-gray-700 focus:border-blue-700 text-gray-300"
                  : "bg-white border focus:border-primary"
              }   px-5 py-3 rounded-md  focus:outline-none`}
            />
            <input
              type="text"
              placeholder="Password"
              className={`${
                isDarkMode
                  ? "bg-gray-700 focus:border-blue-700 text-gray-300"
                  : "bg-white border focus:border-primary"
              }   px-5 py-3 rounded-md  focus:outline-none`}
            />

            <div className="flex items-center gap-5 flex-wrap justify-center">
              <button
                className="px-5 py-3 text-white rounded-md bg-red-700 hover:bg-red-800"
                onClick={() => router.push("/account")}
              >
                Cancel
              </button>
              <button
                className={`px-5 py-3 text-white rounded-md ${
                  isDarkMode ? "bg-blue-700" : "bg-primary"
                } `}
              >
                Save
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default EditProfileCard;
