"use client";
import CourseBooking from "@/components/courses/CourseBooking";
import React from "react";
import DetailCourse from "../../../../components/courses/DetailCourse";
import { useThemeContext } from "@/hooks/ThemeContext";

const DetailBecomeProfessional = () => {
  const { isDarkMode } = useThemeContext();
  const course = {
    course: {
      id: "1",
      title: "Open Water Diver",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/e6/68/e66895efa2e7543ee762a6e045cf97b8.webp",
      suitableFor: "Anyone over 10 years old",
      duration: 5,
      endTime: 10,
      price: 100,
      maxDepth: "18m",
      prerequitsites: [
        "Be comfortable in the water Medical Statement",
        "Fit to swim",
      ],
      description:
        "  The PADI Open Water Diver course is the world's most popular scuba diving course. It has introduced millions of people around the world to the wondrous world that lies beneath the waves.           The course teaches you the fundamentals of scuba diving in a safe and controlled environment. It is broken down into knowledge development, confined water sessions for learning skills and open water dives. And it is a performance based course which enables flexible learning. At bubbles diving center we believe in teaching our students the good fundamental skills of diving to enable our students to have more control in the water which enhances both their comfort and their enjoyment. We teach all our Open Water Courses with each student having their own dive computer to use for the duration of the course. The outcome is confident students who really understand the limits of diving in a safe controlled manner.   Once certified, as a PADI Open Water diver you are able to dive anywhere in the world and explore new places. ",
    },
    products: [
      {
        id: 8,
        title: "Dive Knife",
        price: 59.99,
        image:
          "https://media.istockphoto.com/id/139693014/photo/scuba-diving-knive.jpg?s=1024x1024&w=is&k=20&c=LllyWobNNMv1EdlbL8cgkVudszbm0fkJpodHqVP1QIg=",
      },
      {
        id: 9,
        title: "Snorkel",
        price: 29.99,
        image:
          "https://media.istockphoto.com/id/657795636/vector/dive-mask-and-snorkel-for-professionals-vector-illustration.jpg?s=612x612&w=0&k=20&c=7mjepbOjguBfVxBWRtephBtvqdO0UpApokHVeTXmA-s=",
      },
      {
        id: 10,
        title: "Underwater Camera",
        price: 499.99,
        image:
          "https://media.istockphoto.com/id/1401035031/photo/action-camera-in-the-water-in-a-protected-waterproof-case.jpg?s=1024x1024&w=is&k=20&c=krQ23lKRSsAZFr1ga17-vO78aJ8K1c4lapE9pjICxNw=",
      },
    ],
  };

  return (
    <div
      className={`pb-20 flex flex-col gap-10 ${
        isDarkMode ? "bg-gray-900" : "bg-white"
      }`}
    >
      <DetailCourse course={course} />
      <CourseBooking course={course} />
    </div>
  );
};

export default DetailBecomeProfessional;
