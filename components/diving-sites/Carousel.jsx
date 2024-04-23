"use client";
import React, { useState, useEffect } from "react";

const Carousel = ({ images }) => {
  const [currentIndex, setCurrentIndex] = useState(0);

  useEffect(() => {
    const interval = setInterval(() => {
      goToNext();
    }, 3000);

    return () => clearInterval(interval);
  }, [currentIndex]);

  const goToPrevious = () => {
    setCurrentIndex((prevIndex) =>
      prevIndex === 0 ? images.length - 1 : prevIndex - 1
    );
  };

  const goToNext = () => {
    setCurrentIndex((prevIndex) =>
      prevIndex === images.length - 1 ? 0 : prevIndex + 1
    );
  };

  const goToSlide = (index) => {
    setCurrentIndex(index);
  };

  return (
    <div className="relative">
      <div className="relative overflow-hidden ">
        <div className="flex transition-transform duration-300 ease-in-out">
          {images.map((image, index) => (
            <img
              key={index}
              src={image}
              alt={`Slide ${index}`}
              className={`w-full h-90vh md:h-[80vh] ${
                index === currentIndex ? "block" : "hidden"
              }`}
            />
          ))}
        </div>
        <div className="absolute bottom-4 left-0 right-0 flex justify-center">
          {images.map((_, index) => (
            <button
              key={index}
              className={`w-2 h-2 md:h-3 md:w-3 rounded-full mx-1 focus:outline-none ${
                index === currentIndex ? "bg-primary" : "bg-gray-300"
              }`}
              onClick={() => goToSlide(index)}
            />
          ))}
        </div>
      </div>
    </div>
  );
};

export default Carousel;
