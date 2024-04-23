"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import { truncate } from "@/lib/trucate";
import Link from "next/link";
import React from "react";
import { FaCalendar, FaClock } from "react-icons/fa";

const CourseCard = ({ course, category }) => {
  const { isDarkMode } = useThemeContext();
  return (
    <Link href={`/courses/${category}/${course.id}`}>
      <div
        className={`rounded-xl max-w-[340px] min-h-[440px] shadow-lg ${
          isDarkMode ? "bg-gray-800" : "bg-white border"
        }  overflow-hidden transition duration-300`}
      >
        <img
          src={course.image}
          alt={course.title}
          className="w-full h-48 object-cover rounded-t-lg"
        />

        <div className="px-3 md:px-5 flex flex-col gap-3 mt-3">
          <h2
            className={`font-semibold text-xl ${
              isDarkMode ? "text-gray-300" : "text-gray-700"
            }`}
          >
            {course.title}
          </h2>

          <p className={`${isDarkMode ? "text-gray-400" : "text-gray-600"}`}>
            {" "}
            {truncate(course?.description, 150)}
          </p>

          <div className="flex items-center gap-2  text-gray-600 justify-between">
            <div className="flex items-center gap-2">
              <FaClock
                size={14}
                className={`${isDarkMode ? "text-blue-700" : "text-primary"}`}
              />
              <p
                className={`${isDarkMode ? "text-gray-400" : "text-gray-500"} `}
              >
                {course.duration} days
              </p>
            </div>
            <>
              <p
                className={`${
                  isDarkMode ? "text-blue-700" : "text-primary"
                } font-medium`}
              >
                KD {course?.price}
              </p>
            </>
          </div>
        </div>
      </div>
    </Link>
  );
};

export default CourseCard;
