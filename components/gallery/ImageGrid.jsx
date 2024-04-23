"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import React, { useEffect, useState } from "react";
import {
  MdOutlineArrowForwardIos,
  MdOutlineArrowBackIosNew,
  MdClose,
} from "react-icons/md";
import BreadCrumbs from "../BreadCrumbs";

const ImageGrid = () => {
  const { isDarkMode } = useThemeContext();
  const medias = [
    {
      src: "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/e8/4b/e84bc10b72e92e945b7a43bb04d2499e.webp",
      type: "image",
    },
    {
      src: "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/84/c5/84c5078c9446fd05a47b1ce9a64a3daf.webp",
      type: "image",
    },
    {
      src: "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/dd/a6/dda64bbd7d65b50c0c406c3cd99bee3e.webp",
      type: "image",
    },
    {
      src: "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/d6/00/d60012c932686fde9520db8381df918a.webp",
      type: "image",
    },
    {
      src: "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/fd/b5/fdb518db8f2ecf1385786aab605698f9.webp",
      type: "image",
    },
    {
      src: "https://media.istockphoto.com/id/1389726786/video/4k-video-footage-of-bubbles-underwater-in-the-ocean.mp4?s=mp4-640x640-is&k=20&c=oqga_UhAZUnZK9oA9z1vJpY0pGLsCfqB-rawbSmKwWk=",
      type: "video",
    },
    {
      src: "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/63/b1/63b18b04d534b1a7e8711161f6e84eb2.webp",
      type: "image",
    },
    {
      src: "https://d2p1cf6997m1ir.cloudfront.net/media/thumbnails/1c/ce/1ccea0e7a3c9b7e16827ef7596cf93c4.webp",
      type: "image",
    },
  ];
  const [selectedMediaIndex, setSelectedMediaIndex] = useState(null);
  const [isFullScreen, setIsFullScreen] = useState(false);

  const openFullScreen = (index) => {
    setSelectedMediaIndex(index);
    setIsFullScreen(true);
  };

  const closeFullScreen = () => {
    setSelectedMediaIndex(null);
    setIsFullScreen(false);
  };

  const handleOutsideClick = (e) => {
    if (
      e.target.closest(".max-w-screen-xl") === null &&
      e.target.closest(".cursor-pointer") === null
    ) {
      closeFullScreen();
    }
  };

  useEffect(() => {
    if (isFullScreen) {
      document.body.addEventListener("click", handleOutsideClick);
    } else {
      document.body.removeEventListener("click", handleOutsideClick);
    }

    return () => {
      document.body.removeEventListener("click", handleOutsideClick);
    };
  }, [isFullScreen]);

  const goToPreviousMedia = (e) => {
    e.stopPropagation();
    if (selectedMediaIndex === null) return;
    const newIndex =
      selectedMediaIndex === 0 ? medias.length - 1 : selectedMediaIndex - 1;
    setSelectedMediaIndex(newIndex);
  };

  const goToNextMedia = (e) => {
    e.stopPropagation();
    if (selectedMediaIndex === null) return;
    const newIndex =
      selectedMediaIndex === medias.length - 1 ? 0 : selectedMediaIndex + 1;
    setSelectedMediaIndex(newIndex);
  };

  return (
    <div className={`min-h-screen ${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
      <BreadCrumbs heading={"Gallery"} />
      <div className="py-10 md:py-14 min-h-screen">
        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 max-w-[1200px] mx-auto gap-1">
          {medias.map((item, index) => (
            <div
              key={index}
              className="cursor-pointer"
              onClick={() => openFullScreen(index)}
            >
              {item.type === "image" && (
                <img
                  src={item.src}
                  alt={`Image ${index + 1}`}
                  className="hover:opacity-50 w-full h-[200px] md:h-[300px]"
                />
              )}
              {item.type === "video" && (
                <video
                  src={item.src}
                  className="w-full h-[300px] object-cover"
                  controls
                >
                  Your browser does not support the video tag.
                </video>
              )}
            </div>
          ))}

          {/* Full Screen View */}
          {selectedMediaIndex !== null && (
            <div className="fixed top-0 left-0 w-full h-full flex justify-center items-center bg-black bg-opacity-75 z-[2000]">
              <div className="max-w-screen-xl mx-auto relative ">
                <button
                  className="absolute z-40 top-0 left-0 m-4 text-white rounded-md "
                  onClick={closeFullScreen}
                >
                  <MdClose className="h-8 w-8 md:h-12 md:w-12" />
                </button>
                <button
                  className="absolute z-40 top-1/2 transform -translate-y-1/2 right-0 m-4 text-white rounded-md "
                  onClick={goToNextMedia}
                >
                  <MdOutlineArrowForwardIos className="h-8 w-8 md:h-12 md:w-12" />
                </button>
                <button
                  className="absolute z-40 top-1/2 transform -translate-y-1/2 left-0 m-4 text-white rounded-md "
                  onClick={goToPreviousMedia}
                >
                  <MdOutlineArrowBackIosNew className="h-8 w-8 md:h-12 md:w-12" />
                </button>
                {selectedMediaIndex !== null && (
                  <div>
                    {medias[selectedMediaIndex].type === "image" ? (
                      <img
                        src={medias[selectedMediaIndex].src}
                        alt="Full Screen"
                        className="w-[90vw] max-h-[90vh]  rounded-md"
                      />
                    ) : (
                      <video
                        src={medias[selectedMediaIndex].src}
                        className="w-[90vw] max-h-[90vh] rounded-md"
                        controls
                      >
                        Your browser does not support the video tag.
                      </video>
                    )}
                  </div>
                )}
              </div>
            </div>
          )}
        </div>
      </div>
    </div>
  );
};

export default ImageGrid;
