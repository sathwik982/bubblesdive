import Image from "next/image";
import Link from "next/link";
import React from "react";
import bg from "../lib/assets/home/home-1.jpg";

const BreadCrumbs = ({ heading, links }) => {
  return (
    <div className="">
      <Image
        src={bg}
        className="w-full h-[200px] lg:h-[280px]  object-cover filter brightness-50"
      />
      <div className="absolute top-[110px] lg:top-[150px] flex flex-col gap-5 items-center justify-center w-full">
        <h3 className="uppercase font-semibold text-xl md:text-2xl lg:text-3xl text-white text-center">
          {heading}
        </h3>
      </div>
    </div>
  );
};

export default BreadCrumbs;
