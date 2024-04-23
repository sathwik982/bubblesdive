"use client";
import React from "react";
import { ParallaxProvider, Parallax } from "react-scroll-parallax";
import parallax1 from "../../lib/assets/home/parallax-1.png";
import parallax2 from "../../lib/assets/home/parallax-2.png";
import parallax3 from "../../lib/assets/home/parallax-3.png";
import parallax4 from "../../lib/assets/home/parallax-4.png";
import parallax5 from "../../lib/assets/home/parallax-5.png";
import parallax6 from "../../lib/assets/home/parallax-6.png";
import water2 from "../../lib/assets/home/water2.jpg";

import Image from "next/image";

const CustomParallax = () => {
  return (
    <ParallaxProvider>
      <div className="-z-10 overflow-hidden">
        <div>
          <Image
            src={water2}
            alt="Underwater"
            className="w-full h-screen object-cover"
          />
          <Parallax
            className="absolute top-40 right-4 sm:right-16 md:right-32"
            scaleX={[1, 1]}
            speed={-100} endScroll={10} >
            <Image
              src={parallax1}
              alt="Diver"
              className="h-24 w-32 md:h-48 md:w-60 z-30 object-contain"
            />
          </Parallax>
        </div>

        <div>
          <Image
            src={water2}
            alt="Underwater"
            className="w-full h-screen object-cover absolute"
          />
          <Parallax className=" text-right  "  speed={-50} startScroll={-50} >
            <Image
              src={parallax2} 
              alt="Diver"
              className="h-24 w-32 md:h-48 md:w-60 z-30 object-contain "
            />
          </Parallax>
        </div>
        {/* <Image
          src={water2}
          alt="Underwater"
          className="w-full h-screen object-cover"
  />*/}

        {/*  <Image
          src={water2}
          alt="Underwater"
          className="w-full h-screen object-cover"
        />
        <Parallax
          className="underwater w-full z-10 min-h-screen flex justify-end px-3"
          speed={-80} // Adjust speed for faster movement
          scaleX={[1, 1]}
        >
          <Image
            src={parallax3}
            alt="Diver"
            className="h-24 w-32 md:h-48 md:w-60 z-40 object-contain"
          />
        </Parallax> */}

        {/* <Image
          src={water2}
          alt="Underwater"
          className="w-full h-screen object-cover"
        />
        <Parallax
          className="underwater w-full -z-10 flex justify-end px-3 min-h-screen"
          speed={-100} // Adjust speed for even faster movement
          scaleX={[1, 1]}
        >
          <Image
            src={parallax4}
            alt="Diver"
            className="h-24 w-32 md:h-48 md:w-60 z-40 object-contain"
          />
        </Parallax> */}

        {/* <Image
          src={water2}
          alt="Underwater"
          className="w-full h-screen object-cover"
        />
        <Parallax
          className="underwater w-full -z-10 flex justify-end px-3 min-h-screen"
          speed={-120} // Adjust speed for faster movement
          scaleX={[1, 1]}
        >
          <Image
            src={parallax5}
            alt="Diver"
            className="h-24 w-32 md:h-48 md:w-60 z-40 object-contain"
          />
        </Parallax> */}

        {/* <Image
          src={water2}
          alt="Underwater"
          className="w-full h-screen object-cover"
        />
        <Parallax
          className="underwater w-full -z-10 flex justify-end px-3 min-h-screen"
          speed={-50} // Adjust speed for faster movement
          scaleX={[1, 1]}
        >
          <Image
            src={parallax6}
            alt="Diver"
            className="h-24 w-32 md:h-48 md:w-60 z-40 object-contain"
          />
        </Parallax> */}
      </div>
    </ParallaxProvider>
  );
};

export default CustomParallax;
