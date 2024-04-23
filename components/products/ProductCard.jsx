"use client";
import BreadCrumbs from "@/components/BreadCrumbs";
import { useThemeContext } from "@/hooks/ThemeContext";
import { useProductContext } from "@/hooks/ProductContext.jsx";
import { truncate } from "@/lib/trucate";
import Link from "next/link";
import React from "react";
import { MdAddShoppingCart } from "react-icons/md";
const bg = require("../../lib/assets/home/water2.jpg");

const ProductCard = () => {
  const { isDarkMode } = useThemeContext();
  const products = [
    {
      id: 1,
      title: "Dive Mask",
      price: 49.99,
      image:
        "https://media.istockphoto.com/id/576724556/photo/underwater-scuba-diver-making-self-portrait-or-selfie.jpg?s=1024x1024&w=is&k=20&c=OZ9nu6PLY-bDHtnQ3hI1D-7WR07BL-BvWdv8U1lNku4=",
    },
    {
      id: 2,
      title: "Wetsuit",
      price: 199.99,
      image:
        "https://media.istockphoto.com/id/1409271873/vector/full-body-diving-wetsuit-with-back-zipper-flat-sketch-design-illustration-one-piece-diving.jpg?s=612x612&w=0&k=20&c=Xn44PRs4HAPeC0WAJ5-1tHzMYCtHVIqo_EM758EjMZM=",
    },
    {
      id: 3,
      title: "Fins",
      price: 79.99,
      image:
        "https://media.istockphoto.com/id/171358712/photo/scuba-diving-fins-flippers.jpg?s=1024x1024&w=is&k=20&c=Cz7YRF69KaZEXdHc_lXBJ-E3CV1lPrHbAFqNWRWrSHg=",
    },
    {
      id: 4,
      title: "Regulator Set",
      price: 399.99,
      image:
        "https://media.istockphoto.com/id/1163553758/photo/scuba-diving-air-tank-with-regulator-set-3d-rendering-illustration.jpg?s=1024x1024&w=is&k=20&c=GRM9vUs-XX0ZGeIk2V_FLfUjSQJEtwvqRuCnIA8wgfE=",
    },
    {
      id: 5,
      title: "BCD (Buoyancy Control Device)",
      price: 299.99,
      image:
        "data:image/jpeg;base64,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",
    },
    {
      id: 6,
      title: "Dive Computer",
      price: 349.99,
      image:
        "https://media.istockphoto.com/id/1395541847/photo/dive-computer.jpg?s=1024x1024&w=is&k=20&c=2AV5L-TU1cjJBLgLRg8AohWdiGNNF-aIIru1hF79sXM=",
    },
    {
      id: 7,
      title: "Dive Light",
      price: 99.99,
      image:
        "https://media.istockphoto.com/id/1161346810/photo/modern-black-collimator-sight-isolated-on-white-background.jpg?s=1024x1024&w=is&k=20&c=w9crsidXDfY0F3PoBo90ReCBWycb9hkyAhOmy31PYiU=",
    },
    {
      id: 8,
      title: "Dive Knife",
      price: 59.99,
      image:
        "https://media.istockphoto.com/id/139693014/photo/scuba-diving-knive.jpg?s=1024x1024&w=is&k=20&c=LllyWobNNMv1EdlbL8cgkVudszbm0fkJpodHqVP1QIg=",
    },
    {
      id: 9,
      title: "Snorkel",
      price: 29.99,
      image:
        "https://media.istockphoto.com/id/657795636/vector/dive-mask-and-snorkel-for-professionals-vector-illustration.jpg?s=612x612&w=0&k=20&c=7mjepbOjguBfVxBWRtephBtvqdO0UpApokHVeTXmA-s=",
    },
    {
      id: 10,
      title: "Underwater Camera",
      price: 499.99,
      image:
        "https://media.istockphoto.com/id/1401035031/photo/action-camera-in-the-water-in-a-protected-waterproof-case.jpg?s=1024x1024&w=is&k=20&c=krQ23lKRSsAZFr1ga17-vO78aJ8K1c4lapE9pjICxNw=",
    },
  ];
  const { addProductToCart } = useProductContext();

  return (
    <div className={`min-h-screen ${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
      <BreadCrumbs heading={"Products"} />
      <div className="flex py-10 md:py-14 lg:py-20  gap-5 justify-center flex-wrap max-w-[1300px] mx-auto">
        {products.map((product, idx) => (
          <div
            className="w-[300px]  hover:scale-105"
           
            key={idx}
          >
            <Link  href={`/products/${product.id}`}>
              <img
                className="  object-cover h-60 w-full px-3 rounded-lg hover:opacity-50"
                src={product.image}
                alt="product image"
              />
            </Link>
            <div className="px-5 my-3">
              <h5
                className={`${isDarkMode ? "text-gray-300" : "text-gray-900"}`}
              >
                {truncate(product.title, 20)}
              </h5>

              <div className="flex items-center justify-between mt-2 mb-5 ">
                <div
                  className={`font-bold ${
                    isDarkMode ? "text-blue-700" : "text-primary"
                  }`}
                >
                  KD {product?.price}
                </div>
                <button
                  className={`${isDarkMode ? "bg-blue-700" : "bg-primary"} p-2`}
                  onClick={() => addProductToCart(product)}
                >
                  <MdAddShoppingCart className="text-white" size={24} />
                </button>
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default ProductCard;
