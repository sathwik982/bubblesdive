"use client";
import { useProductContext } from "@/hooks/ProductContext";
import { useThemeContext } from "@/hooks/ThemeContext";
import React from "react";

const DetailProductCard = () => {
  const { addProductToCart } = useProductContext();
  const { isDarkMode } = useThemeContext();
  const product = {
    id: "1",
    title:
      "CREE XM-L T6 LED DIVING FLASHLIGHT SUBMARINE LAMP UNDERWATER TORCH WATERPROOF",
    category: " Lights",
    image:
      "https://media.istockphoto.com/id/1161346810/photo/modern-black-collimator-sight-isolated-on-white-background.jpg?s=1024x1024&w=is&k=20&c=w9crsidXDfY0F3PoBo90ReCBWycb9hkyAhOmy31PYiU=",
    price: "925.00",
    description:
      "Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni soluta, provident sapiente pariatur eos cum accusamus quasi inventore quod nam voluptates! Molestias aliquid ut recusandae explicabo ad doloribus natus dolores?",
  };

  return (
    <div className={`${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
      <div className="bg-primary h-16 lg:h-[6.5rem]"></div>
      <div className="mx-auto max-w-[1200px] pt-10 pb-20 px-3 md:px-5">
        <div className=" mx-auto flex flex-wrap">
          <img
            alt={product.title}
            className="lg:w-1/2 w-full lg:h-auto h-54 object-contain max-h-[400px] object-center  m-auto"
            src={product?.image}
          />
          <div className="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0 flex flex-col gap-3">
            <h2
              className={`text-sm font-medium ${
                isDarkMode ? "text-gray-400" : "text-gray-500"
              } tracking-widest `}
            >
              {product.category}
            </h2>
            <h1
              className={`text-sm font-semibold ${
                isDarkMode ? "text-gray-300" : "text-gray-900"
              } mb-2 md:text-3xl  `}
            >
              {product.title}
            </h1>

            <p
              className={`leading-relaxed text-sm ${
                isDarkMode ? "text-gray-400" : "text-gray-700"
              } md:text-base`}
            >
              {product.description}
            </p>
            <div className="flex">
              <span className="title-font font-medium md:text-2xl text-gray-900 mt-2">
                KD {product.price}
              </span>
            </div>
            <button
              className={`flex mt-3 w-fit ${
                isDarkMode ? "bg-blue-700" : "bg-primary"
              } text-white border-0 py-3 px-6 focus:outline-none hover:bg-gray-700   rounded `}
              onClick={() => addProductToCart(product)}
            >
              Add to Cart
            </button>
          </div>
        </div>
      </div>
    </div>
  );
};

export default DetailProductCard;
