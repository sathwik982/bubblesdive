"use client";
import React from "react";
import Diver from "./Diver";
import Section1 from "./Section1";
import Section2 from "./Section2";
import Section3 from "./Section3";
import Section4 from "./Section4";
import Wave from "./Wave";

const Home2 = () => {
  return (
    <>
      <Wave />
      <div className="overflow-hidden relative">
        <Diver />
        <Section1 />
        <Section2 />
        <Section3 />
        <Section4 />
      </div>
    </>
  );
};

export default Home2;
