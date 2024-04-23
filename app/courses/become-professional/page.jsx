"use client";
import BreadCrumbs from "@/components/BreadCrumbs";
import CourseCard from "@/components/courses/CourseCard";
import { useThemeContext } from "@/hooks/ThemeContext";
import React from "react";

const BecomeProfessional = () => {
  const { isDarkMode } = useThemeContext();
  const allCourses = [
    {
      id: "1",
      title: "Padi Dive Master",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/e6/68/e66895efa2e7543ee762a6e045cf97b8.webp",
      duration: 14,
      price: 100,
      description:
        "Uncover the mysteries of the deep with the Deep Diver Specialty course. Dive to greater depths, experience thrilling underwater landscapes, and challenge yourself to new depths of exploration.",
    },
  ];

  return (
    <div className={`min-h-screen ${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
      <BreadCrumbs heading={"Become Professional"} />
      <div className="flex gap-5 md:gap-10 py-10 md:py-14 flex-wrap max-w-[1300px] justify-center mx-auto px-3">
        {allCourses.map((course) => (
          <CourseCard
            course={course}
            key={course.id}
            category={"become-professional"}
          />
        ))}
      </div>
    </div>
  );
};

export default BecomeProfessional;
