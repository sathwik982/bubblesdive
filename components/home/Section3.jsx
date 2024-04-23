import React, { useEffect, useState } from "react";
import bgVideo from "../../lib/assets/home/sea-dive.mp4";
import {
  IoIosArrowBack,
  IoIosArrowForward,
  IoMdClose,
  IoMdArrowForward,
  IoIosArrowUp,
  IoIosArrowDown,
} from "react-icons/io";
import Link from "next/link";
import Bubbles from "./Bubbles";
import { truncate } from "@/lib/trucate";
import { useThemeContext } from "@/hooks/ThemeContext";
import { useRef } from "react";

const Section3 = () => {
  const { isDarkMode } = useThemeContext();
  const [selectedCourse, setSelectedCourse] = useState(null);
  const modalRef = useRef(null);

  const allCourses = [
    {
      id: "1",
      title: "Start Diving",
      category: "start-diving",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/e6/68/e66895efa2e7543ee762a6e045cf97b8.webp",
      description:
        "Learn the basics of diving and get started on your underwater adventure.",
      href: "/courses/start-diving",
    },
    {
      id: "2",
      title: "Continue Diving",
      category: "continue-diving",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/37/ae/37aee8e204107ba68e22baf3cba1ad08.webp",
      description:
        "Build on your diving skills and experience to explore more challenging dives.",
      href: "/courses/continue-diving",
    },
    {
      id: "3",
      title: "Become Professional",
      category: "become-professional",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/6d/bc/6dbcca413b14352c8bfcb4ff6dc7d357.webp",
      description:
        "Take your diving to the next level and become a certified diving professional.",
      href: "/courses/become-professional",
    },
  ];

  const openCourse = (course) => {
    setSelectedCourse(course);
  };

  const closeCourse = () => {
    setSelectedCourse(null);
  };

  const goToNextCourse = () => {
    const currentIndex = allCourses.findIndex(
      (course) => course.id === selectedCourse.id
    );
    if (currentIndex < allCourses.length - 1) {
      setSelectedCourse(allCourses[currentIndex + 1]);
    }
  };

  const goToPreviousCourse = () => {
    const currentIndex = allCourses.findIndex(
      (course) => course.id === selectedCourse.id
    );
    if (currentIndex > 0) {
      setSelectedCourse(allCourses[currentIndex - 1]);
    }
  };

  useEffect(() => {
    const handleClickOutside = (event) => {
      if (modalRef.current && !modalRef.current.contains(event.target)) {
        closeCourse();
      }
    };

    document.addEventListener("click", handleClickOutside);

    return () => {
      document.removeEventListener("click", handleClickOutside);
    };
  }, [selectedCourse]);

  return (
    <section
      id="section3"
      className="relative  flex flex-col justify-center items-center min-h-screen"
    >
      <video
        autoPlay
        muted
        loop
        className="absolute inset-0 w-full h-full object-cover filter brightness-50"
      >
        <source src={bgVideo} type="video/mp4" />
        Your browser does not support the video tag.
      </video>
      <div className="w-full overflow-hidden z-[200] absolute">
        <Bubbles />
      </div>
      {!selectedCourse ? (
        <div
          className="text-white  w-full px-4 z-[200] flex flex-col lg:flex-row
   justify-between  gap-5 max-w-[1200px] mx-auto"
        >
          <div className="flex flex-col gap-3 max-w-[400px]">
            <h2 className="text-xl md:text-2xl lg:text-3xl font-semibold">
              Dive Courses and Certifications
            </h2>
            <p className="text-gray-300">
              Explore the depths with our top-tier diving school. Led by
              certified instructors, our courses cover everything from basics to
              advanced techniques. Dive into marine biology and conservation
              while mastering essential skills and safety protocols. Get
              certified and dive with confidence!
            </p>
          </div>
          <div className="flex justify-center gap-3 ">
            {allCourses.map((course) => (
              <div
                key={course.id}
                className={`w-[220px] h-[300px] object-contain  cursor-pointer ${
                  isDarkMode ? "bg-gray-800" : "bg-white"
                }  shadow-lg rounded-lg`}
                onClick={() => openCourse(course)}
              >
                <img
                  src={course.image}
                  className="w-full h-[150px] object-cover  rounded-t-lg"
                  alt={course.title}
                />
                <div className="mt-3 px-3 flex flex-col gap-2">
                  <p
                    className={`${
                      isDarkMode ? "text-gray-300" : " text-gray-900"
                    }  font-medium`}
                  >
                    {course.title}
                  </p>
                  <p
                    className={`${
                      isDarkMode ? "text-gray-400" : " text-gray-500"
                    } font-medium text-sm hidden sm:block`}
                  >
                    {truncate(course.description, 60)}
                  </p>
                </div>
              </div>
            ))}
          </div>
        </div>
      ) : (
        <div
          className="absolute inset-0 z-[250] flex justify-center items-center bg-gray-900 bg-opacity-90 m-auto w-[90vw] h-[90vh] "
          ref={modalRef}
        >
          <div className="w-full h-full flex flex-col justify-center items-center relative">
            <div className="absolute top-0 left-0 right-0 p-4 z-[300]  ">
              <button className="text-white  rounded-md" onClick={closeCourse}>
                <IoMdClose size={34} />
              </button>
            </div>
            <img
              src={selectedCourse.image}
              alt={selectedCourse.title}
              className="w-full h-full object-cover filter brightness-50"
            />
            <div className="absolute flex flex-col gap-3 bottom-10 left-0 right-0  p-4 text-white z-[200]">
              <h2 className="text-xl md:text-2xl lg:text-3xl font-semibold">
                {selectedCourse.title}
              </h2>
              <p className="text-gray-300">{selectedCourse.description}</p>
              <Link
                href={selectedCourse.href}
                className="text-white flex gap-2 hover:px-3"
              >
                <p>Learn More </p> <IoMdArrowForward size={20} />
              </Link>
            </div>
            <div className="absolute  z-[350] top-1/2 transform -translate-y-1/2 flex justify-between w-full p-4 text-white ">
              <button className="text-white" onClick={goToPreviousCourse}>
                <IoIosArrowBack size={34} />
              </button>
              <button className="text-white" onClick={goToNextCourse}>
                <IoIosArrowForward size={34} />
              </button>
            </div>
          </div>
        </div>
      )}
      {/* Top center button */}
      <a
        href="#section2"
        className="absolute top-0 left-0 right-0 flex justify-center p-4 z-[200] text-white"
      >
        <IoIosArrowUp size={40} />
      </a>

      {/* Bottom center button */}
      <a
        href="#section4"
        className="absolute bottom-0 left-0 right-0 flex justify-center p-4 z-[200] text-white"
      >
        <IoIosArrowDown size={40} />
      </a>
    </section>
  );
};

export default Section3;
