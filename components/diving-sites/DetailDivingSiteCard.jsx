"use client";
import React from "react";
import Carousel from "./Carousel";
import WindFinderForecast from "./WindFinderForecast";
import WindFinderStatistics from "./WindFinderStatistics";
import { useThemeContext } from "@/hooks/ThemeContext";
import Link from "next/link";
import UpcomingTrip from "./UpcomingTrip";

const DetailDivingSiteCard = () => {
  const { isDarkMode } = useThemeContext();
  const site = {
    name: "Garoh Island Diving Site",
    location: "Garoh Island",
    features: ["Coral reefs", "underwater caves"],
    attractions: ["Beautiful coral formations", "diverse marine life"],
    marineLife: ["Colorful fish", "sea turtles", "reef sharks"],
    depth: "20m",
    pointsOfInterest: ["Underwater caves", " coral gardens", "shipwrecks"],
    description:
      "Located off the coast of Garoh Island, the Garoh Island Diving Site offers an unforgettable underwater experience for diving enthusiasts. This site is renowned for its stunning coral reefs and intricate underwater caves, providing divers with a captivating landscape to explore. The beauty of the site is enhanced by its diverse marine life, including colorful fish, graceful sea turtles, and majestic reef sharks. With a depth of around 20 meters, divers can immerse themselves in the vibrant ecosystem while discovering fascinating points of interest such as underwater caves, coral gardens, and even shipwrecks. Garoh Island Diving Site promises an adventure-filled dive excursion amidst the natural splendor of the ocean.",
    images: [
      "https://media.istockphoto.com/id/1493415056/photo/woman-dives-near-the-shipwreck-with-corals-in-a-tropical-sea-in-the-maldives.webp?s=1024x1024&w=is&k=20&c=Uh9fzm1x47Vpktx2KH0oC_9mQ2YBx9DNfZZ1MmpUepU=",
      "https://media.istockphoto.com/id/1300663994/photo/maldives.jpg?s=2048x2048&w=is&k=20&c=_3M9pYybJf-iLzvsrS4U5BPdJVl3qyYKVMsVYrAtgnU=",
      "https://media.istockphoto.com/id/1303060161/photo/scuba-diver-into-the-easter-islands-sea-life-reef-at-rapa-nui-chile-latin-america.jpg?s=1024x1024&w=is&k=20&c=qNTUHuaPo6VB8Ls00Tmr19d0cqxYgNFtQrFBRnUHUwA=",
      "https://media.istockphoto.com/id/1360323358/photo/scuba-divers-couple-near-beautiful-coral-reef-surrounded-with-shoal-of-coral-fish-and-three.jpg?s=612x612&w=0&k=20&c=Slr1T3dmRFmUJnZmeQRAwhaG0wWhGrQPgmceWyaWorM=",
    ],
    upcomingTrips: [
      {
        id: "1",
        title: "Snorkel Trip",
        category: "local",
        date: "20-05-2024",
        description:
          "Explore coral reefs and marine life while gliding through crystal-clear waters on our snorkel adventure.",
        image:
          "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/37/ae/37aee8e204107ba68e22baf3cba1ad08.webp",
      },
      {
        id: "2",
        title: "Discover Scuba Diving Trip",
        category: "local",
        date: "22-05-2024",
        description:
          "Experience the thrill of diving beneath the waves with expert guidance during our Discover Scuba Diving excursion.",
        image:
          "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/e6/68/e66895efa2e7543ee762a6e045cf97b8.webp",
      },
      {
        id: "3",
        title: "Diving Trip",
        category: "local",
        date: "25-05-2024",
        description:
          "Immerse yourself in ocean depths, exploring captivating dive sites and encountering diverse marine creatures.",
        image:
          "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/6d/bc/6dbcca413b14352c8bfcb4ff6dc7d357.webp",
      },
    ],
  };

  const trips = [
    {
      id: "1",
      title: "Snorkel Trip",
      category: "local",
      date: "20-05-2024",
      price: 455,
      description:
        "Explore coral reefs and marine life while gliding through crystal-clear waters on our snorkel adventure.",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/37/ae/37aee8e204107ba68e22baf3cba1ad08.webp",
    },
    {
      id: "2",
      title: "Discover Scuba Diving Trip",
      category: "local",
      date: "22-05-2024",
      price: 955,
      description:
        "Experience the thrill of diving beneath the waves with expert guidance during our Discover Scuba Diving excursion.",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/e6/68/e66895efa2e7543ee762a6e045cf97b8.webp",
    },
    {
      id: "3",
      title: "Diving Trip",
      category: "local",
      date: "25-05-2024",
      price: 999,
      description:
        "Immerse yourself in ocean depths, exploring captivating dive sites and encountering diverse marine creatures.",
      image:
        "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/6d/bc/6dbcca413b14352c8bfcb4ff6dc7d357.webp",
    },
  ];

  return (
    <div className={`${isDarkMode ? "bg-gray-900" : "bg-white"} pb-20`}>
      <div className={`relative`}>
        <Carousel images={site.images} />
        <div className="mx-auto max-w-[1200px] py-5 ">
          <h2
            className={`text-white text-2xl md:text-3xl lg:text-4xl font-semibold absolute bottom-20 px-3 md:bottom-32`}
          >
            {site?.name}
          </h2>
        </div>
      </div>

      <div className="max-w-[1200px] mx-auto gap-10 pt-5 pb-10 flex lg:flex-row flex-col px-5">
        <div className="w-full px-2 max-h-[340px]  rounded-lg  overflow-hidden ">
          <WindFinderForecast />
        </div>
        <div className="w-full px-2 max-h-[340px] rounded-lg  overflow-hidden ">
          <WindFinderStatistics />
        </div>
      </div>

      <div className="max-w-[1200px] mx-auto flex flex-col gap-5 md:gap-8 px-5">
        <div className="flex justify-between   flex-col sm:flex-row sm:items-center flex-wrap gap-5">
          <div className="flex items-center gap-3 flex-wrap flex-1">
            <h3
              className={`font-semibold ${
                isDarkMode ? "text-blue-700" : "text-primary"
              }  text-lg md:text-xl lg:text-2xl`}
            >
              Location:
            </h3>
            <p
              className={`${
                isDarkMode ? "text-gray-400" : "text-gray-700"
              }  px-1 md:px-3`}
            >
              {site?.location}
            </p>
          </div>
          <div className="flex items-center gap-3 flex-wrap flex-1">
            <h3
              className={`font-semibold ${
                isDarkMode ? "text-blue-700" : "text-primary"
              }  text-lg md:text-xl lg:text-2xl`}
            >
              Depth:
            </h3>
            <p
              className={`${
                isDarkMode ? "text-gray-400" : "text-gray-700"
              }  px-1 md:px-3`}
            >
              {site?.depth}
            </p>
          </div>
        </div>

        <div className="flex justify-between  flex-col sm:flex-row sm:items-center flex-wrap gap-5">
          <div className="flex gap-3 flex-wrap flex-col flex-1">
            <h3
              className={`font-semibold ${
                isDarkMode ? "text-blue-700" : "text-primary"
              }  text-lg md:text-xl lg:text-2xl`}
            >
              Features:
            </h3>
            <ul
              className={`${
                isDarkMode ? "text-gray-400" : "text-gray-700"
              } pl-6  list-decimal `}
            >
              {site?.features?.map((feature, idx) => (
                <li key={idx}>{feature}</li>
              ))}
            </ul>
          </div>

          <div className="flex gap-3 flex-wrap flex-col flex-1">
            <h3
              className={`font-semibold ${
                isDarkMode ? "text-blue-700" : "text-primary"
              }  text-lg md:text-xl lg:text-2xl`}
            >
              Attractions:
            </h3>
            <ul
              className={`${
                isDarkMode ? "text-gray-400" : "text-gray-700"
              } pl-6  list-decimal `}
            >
              {site?.attractions?.map((attraction, idx) => (
                <li key={idx}>{attraction}</li>
              ))}
            </ul>
          </div>
        </div>

        <div className="flex justify-between  flex-col sm:flex-row sm:items-center flex-wrap gap-5">
          <div className="flex gap-3 flex-wrap flex-col flex-1">
            <h3
              className={`font-semibold ${
                isDarkMode ? "text-blue-700" : "text-primary"
              }  text-lg md:text-xl lg:text-2xl`}
            >
              Marin Life:
            </h3>
            <ul
              className={`${
                isDarkMode ? "text-gray-400" : "text-gray-700"
              } pl-6  list-decimal `}
            >
              {site?.marineLife?.map((attraction, idx) => (
                <li key={idx}>{attraction}</li>
              ))}
            </ul>
          </div>

          <div className="flex gap-3 flex-wrap flex-col flex-1">
            <h3
              className={`font-semibold ${
                isDarkMode ? "text-blue-700" : "text-primary"
              }  text-lg md:text-xl lg:text-2xl`}
            >
              Points of Interest:
            </h3>
            <ul
              className={`${
                isDarkMode ? "text-gray-400" : "text-gray-700"
              } pl-6  list-decimal `}
            >
              {site?.pointsOfInterest?.map((attraction, idx) => (
                <li key={idx}>{attraction}</li>
              ))}
            </ul>
          </div>
        </div>

        <div className="flex flex-col gap-3 flex-wrap">
          <h3
            className={`font-semibold ${
              isDarkMode ? "text-blue-700" : "text-primary"
            }  text-lg md:text-xl lg:text-2xl`}
          >
            Description:
          </h3>
          <p
            className={`${
              isDarkMode ? "text-gray-400" : "text-gray-700"
            }  px-1 md:px-3`}
          >
            {site?.description}
          </p>
        </div>

        <div className="flex flex-col gap-3 flex-wrap pb-10 mt-3">
          <div className="flex justify-between items-center gap-5">
            <h3
              className={`font-semibold text-lg md:text-xl lg:text-2xl ${
                isDarkMode ? "text-blue-700" : "text-primary"
              } `}
            >
              Upcoming Trips:
            </h3>

            <Link
              href={"/travel-booking/local"}
              className={`${
                isDarkMode ? "text-blue-700 " : "text-primary"
              } font-semibold `}
            >
              View All
            </Link>
          </div>

          <div className="flex flex-wrap gap-8 justify-center mt-3">
            {trips?.map((trip, idx) => (
              <UpcomingTrip key={idx} trip={trip} />
            ))}
          </div>
        </div>
      </div>
    </div>
  );
};

export default DetailDivingSiteCard;
