import Image from "next/image";
import Link from "next/link";
import React, { useEffect } from "react";
import bgVideo from "../../lib/assets/home/1461282_Santa Giulia_Coastline_Beach_1920x1080.mp4";
import scrollGif from "../../lib/assets/home/scroll.gif";

const Wave = () => {
  // useEffect(() => {
  //   const handleScroll = () => {
  //     let value = window.scrollY;
  //     let wave1 = document.querySelector(".wave-1");
  //     let wave2 = document.querySelector(".wave-2");
  //     let wave3 = document.querySelector(".wave-3");
  //     let wave4 = document.querySelector(".wave-4");

  //     if (wave1 && wave2 && wave3 && wave4) {
  //       wave1.style.backgroundPositionX = 400 + value * 4 + "px";
  //       wave2.style.backgroundPositionX = 300 + value * 4 + "px";
  //       wave3.style.backgroundPositionX = 200 + value * 2 + "px";
  //       wave4.style.backgroundPositionX = 100 + value * 2 + "px";
  //     }
  //   };

  //   window.addEventListener("scroll", handleScroll);
  //   return () => {
  //     window.removeEventListener("scroll", handleScroll);
  //   };
  // }, []);

  return (
    <section id="home" className="relative w-full h-screen ">
      <video
        className="absolute inset-0 w-full h-full object-cover"
        autoPlay
        muted
        loop
      >
        <source src={bgVideo} type="video/mp4" />
      </video>

      <div className="absolute inset-0 flex justify-center items-center bottom-20 px-3">
        <h1 className="text-white text-lg sm:text-2xl md:text-4xl lg:text-5xl font-bold uppercase w-full text-center">
          Welcome To Bubbles Diving Center
        </h1>
      </div>

      <div className="absolute bottom-5 w-full flex flex-col justify-center items-center gap-4 px-3 ">
        <Image src={scrollGif} className="h-14 w-14" alt="" />
        <h1 className="text-white italic text-lg md:text-2xl lg:text-3xl font-medium text-center">
          Explore The Ocean With Us
        </h1>
        <a href="#section1" className="px-5 py-2 bg-primary text-white">
          Take a Dive
        </a>
      </div>
      {/* <div className="wave wave-1"></div>
      <div className="wave wave-2"></div>
      <div className="wave wave-3"></div>
      <div className="wave wave-4"></div> */}
    </section>
  );
};

export default Wave;
