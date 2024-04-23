"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import { truncate } from "@/lib/trucate";
import Link from "next/link";
import React from "react";
import BreadCrumbs from "../BreadCrumbs";

const DivingSiteCard = () => {
  const { isDarkMode } = useThemeContext();
  const sites = [
    {
      id: "1",
      title: "Garoh Island Diving Site",
      image:
        "https://media.istockphoto.com/id/693573392/photo/aerial-drone-photo-of-sivota-with-clear-water-beaches-epirus-greece.jpg?s=1024x1024&w=is&k=20&c=-ZFZfmvROwo9gnCZGlYLFkg_IiUWPJoFrqlOTCkBns0=",
      description:
        "Explore the mesmerizing underwater world of Garoh Island. Immerse yourself in crystal-clear waters teeming with vibrant marine life, from colorful corals to exotic fish species. With its stunning coral reefs and diverse aquatic ecosystem, Garoh Island offers an unforgettable diving experience for enthusiasts of all skill levels.",
    },
    {
      id: "2",
      title: "Kubbar Island Dive Adventure",
      image:
        "https://media.istockphoto.com/id/803689962/photo/aerial-drone-photo-of-schinias-area-with-turquoise-water-beach-attica-greece.jpg?s=1024x1024&w=is&k=20&c=if7W-Ebh3RARmeZrdR8lPkMSDPMPKj-QmMpmaRy9y04=",
      description:
        "Embark on an exhilarating dive adventure at Kubbar Island, renowned for its rich biodiversity and breathtaking underwater scenery. Dive into the azure waters surrounding the island and discover a kaleidoscope of marine life, including majestic sea turtles, graceful rays, and an array of coral formations. Whether you're a seasoned diver or a novice explorer, Kubbar Island promises an unforgettable underwater journey.",
    },
    {
      id: "3",
      title: "Tailor Rock Dive Site Exploration",
      image:
        "https://media.istockphoto.com/id/1085230340/photo/underwater.jpg?s=1024x1024&w=is&k=20&c=5WzX_0pfLmac_Mw2lsUIgRaaA0s5Lu75UIqTfE_wdG4=",
      description:
        "Delve into the depths of Tailor Rock, a hidden gem among Kuwait's diving sites. Prepare to be enchanted by the beauty of its underwater landscapes, adorned with vibrant corals, towering rock formations, and an abundance of marine creatures. From thrilling encounters with colorful reef fish to serene drift dives along its currents, Tailor Rock offers an unforgettable diving experience for adventurers seeking new horizons.",
    },
    {
      id: "4",
      title: "Um Almaradem Island Underwater Discovery",
      image:
        "https://media.istockphoto.com/id/693573392/photo/aerial-drone-photo-of-sivota-with-clear-water-beaches-epirus-greece.jpg?s=1024x1024&w=is&k=20&c=-ZFZfmvROwo9gnCZGlYLFkg_IiUWPJoFrqlOTCkBns0=",
      description:
        "Uncover the secrets of Um Almaradem Island's underwater realm, where an enchanting world of marine wonders awaits. Dive into the azure waters surrounding the island and witness an extraordinary diversity of marine life, from playful dolphins to elusive reef sharks. With its pristine coral reefs and crystal-clear visibility, Um Almaradem Island is a paradise for divers seeking extraordinary encounters beneath the waves.",
    },
  ];
  return (
    <div className={`min-h-screen ${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
      <BreadCrumbs heading={"Diving Sites"} />
      <div className="flex gap-5  flex-wrap max-w-[1300px] mx-auto justify-center py-10 md:py-14 px-3">
        {sites.map((site, idx) => (
          <Link
            href={`/diving-sites/${site.id}`}
            className={`max-w-[600px] flex flex-col rounded-lg shadow-lg ${
              isDarkMode ? "bg-gray-800" : "bg-white border"
            }`}
            key={idx}
          >
            <div className=" ">
              <img
                src={site?.image}
                className="object-cover h-[300px] w-full rounded-t-lg "
                alt="site image"
              />
            </div>
            <div
              className={` flex flex-col justify-center px-3 lg:px-5 gap-3 my-5`}
            >
              <h2
                className={`font-semibold mb-1 text-base md:text-lg lg:text-xl ${
                  isDarkMode ? "text-gray-300" : ""
                }`}
              >
                {site.title}
              </h2>
              <p
                className={`${
                  isDarkMode ? "text-gray-400" : "text-gray-500"
                }  text-sm md:text-base`}
              >
                {truncate(site.description, 300)}
              </p>
            </div>
          </Link>
        ))}
      </div>
    </div>
  );
};

export default DivingSiteCard;


