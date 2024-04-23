"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import Link from "next/link";
import React from "react";
import { FaClock } from "react-icons/fa";
import FeaturedProducts from "./FeaturedProducts";

const DetailCourse = ({ course }) => {
  const { isDarkMode } = useThemeContext();
  return (
    <div className="  min-h-screen ">
      <div className="relative overflow-hidden">
        <img
          src={
            "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/e6/68/e66895efa2e7543ee762a6e045cf97b8.webp"
          }
          className="w-full h-[60vh] filter brightness-50  overflow-hidden object-cover"
          alt="article image"
        />
        <div className="mx-auto max-w-[1200px]">
          <div className="text-white bottom-3  absolute   w-full">
            <h3 className="my-3 px-3 font-semibold text-2xl md:text-3xl lg:text-4xl">
              {course?.course?.title}
            </h3>
            <div className="flex items-center flex-wrap md:gap-10 text-lg">
              <div className="flex items-center mb-3 px-3">
                <FaClock size={14} className="text-gray-300" />
                <p className="flex items-center text-gray-300 px-2 font-medium ">
                  {course?.course?.duration} days
                </p>
              </div>
              <p className="font-semibold mb-3 px-3">
                KD {course?.course?.price}
              </p>
            </div>
          </div>
        </div>
      </div>

      <div className="flex flex-col gap-5 max-w-[1200px] mx-auto mt-5 px-3">
        <div className="flex items-center gap-3 flex-wrap">
          <h3
            className={`font-semibold md:text-lg lg:text-xl ${
              isDarkMode ? "text-blue-700" : "text-primary"
            } `}
          >
            Suitable For:
          </h3>
          <p
            className={`px-1 ${
              isDarkMode ? "text-gray-400" : "text-gray-700"
            } "`}
          >
            {course?.course?.suitableFor}
          </p>
        </div>

        <div className="flex flex-col gap-3">
          <h3
            className={`font-semibold md:text-lg lg:text-xl ${
              isDarkMode ? "text-blue-700" : "text-primary"
            } `}
          >
            Prerequitsites:
          </h3>

          <ol
            type="1"
            style={{ listStyleType: "decimal" }}
            className={`${isDarkMode ? "text-gray-400" : "text-gray-700"} px-5`}
          >
            {course?.course?.prerequitsites.map((prerequitsite, idx) => (
              <li key={idx}>{prerequitsite}</li>
            ))}
          </ol>
        </div>

        <div className="flex items-center gap-3 flex-wrap">
          <h3
            className={`font-semibold md:text-lg lg:text-xl ${
              isDarkMode ? "text-blue-700" : "text-primary"
            } `}
          >
            Max. Depth:
          </h3>
          <p
            className={`${isDarkMode ? "text-gray-400" : "text-gray-700"} px-5`}
          >
            {course?.course?.maxDepth}
          </p>
        </div>

        <div className="flex flex-col gap-3 flex-wrap">
          <h3
            className={`font-semibold md:text-lg lg:text-xl ${
              isDarkMode ? "text-blue-700" : "text-primary"
            } `}
          >
            Description:
          </h3>
          <p
            className={`${isDarkMode ? "text-gray-400" : "text-gray-700"} px-5`}
          >
            {course?.course?.description}
          </p>
        </div>

        <div className="flex flex-col gap-3 flex-wrap pb-10 mt-3">
          <div className="flex justify-between items-center gap-5">
            <h3
              className={`font-semibold md:text-lg lg:text-xl ${
                isDarkMode ? "text-blue-700" : "text-primary"
              } `}
            >
              Featured Products:
            </h3>

            <Link
              href={"/products"}
              className={`${
                isDarkMode ? "text-blue-700 " : "text-primary"
              } font-semibold `}
            >
              View All
            </Link>
          </div>

          <div className="flex flex-wrap gap-8 justify-center mt-3">
            {course?.products.map((product, idx) => (
              <FeaturedProducts key={idx} product={product} />
            ))}
          </div>
        </div>
      </div>
    </div>
  );
};

export default DetailCourse;
