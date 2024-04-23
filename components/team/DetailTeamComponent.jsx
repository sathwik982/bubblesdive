"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import Link from "next/link";
import React from "react";
import { FaFacebook, FaInstagram } from "react-icons/fa";
import BreadCrumbs from "../BreadCrumbs";

const DetailTeamComponent = () => {
  const { isDarkMode } = useThemeContext();
  const teamMember = {
    name: "Abdulrahman Alsarheed",
    roles: [
      "NAUI course director ",
      "Padi Instructor ",
      "SSI Instructor",
      "SDI Instructor",
    ],
    image:
      "https://media.istockphoto.com/id/685132235/photo/mature-businessman-over-white-background.jpg?s=1024x1024&w=is&k=20&c=UKsVordx7n0zf0yyaZiFZsea_RX8-zjqId6orbbukF8=",
  };
  return (
    <div className={`${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
      <BreadCrumbs heading={teamMember.name} />
      <div className="pt-10 pb-20 max-w-[1300px] mx-auto px-3 md:px-5 lg:px-8">
        <div className="flex  flex-col md:flex-row items-center justify-center gap-8 md:gap-20 md:items-start px-3 py-2">
          <div className="flex flex-col gap-5 rounded-lg">
            <img
              src={teamMember.image}
              alt={teamMember.name}
              className="h-[300px] w-[350px] rounded-lg "
            />
            <div className="justify-center  flex items-center gap-5 ">
              <Link href={""} className="flex gap-3 items-center ">
                <FaInstagram
                  size={24}
                  className={`${isDarkMode ? "text-blue-700" : "text-primary"}`}
                />
              </Link>

              <Link href={""} className="flex gap-3 items-center ">
                <FaFacebook
                  size={24}
                  className={`${isDarkMode ? "text-blue-700" : "text-primary"}`}
                />
              </Link>
            </div>
          </div>

          <div className="flex flex-col gap-5 md:gap-10 md:w-3/4">
            <div>
              <h2
                className={`${
                  isDarkMode ? "text-blue-700" : "text-primary"
                } font-bold text-xl md:text-2xl lg:text-3xl`}
              >
                {teamMember.name}
              </h2>
              <div
                className={`flex items-start  gap-1 md:gap-3 ${
                  isDarkMode ? "text-gray-400" : "text-gray-500"
                }  font-medium flex-wrap `}
              >
                {teamMember.roles?.map((role, index) => (
                  <p key={index}>{role}</p>
                ))}
              </div>
            </div>

            <div className="flex flex-col  gap-3 md:gap-5">
              <p
                className={`${
                  isDarkMode ? "text-blue-700" : "text-primary"
                } font-semibold text-lg md:text-xl`}
              >
                Description
              </p>
              <p
                className={`${isDarkMode ? "text-gray-400" : "text-gray-500"}`}
              >
                A wonderful serenity has taken possession of my entire soul,
                like these sweet mornings of spring which I enjoy with my whole
                heart. I am alone, and feel the charm of existence in this spot,
                which was created for the bliss of souls like mine. I am so
                happy, my dear friend, so absorbed in the exquisite sense of
                mere tranquil existence, that I neglect my talents. I should be
                incapable of drawing a single stroke at the present moment. I
                throw myself down among the tall grass by the trickling stream;
                and, as I lie close to the earth. Thousand unknown plants are
                noticed by me. When I hear the buzz of the little world among
                the stalks, and grow familiar with the countless.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default DetailTeamComponent;
