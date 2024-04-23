"use client";
import React, { useState } from "react";
import { MdEmail, MdPhone, MdLocationPin } from "react-icons/md";
import Link from "next/link";
import { useThemeContext } from "@/hooks/ThemeContext";
import BreadCrumbs from "../BreadCrumbs";

const ContactUsCard = () => {
  const { isDarkMode } = useThemeContext();
  const contactMethods = [
    {
      icon: <MdEmail size={24} />,
      contact: "info@bubblesdivingcenter.com",
      href: "mailto:info@bubblesdivingcenter.com",
    },
    {
      icon: <MdPhone size={24} />,
      contact: "+965 9998 9030",
      href: "tel:+965 9998 9030",
    },
    {
      icon: <MdLocationPin size={24} />,
      contact:
        "Ilmunz Marine Co, Shuwaikh Industrial Area, Ghaneema Fahad Almarzouk Complex, Building 250, St, 70050 Shuwaikh Industrial, Kuwait",
      href: "https://www.google.com/maps/place/Ilmunz+Marine/@29.3211851,47.936282,18z/data=!4m6!3m5!1s0x3fcf9ab6b35f3647:0xc3616984630adafb!8m2!3d29.3211828!4d47.9354612!16s%2Fg%2F11c0wc2995?entry=ttu",
    },
  ];

  const [formData, setFormData] = useState({
    name: "",
    email: "",
    message: "",
    phone: "",
  });
  const [errors, setErrors] = useState({
    nameError: "",
    emailError: "",
    messageError: "",
    phoneError: "",
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    let newErrors = {};

    // Validate name
    if (!formData.name.trim()) {
      newErrors = { ...newErrors, nameError: "Name is required" };
    } else {
      newErrors = { ...newErrors, nameError: "" };
    }

    // Validate email
    if (!formData.email.trim()) {
      newErrors = { ...newErrors, emailError: "Email is required" };
    } else {
      newErrors = { ...newErrors, emailError: "" };
    }

    // Validate message
    if (!formData.message.trim()) {
      newErrors = { ...newErrors, messageError: "Message is required" };
    } else {
      newErrors = { ...newErrors, messageError: "" };
    }

    // Validate phone
    if (!formData.phone.trim()) {
      newErrors = { ...newErrors, phoneError: "Phone is required" };
    } else {
      newErrors = { ...newErrors, phoneError: "" };
    }

    setErrors(newErrors);

    // If no errors, submit the form
    if (Object.values(newErrors).every((error) => !error)) {
      // Handle form submission
      console.log("Form submitted:", formData);
    }
  };

  return (
    <div className={`min-h-screen ${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
      <BreadCrumbs heading={"Contact Us"} />
      <div className="min-h-screen w-full  max-w-[1300px] mx-auto py-10">
        <div
          className={`max-w-[1200px] mx-auto px-3 ${
            isDarkMode ? "text-gray-400" : "text-gray-600"
          } md:px-8`}
        >
          <div className="max-w-lg mx-auto gap-10 justify-between lg:flex lg:max-w-none">
            <div className="max-w-lg space-y-3">
              <p
                className={`text-3xl font-semibold sm:text-4xl ${
                  isDarkMode ? "text-blue-700" : "text-primary"
                }`}
              >
                Let us know how we can help
              </p>
              <p>
                We&apos;re here to help and answer any questions you might have.
                We look forward to hearing from you! Please fill out the form or
                use the contact information below.
              </p>
              <div>
                <div className="mt-6 flex flex-wrap gap-x-10 gap-y-6 items-center">
                  {contactMethods.map((item, idx) => (
                    <Link
                      href={item.href}
                      key={idx}
                      className={`flex items-center gap-x-3 ${
                        isDarkMode
                          ? "hover:text-blue-700"
                          : "hover:text-primary"
                      } group`}
                    >
                      <div
                        className={` ${
                          isDarkMode ? "text-blue-700" : "text-primary"
                        }`}
                      >
                        {item.icon}
                      </div>
                      <p
                        className={`${
                          isDarkMode
                            ? "text-gray-400 group-hover:text-blue-700"
                            : "text-gray-600 group-hover:text-primary"
                        }`}
                      >
                        {item.contact}
                      </p>
                    </Link>
                  ))}
                </div>
              </div>
            </div>
            <div
              className={`flex-1 mt-12 sm:max-w-lg ${
                isDarkMode ? "bg-gray-800" : "border bg-white border-gray-200"
              } rounded-lg p-5 md:p-8 shadow-lg `}
            >
              <form onSubmit={handleSubmit} className="space-y-5">
                <div>
                  <label
                    className={`font-medium ${
                      isDarkMode ? "text-blue-700" : "text-primary "
                    }`}
                  >
                    Full name
                  </label>
                  <input
                    type="text"
                    value={formData.name}
                    onChange={(e) =>
                      setFormData({ ...formData, name: e.target.value })
                    }
                    className={`w-full mt-2 px-3 py-2 ${
                      isDarkMode
                        ? "text-gray-300 focus:border-blue-700"
                        : "text-gray-500 focus:border-primary border-gray-400"
                    } bg-transparent outline-none border shadow-sm rounded-lg ${
                      errors.nameError && "border-red-500"
                    }`}
                  />
                  {errors.nameError && (
                    <p className="text-red-500">{errors.nameError}</p>
                  )}
                </div>
                <div>
                  <label
                    className={`font-medium ${
                      isDarkMode ? "text-blue-700" : "text-primary"
                    }`}
                  >
                    Email
                  </label>
                  <input
                    type="email"
                    value={formData.email}
                    onChange={(e) =>
                      setFormData({ ...formData, email: e.target.value })
                    }
                    className={`w-full mt-2 px-3 py-2 ${
                      isDarkMode
                        ? "text-gray-300 focus:border-blue-700"
                        : "text-gray-500 focus:border-primary border-gray-400"
                    } bg-transparent outline-none border shadow-sm rounded-lg ${
                      errors.emailError && "border-red-500"
                    }`}
                  />
                  {errors.emailError && (
                    <p className="text-red-500">{errors.emailError}</p>
                  )}
                </div>
                <div>
                  <label
                    className={`font-medium ${
                      isDarkMode ? "text-blue-700" : "text-primary"
                    }`}
                  >
                    Phone
                  </label>
                  <input
                    type="text"
                    value={formData.phone}
                    onChange={(e) =>
                      setFormData({ ...formData, phone: e.target.value })
                    }
                    className={`w-full mt-2 px-3 py-2 ${
                      isDarkMode
                        ? "text-gray-300 focus:border-blue-700"
                        : "text-gray-500 focus:border-primary border-gray-400"
                    } bg-transparent outline-none border shadow-sm rounded-lg ${
                      errors.phoneError && "border-red-500"
                    }`}
                  />
                  {errors.phoneError && (
                    <p className="text-red-500">{errors.phoneError}</p>
                  )}
                </div>
                <div>
                  <label
                    className={`font-medium ${
                      isDarkMode ? "text-blue-700" : "text-primary"
                    }`}
                  >
                    Message
                  </label>
                  <textarea
                    value={formData.message}
                    onChange={(e) =>
                      setFormData({ ...formData, message: e.target.value })
                    }
                    className={`w-full mt-2 h-36 px-3 py-2 resize-none appearance-none bg-transparent outline-none border ${
                      isDarkMode
                        ? "text-gray-300 focus:border-blue-700"
                        : "text-gray-500 focus:border-primary border-gray-400"
                    } shadow-sm rounded-lg ${
                      errors.messageError && "border-red-500"
                    }`}
                  ></textarea>
                  {errors.messageError && (
                    <p className="text-red-500">{errors.messageError}</p>
                  )}
                </div>
                <button
                  className={`w-full px-5 py-3 text-white font-medium ${
                    isDarkMode ? "bg-blue-700" : "bg-primary"
                  } hover:bg-opacity-90 active:bg-primary rounded-lg duration-150`}
                >
                  Submit
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ContactUsCard;
