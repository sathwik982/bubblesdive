"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import Link from "next/link";
import React from "react";
import BreadCrumbs from "../BreadCrumbs";

const MainCourseCard = () => {
  const { isDarkMode } = useThemeContext();
  const allCourses = [
    {
      id: "1",
      title: "Start Diving",
      category: "start-diving",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/e6/68/e66895efa2e7543ee762a6e045cf97b8.webp",
      description:
        "Learn the basics of diving and get started on your underwater adventure.",
    },
    {
      id: "2",
      title: "Continue Diving",
      category: "continue-diving",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/37/ae/37aee8e204107ba68e22baf3cba1ad08.webp",
      description:
        "Build on your diving skills and experience to explore more challenging dives.",
    },
    {
      id: "3",
      title: "Become Professional",
      category: "become-professional",
      image:
        " https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/6d/bc/6dbcca413b14352c8bfcb4ff6dc7d357.webp",
      description:
        "Take your diving to the next level and become a certified diving professional.",
    },
  ];
  return (
    <div className={`min-h-screen ${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
      <BreadCrumbs heading={"Courses"} />
      <div className="flex justify-center flex-wrap gap-5 md:gap-10 py-10 md:py-14   max-w-[1300px] mx-auto px-3">
        {allCourses.map((course, idx) => (
          <Link href={`/courses/${course.category}`} key={idx}>
            <div
              className={`rounded-xl max-w-[340px] ${
                isDarkMode
                  ? "bg-gray-800 text-white"
                  : "bg-white text-gray-700 border"
              }  group shadow-md overflow-hidden hover:shadow-lg transition duration-300`}
            >
              <div className="relative">
                <img
                  src={course.image}
                  alt={course.title}
                  className="w-full h-48 object-cover rounded-t-lg "
                />
              </div>

              <div className="px-3 md:px-5 py-3">
                <h2
                  className={`font-semibold text-xl ${
                    isDarkMode ? "text-gray-200" : "text-gray-700"
                  }`}
                >
                  {course.title}
                </h2>
                <p
                  className={`${
                    isDarkMode ? "text-gray-300" : "text-gray-600"
                  } mt-2`}
                >
                  {course.description}
                </p>
              </div>
              <div className="flex items-center justify-center mb-10 mt-5 ">
                <p
                  className={`text-lg p-2 font-semibold ${
                    isDarkMode ? " text-blue-700" : "text-primary "
                  }`}
                >
                  Explore Now
                </p>
              </div>
            </div>
          </Link>
        ))}
      </div>
    </div>
  );
};

export default MainCourseCard;
