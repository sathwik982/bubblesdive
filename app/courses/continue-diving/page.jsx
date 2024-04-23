"use client";
import BreadCrumbs from "@/components/BreadCrumbs";
import CourseCard from "@/components/courses/CourseCard";
import { useThemeContext } from "@/hooks/ThemeContext";
import React from "react";

const ContinueDiving = () => {
  const { isDarkMode } = useThemeContext();
  const allCourses = [
    {
      id: "1",
      title: "Padi Advanced Open Water Diver",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/e6/68/e66895efa2e7543ee762a6e045cf97b8.webp",
      duration: 3,
      price: 100,
      description:
        " Elevate your diving expertise with the PADI Advanced Open Water Diver course. Explore exhilarating underwater landscapes, master advanced techniques, and unlock new opportunities for underwater exploration.",
    },
    {
      id: "2",
      title: "Padi Junior Advanced Open Water Diver",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/37/ae/37aee8e204107ba68e22baf3cba1ad08.webp",
      duration: 3,
      price: 150,
      description:
        " Designed for young adventurers, the PADI Junior Advanced Open Water Diver course offers a thrilling introduction to advanced diving. Dive into deeper waters, navigate challenging environments, and embark on unforgettable underwater adventures.",
    },
    {
      id: "3",
      title: "Padi Resuce Diver",
      image:
        " https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/6d/bc/6dbcca413b14352c8bfcb4ff6dc7d357.webp",
      duration: 3,
      price: 150,
      description:
        "Become a guardian of the underwater realm with the PADI Rescue Diver course. Learn essential rescue techniques, develop leadership skills, and prepare yourself to handle emergency situations with confidence and competence.",
    },
    {
      id: "4",
      title: "Emergency First Response",
      image:
        " https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/a4/c9/a4c9460e8e98e59c6054da24d0c28822.webp",
      duration: 3,
      price: 150,
      description:
        "Equip yourself with lifesaving skills through the Emergency First Response course. Learn CPR, first aid, and emergency response techniques, and become a valuable asset in any diving or non-diving emergency situation.",
    },
    {
      id: "5",
      title: "Enriched Air Diver Specialty",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/3b/9f/3b9f565de162426c78da7a05e383f8fb.webp",
      duration: 3,
      price: 150,
      description:
        "Dive longer and explore further with the Enriched Air Diver Specialty course. Discover the benefits of enriched air nitrox, extend your bottom time, and maximize your diving adventures.",
    },
    {
      id: "6",
      title: "Deep Diver Specialty",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/a7/79/a7796d7172e51a153af38bd9c99d86c6.webp",
      duration: 3,
      price: 150,
      description:
        "Uncover the mysteries of the deep with the Deep Diver Specialty course. Dive to greater depths, experience thrilling underwater landscapes, and challenge yourself to new depths of exploration.",
    },
  ];

  return (
    <div className={`min-h-screen ${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
      <BreadCrumbs heading={"Continue Diving"} />
      <div className="flex gap-5 md:gap-10 py-10 md:py-14 flex-wrap max-w-[1300px] justify-center mx-auto px-3">
        {allCourses.map((course) => (
          <CourseCard
            course={course}
            key={course.id}
            category={"continue-diving"}
          />
        ))}
      </div>
    </div>
  );
};

export default ContinueDiving;
