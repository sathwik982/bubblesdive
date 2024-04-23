"use client";
import BreadCrumbs from "@/components/BreadCrumbs";
import CourseCard from "@/components/courses/CourseCard";
import { useThemeContext } from "@/hooks/ThemeContext";
import React from "react";


const StartDiving = () => {
  const { isDarkMode } = useThemeContext();
  const allCourses = [
    {
      id: "1",
      title: "Padi open water diver",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/e6/68/e66895efa2e7543ee762a6e045cf97b8.webp",
      duration: 3,
      description:
        "Begin your exploration with the PADI Open Water Diver course, where you'll learn fundamental diving techniques and safety protocols. Dive into crystal-clear waters and unlock a new realm of marine wonders.",
      price: 100,
    },
    {
      id: "2",
      title: "Padi Junior Open Water Diver",
      description:
        "Designed for young adventurers, the PADI Junior Open Water Diver course provides a safe and exciting introduction to diving. Dive alongside colorful marine life and ignite your passion for exploration.",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/37/ae/37aee8e204107ba68e22baf3cba1ad08.webp",
      duration: 3,
      price: 150,
    },
    {
      id: "3",
      title: "Advance Open Water Diver",
      description:
        "Take your diving skills to the next level with the Advanced Open Water Diver course. Explore deeper waters, enhance your navigation abilities, and immerse yourself in thrilling underwater adventures.",
      image:
        " https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/6d/bc/6dbcca413b14352c8bfcb4ff6dc7d357.webp",
      duration: 3,
      price: 150,
    },
  ];

  return (
    <div className={`min-h-screen ${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
      <BreadCrumbs heading={"Start Diving"} />
      <div className="flex gap-5 md:gap-10 py-10 md:py-14 flex-wrap max-w-[1300px] justify-center mx-auto  px-3">
        {allCourses.map((course) => (
          <CourseCard
            course={course}
            key={course.id}
            category={"start-diving"}
          />
        ))}
      </div>
    </div>
  );
};

export default StartDiving;
