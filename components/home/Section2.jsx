"use client";
import React, { useEffect, useState } from "react";
import bgVideo from "../../lib/assets/home/section-3.mp4";
import {
  IoIosArrowBack,
  IoIosArrowForward,
  IoMdClose,
  IoMdArrowForward,
  IoIosArrowDown,
  IoIosArrowUp,
} from "react-icons/io";
import Link from "next/link";
import Bubbles from "./Bubbles";
import { truncate } from "@/lib/trucate";
import { useThemeContext } from "@/hooks/ThemeContext";
import { useRef } from "react";

const Section2 = () => {
  const { isDarkMode } = useThemeContext();
  const [selectedTrip, setSelectedTrip] = useState(null);
  const modalRef = useRef(null);

  const trips = [
    {
      id: "1",
      title: "Snorkel Trip",
      category: "snorkel-trip",
      description:
        "Explore coral reefs and marine life while gliding through crystal-clear waters on our snorkel adventure.",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/37/ae/37aee8e204107ba68e22baf3cba1ad08.webp",
      href: "/dive-booking/snorkel-trip",
    },
    {
      id: "2",
      title: "Discover Scuba Diving Trip",
      category: "dsb",
      description:
        "Experience the thrill of diving beneath the waves with expert guidance during our Discover Scuba Diving excursion.",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/e6/68/e66895efa2e7543ee762a6e045cf97b8.webp",
      href: "/dive-booking/dsb",
    },
    {
      id: "3",
      title: "Diving Trip",
      category: "diving-trip",
      description:
        "Immerse yourself in ocean depths, exploring captivating dive sites and encountering diverse marine creatures.",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/6d/bc/6dbcca413b14352c8bfcb4ff6dc7d357.webp",
      href: "/dive-booking/diving-trip ",
    },
  ];

  const openTrip = (trip) => {
    setSelectedTrip(trip);
  };

  const closeTrip = () => {
    setSelectedTrip(null);
  };

  const goToNextCourse = () => {
    const currentIndex = trips.findIndex(
      (course) => course.id === selectedTrip.id
    );
    if (currentIndex < trips.length - 1) {
      setSelectedTrip(trips[currentIndex + 1]);
    }
  };

  const goToPreviousCourse = () => {
    const currentIndex = trips.findIndex(
      (course) => course.id === selectedTrip.id
    );
    if (currentIndex > 0) {
      setSelectedTrip(trips[currentIndex - 1]);
    }
  };

  useEffect(() => {
    const handleClickOutside = (event) => {
      if (modalRef.current && !modalRef.current.contains(event.target)) {
        closeTrip();
      }
    };

    document.addEventListener("click", handleClickOutside);

    return () => {
      document.removeEventListener("click", handleClickOutside);
    };
  }, [selectedTrip]);

  return (
    <section
      id="section2"
      className="relative  flex flex-col  justify-center items-center min-h-screen"
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
      {!selectedTrip ? (
        <div
          className="text-white  w-full px-4 z-[200] flex flex-col md:flex-row-reverse
         justify-between  gap-5 max-w-[1200px] mx-auto"
        >
          <div className="flex flex-col gap-3 max-w-[400px]">
            <h2 className="text-xl md:text-2xl lg:text-3xl font-semibold">
              Dive Trips
            </h2>
            <p className="text-gray-300">
              Allowing you to discover hidden treasures and encounter
              fascinating marine life in breathtaking underwater landscapes.
            </p>
          </div>
          <div className="flex justify-center gap-3">
            {trips.map((trip) => (
              <div
                key={trip.id}
                className={`w-[220px] h-[300px] object-contain  cursor-pointer ${
                  isDarkMode ? "bg-gray-800" : "bg-white"
                }  shadow-lg rounded-lg`}
                onClick={() => openTrip(trip)}
              >
                <img
                  src={trip.image}
                  className="w-full h-[150px] object-cover  rounded-t-lg"
                  alt={trip.title}
                />
                <div className="mt-3 px-3 flex flex-col gap-2">
                  <p
                    className={`${
                      isDarkMode ? "text-gray-300" : " text-gray-900"
                    }  font-medium`}
                  >
                    {trip.title}
                  </p>
                  <p
                    className={`${
                      isDarkMode ? "text-gray-400" : " text-gray-500"
                    } font-medium text-sm hidden sm:block`}
                  >
                    {truncate(trip.description, 60)}
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
              <button className="text-white  rounded-md" onClick={closeTrip}>
                <IoMdClose size={34} />
              </button>
            </div>
            <img
              src={selectedTrip.image}
              alt={selectedTrip.title}
              className="w-full h-full object-cover filter brightness-50"
            />
            <div className="absolute flex flex-col gap-3 bottom-10 left-0 right-0  p-4 text-white z-[200]">
              <h2 className="text-xl md:text-2xl lg:text-3xl font-semibold">
                {selectedTrip.title}
              </h2>
              <p className="text-gray-300">{selectedTrip.description}</p>
              <Link
                href={selectedTrip.href}
                className="text-gray-300 flex gap-2 hover:px-3"
              >
                <p>Learn More </p> <IoMdArrowForward size={20} />
              </Link>
            </div>
            <div className="absolute top-1/2 transform -translate-y-1/2 flex justify-between w-full p-4 text-white z-[200]">
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
        href="#section1"
        className="absolute top-0 left-0 right-0 flex justify-center p-4 z-[200] text-white"
      >
        <IoIosArrowUp size={40} />
      </a>

      {/* Bottom center button */}
      <a
        href="#section3"
        className="absolute bottom-0 left-0 right-0 flex justify-center p-4 z-[200] text-white"
      >
        <IoIosArrowDown size={40} />
      </a>
    </section>
  );
};

export default Section2;
