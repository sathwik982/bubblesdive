"use client";
import Image from "next/image";
import { usePathname } from "next/navigation";
import logo from "../lib/assets/logo.svg";
import React from "react";
import Link from "next/link";
import { FaFacebook, FaInstagram, FaInstagramSquare } from "react-icons/fa";
import { FaWhatsapp } from "react-icons/fa6";
import bg from "../lib/assets/footer.webp";
import { IoCallOutline, IoLocationOutline, IoMail } from "react-icons/io5";

const Footer = () => {
  const pathName = usePathname();

  if (pathName !== "/auth")
    return (
      <footer className="relative px-3 lg:px-5 overflow-hidden">
        <div className="md:flex gap-10 lg:gap-20 max-w-[1300px] mx-auto items-start py-3 md:py-5">
          <div className="flex items-start justify-center z-50">
            <Image src={logo} className="h-24 w-56 object-contain" alt="logo" />
          </div>

          <div className="flex z-50 flex-col mt-5 sm:flex-row w-full justify-around gap-5 px-3 ">
            <div className="sm:w-1/2">
              <h2 className="font-semibold text-lg text-white">Contact Us</h2>
              <div className="flex gap-3 mt-2 flex-col px-1">
                <Link
                  href={"mailto:info@bubblesdivingcenter.com"}
                  className="hover:text-white text-gray-400 flex items-start lg:items-center gap-3 w-fit"
                >
                  <IoMail />
                  <p>
                    info
                    <span className="block lg:hidden"> </span>
                    @bubblesdivingcenter.com
                  </p>
                </Link>

                <Link
                  href={"tel:+965 9998 9030"}
                  className="hover:text-white text-gray-400 flex  items-center gap-3 w-fit"
                >
                  <IoCallOutline />
                  <p>+965 9998 9030</p>
                </Link>
                <Link
                  target={"_blank"}
                  href={
                    "https://www.google.com/maps/place/Ilmunz+Marine/@29.3211851,47.936282,18z/data=!4m6!3m5!1s0x3fcf9ab6b35f3647:0xc3616984630adafb!8m2!3d29.3211828!4d47.9354612!16s%2Fg%2F11c0wc2995?entry=ttu"
                  }
                  className="hover:text-white text-gray-400 gap-3 flex items-start"
                >
                  <div className="flex-grow h-20 w-12">
                    <IoLocationOutline style={"flex"} />{" "}
                  </div>
                  <p className="flex-shrink">
                    Ilmunz Marine co , Shuwaikh Industrial area , Block,
                    Ghaneema Fahad Almarzouk Complex, Building 250, St, 70050
                    Shuwaikh Industrial, Kuwait
                  </p>
                </Link>
              </div>
            </div>

            <div className="">
              <h2 className="font-semibold tracking-wider text-lg text-white w-fit ">
                Quick Links
              </h2>
              <div className="flex gap-2  mt-2 flex-col px-2 text-gray-400 ">
                <Link
                  href="/aboutUs"
                  className="hover:text-white w-fit hover:font-semibold font-medium  "
                >
                  About
                </Link>
                <Link
                  href="/article"
                  className="hover:text-white w-fit hover:font-semibold font-medium  "
                >
                  Article
                </Link>
                <Link
                  href="/gallery"
                  className="hover:text-white w-fit hover:font-semibold font-medium  "
                >
                  Gallery
                </Link>
                <Link
                  href="/contactus"
                  className="hover:text-white w-fit hover:font-semibold font-medium  "
                >
                  Contact
                </Link>
                <Link
                  href="/terms-condition"
                  className="hover:text-white w-fit hover:font-semibold font-medium  "
                >
                  Terms & Conditions
                </Link>
                <Link
                  href="/faq"
                  className="hover:text-white w-fit hover:font-semibold font-medium  "
                >
                  FAQS
                </Link>
              </div>
            </div>
          </div>
        </div>
        <Image
          src={bg}
          className="absolute inset-0 -z-50 w-full h-full object-cover filter brightness-50"
        />
        <hr className="my-3 border-gray-400 sm:mx-auto z-50" />
        <div className="flex items-center justify-between flex-col gap-3 sm:flex-row px-3 py-5 z-50 max-w-[1300px] mx-auto">
          <div className="text-white">
            © 2024{" "}
            <span className="text-blue-700 font-semibold ">
              Bubbles Diving Center
            </span>
            . All Rights Reserved.
          </div>
          <div className="flex justify-start gap-5">
            <Link
              target="_blank"
              href={"https://www.facebook.com/bubblesdivingkuwait/"}
              className="font-medium text-white hover:text-blue-700 "
            >
              <FaFacebook size={24} />
            </Link>

            <Link
              target="_blank"
              href={"https://www.instagram.com/bubblesdiving/"}
              className="font-medium text-white hover:text-blue-700 "
            >
              <FaInstagram size={24} />
            </Link>
            <Link
              target="_blank"
              href={"https://wa.me/96599989030"}
              className="font-medium text-white hover:text-blue-700 "
            >
              <FaWhatsapp size={24} />
            </Link>
          </div>
        </div>
      </footer>
    );
};
export default Footer;
