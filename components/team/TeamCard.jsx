"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import Link from "next/link";
import React, { useState } from "react";

const TeamCard = () => {
  const { isDarkMode } = useThemeContext();
  const teamMembers = [
    {
      id: "1",
      name: "Abdulrahman Alsarheed",
      role: [
        "Dive Instructor",
        "NAUI course director ",
        "Padi Instructor",
        "SSI Instructor",
        "SDI Instructor",
      ],
      image:
        "https://theme708-diving-store.myshopify.com/cdn/shop/files/about_1_270x270_69121261-0b5c-4695-97d1-8103865e7eeb_377x377.jpg?v=1613167541",
    },
    {
      id: "2",
      name: "TharwatAlmasry",
      role: ["PADI Master Instructor", "EFR Instructor"],
      image:
        "https://media.istockphoto.com/id/1200677760/photo/portrait-of-handsome-smiling-young-man-with-crossed-arms.jpg?s=1024x1024&w=is&k=20&c=zfHwkHjH_Keys_sy5B1UjKzuqAQRRo5_8Ag0NkH2kjY=",
    },
    {
      id: "3",
      name: "Mohammed Alanga",

      role: ["PADI Instructor", "EFR Instructor"],
      image:
        "https://media.istockphoto.com/id/1171169099/photo/man-with-crossed-arms-isolated-on-gray-background.jpg?s=1024x1024&w=is&k=20&c=STK0wru6a2H2DoiFprd3xdq2IKFS2P3_swZWrh0h9Mg=",
    },
    {
      id: "4",
      name: "Nasser Abdulrahim",
      role: ["PADI Instructor", "EFR Instructor"],
      image:
        "https://media.istockphoto.com/id/1090878494/photo/close-up-portrait-of-young-smiling-handsome-man-in-blue-polo-shirt-isolated-on-gray-background.jpg?s=1024x1024&w=is&k=20&c=Hxj-W9DZrAdB46kOnOI_Khnk56EeAAzXEJsg7_xzByY=",
    },
    {
      id: "5",
      name: "Mohammed Alsherazi",
      role: [
        "PADI Instructor",
        "EFR Instructor",
        "EFR Trainer",
        "FajerAlhazeem",
      ],
      image:
        "https://media.istockphoto.com/id/685132245/photo/mature-businessman-smiling-over-white-background.jpg?s=1024x1024&w=is&k=20&c=DVMnVqNdEdAJ36bvPGvwp-TY5NHOm_4ayk9pxyUnHn4=",
    },
    {
      id: "6",
      name: "Nour Aljasem",
      role: ["PADI Instructor", "EFR Instructor"],
      image:
        "https://media.istockphoto.com/id/669888024/photo/businessman-in-textile-factory.jpg?s=1024x1024&w=is&k=20&c=YpMQUWUs6Ofu4JiaZ0XjfXc99I1yX6U_aKBC7mikDZY=",
    },
    {
      id: "7",
      name: "Zaid Alanga",
      role: ["PADI divemaster"],
      image:
        "https://media.istockphoto.com/id/685132235/photo/mature-businessman-over-white-background.jpg?s=1024x1024&w=is&k=20&c=UKsVordx7n0zf0yyaZiFZsea_RX8-zjqId6orbbukF8=",
    },
    {
      id: "8",
      name: "MusaeedAldamkhi",
      role: ["PADI divemaster"],
      image:
        "https://media.istockphoto.com/id/1132792394/photo/headshot-of-a-young-adult.jpg?s=1024x1024&w=is&k=20&c=2aCs_GshjRbo-rQ6YXUXnv_6ppDRPCiJfEr5Nlt3e1A=",
    },
  ];

  return (
    <div className="mt-12">
      <ul className="grid gap-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        {teamMembers.map((item, idx) => (
          <li key={idx}>
            <Link
              href={`/team/${item.id}`}
              className="w-full h-60 sm:h-52 md:h-56"
            >
              <img
                src={item.image}
                className="w-[350px] h-[250px] object-cover object-center shadow-md rounded-xl"
                alt=""
              />
            </Link>
            <div className="mt-4 px-3">
              <h4
                className={`text-lg ${
                  isDarkMode ? "text-blue-700" : "text-primary"
                } font-semibold`}
              >
                {item.name}
              </h4>

              <p
                className={` ${
                  isDarkMode ? "text-gray-400" : "text-gray-600"
                } mt-2`}
              >
                {item.role[0]}
              </p>
            </div>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default TeamCard;
