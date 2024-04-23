"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import { truncate } from "@/lib/trucate";
import Link from "next/link";
import { MdAddShoppingCart } from "react-icons/md";
import React from "react";
import { useProductContext } from "@/hooks/ProductContext";

const FeaturedProducts = ({ product }) => {
  const { isDarkMode } = useThemeContext();
  const { addProductToCart } = useProductContext();
  return (
    <div
      className={`w-[250px] max-w-[250px]  hover:scale-105 shadow-lg rounded-lg ${
        isDarkMode ? "bg-gray-800" : "bg-white border"
      }`}
     
    >
      <Link  href={`/products/${product?.id}`}>
        <img
          className="  object-cover h-48 w-full  rounded-t-lg "
          src={product?.image}
          alt="product image"
        />
      </Link>
      <div className="px-5 my-3">
        <h5 className={`${isDarkMode ? "text-gray-300" : "text-gray-900"}`}>
          {truncate(product?.title, 20)}
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
  );
};

export default FeaturedProducts;
