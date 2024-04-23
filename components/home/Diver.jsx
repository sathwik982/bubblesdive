import React, { useEffect, useState } from "react";
import Image from "next/image";
import { ParallaxProvider, Parallax } from "react-scroll-parallax";
import diverImage1 from "../../lib/assets/home/parallax-1.png";
import diverImage2 from "../../lib/assets/home/parallax-2.png";
import diverImage2arabic from "../../lib/assets/home/parallax-2-arabic.png";

import diverImage3 from "../../lib/assets/home/parallax-6.png";
import { useLanguageContext } from "@/hooks/LanguageContext";

const Diver = () => {
  const [vhScrolled, setVhScrolled] = useState(0);
  const { selectedLanguage } = useLanguageContext();

  useEffect(() => {
    const handleScroll = () => {
      const scrollTop = window.scrollY;
      const viewportHeight = window.innerHeight;
      const vh = scrollTop / viewportHeight;
      setVhScrolled(vh);
    };

    window.addEventListener("scroll", handleScroll);
    return () => {
      window.removeEventListener("scroll", handleScroll);
    };
  }, []);

  let currentImage = diverImage1;
  if (vhScrolled >= 2 && vhScrolled < 3) {
    if (selectedLanguage === "arabic") {
      currentImage = diverImage2arabic;
    } else {
      currentImage = diverImage2;
    }
  } else if (vhScrolled >= 3) {
    currentImage = diverImage3;
  }

  return (
    <ParallaxProvider>
      <Parallax
        className="diver-image absolute z-[160]"
        y={[-50, 50]}
        speed={-1000}
      >
        <Image src={currentImage} width={200} height={200} alt="Diver" />
      </Parallax>
    </ParallaxProvider>
  );
};

export default Diver;
