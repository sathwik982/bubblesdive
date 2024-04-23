import React, { useEffect, useState } from "react";
import bgVideo from "../../lib/assets/home/sea-dive.mp4";
import {
  IoIosArrowBack,
  IoIosArrowForward,
  IoMdClose,
  IoMdArrowForward,
  IoIosArrowUp,
} from "react-icons/io";
import Link from "next/link";
import Bubbles from "./Bubbles";
import { truncate } from "@/lib/trucate";
import { useThemeContext } from "@/hooks/ThemeContext";
import { useRef } from "react";

const Section4 = () => {
  const { isDarkMode } = useThemeContext();
  const [selectedProduct, setSelectedProduct] = useState(null);
  const modalRef = useRef(null);

  const scubaDivingProducts = [
    {
      id: 1,
      title: "Dive Mask",
      price: 49.99,
      href: "/products/1",
      image:
        "https://media.istockphoto.com/id/576724556/photo/underwater-scuba-diver-making-self-portrait-or-selfie.jpg?s=1024x1024&w=is&k=20&c=OZ9nu6PLY-bDHtnQ3hI1D-7WR07BL-BvWdv8U1lNku4=",
      description:
        "A dive mask is an essential piece of scuba diving equipment that allows divers to see underwater clearly while protecting their eyes. It creates an air space in front of the diver's eyes, allowing them to focus underwater and providing a comfortable seal against the face. ",
    },
    {
      id: 2,
      title: "Wetsuit",
      price: 199.99,
      href: "/products/2",
      image:
        "https://media.istockphoto.com/id/1409271873/vector/full-body-diving-wetsuit-with-back-zipper-flat-sketch-design-illustration-one-piece-diving.jpg?s=612x612&w=0&k=20&c=Xn44PRs4HAPeC0WAJ5-1tHzMYCtHVIqo_EM758EjMZM=",
      description:
        " A wetsuit is a garment worn by divers, surfers, and other water sports enthusiasts to provide thermal insulation and protection from abrasion and UV exposure. It is typically made of neoprene material and traps a thin layer of water against the body, which warms up and helps maintain body temperature in cold water. ",
    },
    {
      id: 3,
      title: "Fins",
      price: 79.99,
      href: "/products/3",
      image:
        "https://media.istockphoto.com/id/171358712/photo/scuba-diving-fins-flippers.jpg?s=1024x1024&w=is&k=20&c=Cz7YRF69KaZEXdHc_lXBJ-E3CV1lPrHbAFqNWRWrSHg=",
      description:
        " Fins, also known as flippers, are essential diving equipment that aids in propulsion and maneuverability underwater. They are worn on the feet and come in various styles, including open-heel and full-foot designs. Fins increase swimming efficiency by allowing divers to move more efficiently through the water with less effort.",
    },
  ];

  const openProduct = (product) => {
    setSelectedProduct(product);
  };

  const closeProduct = () => {
    setSelectedProduct(null);
  };

  const goToNextProduct = () => {
    const currentIndex = scubaDivingProducts.findIndex(
      (product) => product.id === selectedProduct.id
    );
    if (currentIndex < scubaDivingProducts.length - 1) {
      setSelectedProduct(scubaDivingProducts[currentIndex + 1]);
    }
  };

  const goToPreviousProduct = () => {
    const currentIndex = scubaDivingProducts.findIndex(
      (product) => product.id === selectedProduct.id
    );
    if (currentIndex > 0) {
      setSelectedProduct(scubaDivingProducts[currentIndex - 1]);
    }
  };

  useEffect(() => {
    const handleClickOutside = (event) => {
      if (modalRef.current && !modalRef.current.contains(event.target)) {
        closeProduct();
      }
    };

    document.addEventListener("click", handleClickOutside);

    return () => {
      document.removeEventListener("click", handleClickOutside);
    };
  }, [selectedProduct]);

  return (
    <section
      id="section4"
      className="relative  flex flex-col justify-center items-center min-h-screen"
    >
      <video
        autoPlay
        muted
        loop
        className="absolute inset-0 w-full h-full object-cover filter brightness-50"
      >
        <source src={bgVideo} type="video/mp4" />
        Your browser does not support the video tag.
      </video>
      <div className="w-full overflow-hidden z-[200] absolute">
        <Bubbles />
      </div>
      {!selectedProduct ? (
        <div
          className="text-white  w-full px-4 z-[200] flex flex-col lg:flex-row-reverse
   justify-between  gap-5 max-w-[1200px] mx-auto"
        >
          <div className="flex flex-col gap-3 max-w-[400px]">
            <h2 className="text-xl md:text-2xl lg:text-3xl font-semibold">
              Featured Products
            </h2>
            <p className="text-gray-300">
              Dive into adventure with our premium gear! From dive masks to
              wetsuits and fins, our products are designed for comfort,
              durability, and optimal performance underwater. Gear up for your
              next dive and explore the depths with confidence!
            </p>
          </div>
          <div className="flex justify-center gap-3 ">
            {scubaDivingProducts.map((product) => (
              <div
                key={product.id}
                className={`w-[220px] h-[300px] object-contain  cursor-pointer ${
                  isDarkMode ? "bg-gray-800" : "bg-white"
                }  shadow-lg rounded-lg`}
                onClick={() => openProduct(product)}
              >
                <img
                  src={product.image}
                  className="w-full h-[150px] object-cover  rounded-t-lg"
                  alt={product.title}
                />
                <div className="mt-3 px-3 flex flex-col gap-2">
                  <p
                    className={`${
                      isDarkMode ? "text-gray-300" : " text-gray-900"
                    }  font-medium`}
                  >
                    {product.title}
                  </p>
                  <p
                    className={`${
                      isDarkMode ? "text-gray-400" : " text-gray-500"
                    } font-medium text-sm hidden sm:block`}
                  >
                    {truncate(product.description, 60)}
                  </p>
                </div>
              </div>
            ))}
          </div>
        </div>
      ) : (
        <div
          className="absolute inset-0 z-[250] flex justify-center items-center bg-gray-900 bg-opacity-90 m-auto w-[90vw] h-[90vh] "
          ref={modalRef}
        >
          <div className="w-full h-full flex flex-col justify-center items-center relative">
            <div className="absolute top-0 left-0 right-0 p-4 z-[300]  ">
              <button className="text-white  rounded-md" onClick={closeProduct}>
                <IoMdClose size={34} />
              </button>
            </div>
            <img
              src={selectedProduct.image}
              alt={selectedProduct.title}
              className="w-full h-full object-cover filter brightness-50"
            />
            <div className="absolute flex flex-col gap-3 bottom-10 left-0 right-0  p-4 text-white z-[200]">
              <h2 className="text-xl md:text-2xl lg:text-3xl font-semibold">
                {selectedProduct.title}
              </h2>
              <p className="text-gray-300">{selectedProduct.description}</p>
              <Link
                href={selectedProduct.href}
                className="text-white flex gap-2 hover:px-3"
              >
                <p>Buy Now</p> <IoMdArrowForward size={20} />
              </Link>
            </div>
            <div className="absolute  z-[350] top-1/2 transform -translate-y-1/2 flex justify-between w-full p-4 text-white ">
              <button className="text-white" onClick={goToPreviousProduct}>
                <IoIosArrowBack size={34} />
              </button>
              <button className="text-white" onClick={goToNextProduct}>
                <IoIosArrowForward size={34} />
              </button>
            </div>
          </div>
        </div>
      )}
      {/* Top center button */}
      <a
        href="#section3"
        className="absolute top-0 left-0 right-0 flex justify-center p-4 z-[200] text-white"
      >
        <IoIosArrowUp size={40} />
      </a>
    </section>
  );
};

export default Section4;
