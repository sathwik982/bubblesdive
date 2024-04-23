"use client";
import React, { useEffect, useRef, useState } from "react";
import Image from "next/image";
import Link from "next/link";
import logo from "../lib/assets/logo.svg";
import { usePathname } from "next/navigation";
import { FaFacebook, FaShoppingCart } from "react-icons/fa";
import { MdLocationOn, MdLocalPhone } from "react-icons/md";
import { RiInstagramFill } from "react-icons/ri";
import { IoMenu, IoClose, IoPerson } from "react-icons/io5";
import { useLanguageContext } from "@/hooks/LanguageContext";
import { FaWhatsapp } from "react-icons/fa6";
import { BsMoonStarsFill, BsFillSunFill } from "react-icons/bs";
import { useThemeContext } from "@/hooks/ThemeContext";

const Header = () => {
  const { isDarkMode, toggleMode } = useThemeContext();
  const pathName = usePathname();
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [scrolling, setScrolling] = useState(false);
  const { changeLanguage, selectedLanguage } = useLanguageContext();
  const menuRef = useRef(null);

  useEffect(() => {
    const handleScroll = () => {
      if (window.scrollY > 190) {
        setScrolling(true);
      } else {
        setScrolling(false);
      }
    };
    window.addEventListener("scroll", handleScroll);
    return () => {
      window.removeEventListener("scroll", handleScroll);
    };
  }, []);

  useEffect(() => {
    const closeSidebar = () => {
      setIsMenuOpen(false);
    };

    const handleClickOutside = (event) => {
      if (menuRef.current && !menuRef.current.contains(event.target)) {
        closeSidebar();
      }
    };

    document.addEventListener("click", handleClickOutside);

    return () => {
      document.removeEventListener("click", handleClickOutside);
    };
  }, [isMenuOpen]);

  if (pathName !== "/auth")
    return (
      <>
        {/* First Section */}
        <div className="hidden lg:block bg-transparent absolute z-[300] text-white  w-full  px-5 border-b ">
          <div className="w-full lg:flex text-overflow-hidden  justify-between items-center gap-6 max-w-[1400px] mx-auto py-2 px-5 ">
            <div className="flex items-center gap-5">
              <Link
                target="_blank"
                href={"https://www.facebook.com/bubblesdivingkuwait/"}
                className=""
              >
                <FaFacebook size={22} />
              </Link>
              <Link
                target="_blank"
                href={"https://www.instagram.com/bubblesdiving/"}
                className=""
              >
                <RiInstagramFill size={22} />
              </Link>
              <Link
                target="_blank"
                href={"https://wa.me/96599989030"}
                className="font-medium text-white"
              >
                <FaWhatsapp size={22} />
              </Link>
              <Link
                target="_blank"
                href={
                  "https://www.google.com/maps/place/Ilmunz+Marine/@29.3211851,47.936282,18z/data=!4m6!3m5!1s0x3fcf9ab6b35f3647:0xc3616984630adafb!8m2!3d29.3211828!4d47.9354612!16s%2Fg%2F11c0wc2995?entry=ttu"
                }
                className=""
              >
                <MdLocationOn size={24} />
              </Link>
              <Link target="_blank" href={"tel:+965 9998 9030"} className="">
                <MdLocalPhone size={22} />
              </Link>
            </div>

            <div className="flex items-center gap-5">
              <Link href={"/account"} className=" ">
                <IoPerson size={20} />
              </Link>
              <Link href={"/cart"} className="">
                <FaShoppingCart size={20} />
              </Link>
              <select
                className="outline-none font-medium bg-transparent px-1"
                value={selectedLanguage}
                onChange={(e) => {
                  const selectedLanguage = e.target.value;
                  changeLanguage(selectedLanguage);
                }}
              >
                <option
                  className="px-3 text-sm bg-transparent text-primary"
                  value="english"
                >
                  English
                </option>
                <option
                  className="px-3 text-sm bg-transparent text-primary"
                  value="arabic"
                >
                  Arabic
                </option>
              </select>
            </div>
          </div>
        </div>

        {/* Second Section */}
        <div
          className={`absolute  w-full px-3 sm:px-5 lg:block  text-white text-[16px] bg-primary z-[300] ${
            scrolling
              ? "bg-primary  shadow-md top-0 sticky "
              : "bg-transparent lg:top-10"
          }`}
        >
          <div className="flex items-center lg:justify-between sm:px-2 w-full max-w-[1500px] mx-auto">
            <Link href={"/"}>
              <Image
                src={logo}
                alt="Logo"
                className="h-16 w-36 md:h-18  md:w-44 object-contain"
              />
            </Link>
            <nav className="hidden text-base lg:flex items-center justify-end px-5 gap-6">
              <Link
                href="/"
                className="hover:scale-105 w-fit hover:font-semibold font-medium"
              >
                Home
              </Link>
              <div className="relative">
                <div className="hover:font-semibold font-medium group ">
                  <Link href="/courses">Courses</Link>

                  <div className="submenu absolute pt-5 left-0  hidden  group-hover:block ">
                    <div
                      className={`flex flex-col w-[200px]   ${
                        isDarkMode
                          ? "bg-gray-800 text-gray-300 "
                          : "bg-white text-gray-500 border"
                      }  shadow-lg`}
                    >
                      <Link
                        className={`${
                          isDarkMode
                            ? " hover:bg-gray-600 text-white"
                            : "hover:bg-blue-100 hover:text-primary"
                        }  border-b p-2`}
                        href="/courses/start-diving"
                      >
                        Start Diving
                      </Link>
                      <Link
                        className={`${
                          isDarkMode
                            ? " hover:bg-gray-600 text-white"
                            : "hover:bg-blue-100 hover:text-primary"
                        } p-2 border-b`}
                        href="/courses/continue-diving"
                      >
                        Continue Diving
                      </Link>
                      <Link
                        className={`${
                          isDarkMode
                            ? " hover:bg-gray-600 text-white"
                            : "hover:bg-blue-100 hover:text-primary"
                        }   p-2`}
                        href="/courses/become-professional"
                      >
                        Become Professional
                      </Link>
                    </div>
                  </div>
                </div>
              </div>
              <Link
                href="/diving-sites"
                className="hover:scale-105 hover:font-semibold font-medium  "
              >
                Diving sites
              </Link>

              <div className="relative">
                <div className="hover:font-semibold font-medium group ">
                  <Link href="/travel-booking"> Travel booking</Link>

                  <div className="submenu absolute pt-5 right-0  hidden  group-hover:block ">
                    <div
                      className={`flex flex-col w-[200px]   ${
                        isDarkMode
                          ? "bg-gray-800 text-gray-300 "
                          : "bg-white text-gray-500 border"
                      }  shadow-lg`}
                    >
                      <Link
                        className={`${
                          isDarkMode
                            ? " hover:bg-gray-600 text-white"
                            : "hover:bg-blue-100 hover:text-primary"
                        }  border-b p-2`}
                        href="/travel-booking/local"
                      >
                        Local Trip
                      </Link>
                      <Link
                        className={`${
                          isDarkMode
                            ? " hover:bg-gray-600 text-white"
                            : "hover:bg-blue-100 hover:text-primary"
                        }  p-2`}
                        href="/travel-booking/international"
                      >
                        International Trip
                      </Link>
                    </div>
                  </div>
                </div>
              </div>

              <div onClick={toggleMode}>
                {!isDarkMode ? (
                  <BsFillSunFill size={18} />
                ) : (
                  <BsMoonStarsFill size={18} />
                )}
              </div>
            </nav>

            <div
              className={`lg:hidden flex items-center gap-4 ${
                selectedLanguage === "english" ? "ml-auto" : "mr-auto"
              }`}
            >
              <Link href={"/auth"}>
                <IoPerson size={22} />
              </Link>
              <Link href={"/cart"}>
                <FaShoppingCart size={22} />
              </Link>
              <div className=" lg:hidden pr-2 ">
                {isMenuOpen ? (
                  <IoClose
                    className=""
                    size={30}
                    onClick={() => setIsMenuOpen(!isMenuOpen)}
                  />
                ) : (
                  <IoMenu
                    className=""
                    size={30}
                    onClick={() => setIsMenuOpen(!isMenuOpen)}
                  />
                )}
              </div>
            </div>
          </div>

          {/* Mobile menu */}
          {isMenuOpen && (
            <div
              className={`${
                !isMenuOpen
                  ? `duration-700 w-[230px] fixed top-18  h-screen ${
                      selectedLanguage === "arabic"
                        ? "-left-full"
                        : "-right-full"
                    }`
                  : `h-screen w-[230px] duration-1000 fixed top-18 right-0 z-[300] ${
                      selectedLanguage === "arabic" ? "left-0" : "right-0"
                    }`
              } ${
                isDarkMode ? "bg-black text-white" : "bg-white text-black"
              } shadow-lg lg:hidden `}
              ref={menuRef}
            >
              <div className="flex flex-col lg:hidden text-sm h-screen overflow-y-hidden font-medium">
                <Link
                  href="/"
                  className="hover:text-primary px-10  py-3"
                  onClick={() => setIsMenuOpen(false)}
                >
                  Home
                </Link>
                <Link
                  href="/courses"
                  className="hover:text-primary px-10  py-3   "
                  onClick={() => setIsMenuOpen(false)}
                >
                  Courses
                </Link>
                <Link
                  href="/diving-sites"
                  className="hover:text-primary px-10  py-3   "
                  onClick={() => setIsMenuOpen(false)}
                >
                  Diving sites
                </Link>

                <Link
                  href="/travel-booking"
                  className="hover:text-primary px-10  py-3   "
                  onClick={() => setIsMenuOpen(false)}
                >
                  Travel booking
                </Link>
                <Link
                  href="/aboutUs"
                  className="hover:text-primary px-10  py-3   "
                  onClick={() => setIsMenuOpen(false)}
                >
                  About
                </Link>

                <Link
                  href="/article"
                  className="hover:text-primary px-10  py-3    "
                  onClick={() => setIsMenuOpen(false)}
                >
                  Article
                </Link>
                <Link
                  href="/gallery"
                  className="hover:text-primary px-10  py-3    "
                  onClick={() => setIsMenuOpen(false)}
                >
                  Gallery
                </Link>
                <Link
                  href="/contactus"
                  className="hover:text-primary px-10  py-3    "
                  onClick={() => setIsMenuOpen(false)}
                >
                  Contact
                </Link>

                <select
                  className="outline-none bg-transparent px-10 py-3 "
                  value={selectedLanguage}
                  onChange={(e) => {
                    const selectedLanguage = e.target.value;
                    changeLanguage(selectedLanguage);
                  }}
                >
                  <option
                    className="px-3 text-sm bg-transparent text-primary"
                    value="english"
                  >
                    English
                  </option>
                  <option
                    className="px-3 text-sm bg-transparent text-primary"
                    value="arabic"
                  >
                    Arabic
                  </option>
                </select>

                <div onClick={toggleMode} className=" px-10  py-3  ">
                  {!isDarkMode ? (
                    <div className="flex gap-3 items-center">
                      <BsFillSunFill size={18} />
                      <p>Light</p>
                    </div>
                  ) : (
                    <div className="flex gap-3 items-center">
                      <BsMoonStarsFill size={18} />
                      <p>Dark</p>
                    </div>
                  )}
                </div>

                <div className="flex justify-center items-center gap-4  pt-5 ">
                  <Link
                    target="_blank"
                    href={"https://www.facebook.com/bubblesdivingkuwait/"}
                    className=""
                  >
                    <FaFacebook size={20} />
                  </Link>
                  <Link
                    target="_blank"
                    href={"https://www.instagram.com/bubblesdiving/"}
                    className=""
                  >
                    <RiInstagramFill size={20} />
                  </Link>
                  <Link
                    target="_blank"
                    href={"https://wa.me/96599989030"}
                    className="font-medium "
                  >
                    <FaWhatsapp size={20} />
                  </Link>
                  <Link
                    target="_blank"
                    href={
                      "https://www.google.com/maps/place/Ilmunz+Marine/@29.3211851,47.936282,18z/data=!4m6!3m5!1s0x3fcf9ab6b35f3647:0xc3616984630adafb!8m2!3d29.3211828!4d47.9354612!16s%2Fg%2F11c0wc2995?entry=ttu"
                    }
                    className=""
                  >
                    <MdLocationOn size={20} />
                  </Link>
                  <Link
                    target="_blank"
                    href={"tel:+965 9998 9030"}
                    className=""
                  >
                    <MdLocalPhone size={20} />
                  </Link>
                </div>
              </div>
            </div>
          )}
        </div>
      </>
    );
};

export default Header;
