"use client";
import { useCourseContext } from "@/hooks/CourseContext";
import { useProductContext } from "@/hooks/ProductContext";
import { useThemeContext } from "@/hooks/ThemeContext";
import { useTripContext } from "@/hooks/TripContext";
import React from "react";
import { FaShoppingCart } from "react-icons/fa";
import CartTotal from "./CartTotal";
import CourseCartItems from "./CourseCartItems";
import ProductCartItems from "./PrdouctCartItems";
import TripCartItems from "./TripCartItems";

const CartCard = () => {
  const { isDarkMode } = useThemeContext();
  const { productItems } = useProductContext();
  const { courseItems } = useCourseContext();
  const { tripItems } = useTripContext();

  // Combine product, course, and trip items into a single array
  const cartItems = [
    ...productItems.map((item) => ({ ...item, category: "product" })),
    ...courseItems.map((item) => ({ ...item, category: "course" })),
    ...tripItems.map((item) => ({ ...item, category: "trip" })),
  ];

  return (
    <div className={`min-h-screen ${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
      <div className="w-full h-20 lg:h-[6.5rem] bg-primary"></div>
      <div className="w-3/4 m-auto max-md:w-full pb-20">
        {cartItems.length === 0 ? (
          <div className="flex items-center justify-center flex-col  gap-5 py-20">
            <h2
              className={`text-2xl font-medium ${
                isDarkMode ? "text-gray-300" : "text-gray-900"
              } text-center`}
            >
              Your Cart Is Empty!
            </h2>
            <FaShoppingCart
              style={{ height: "150px", width: "150px" }}
              className={`size-[150px] ${
                isDarkMode ? "text-gray-400" : "text-gray-700"
              }`}
            />
          </div>
        ) : (
          <div className="max-w-[1200px] mx-auto">
            <div className="my-5 md:my-8">
              <h2
                className={`text-2xl font-medium ${
                  isDarkMode ? "text-gray-300" : "text-gray-900"
                } text-center`}
              >
                Shopping cart
              </h2>
            </div>
            <ProductCartItems
              cartItems={cartItems.filter(
                (item) => item.category === "product"
              )}
            />
            <CourseCartItems
              cartItems={cartItems.filter((item) => item.category === "course")}
            />
            <TripCartItems
              cartItems={cartItems.filter((item) => item.category === "trip")}
            />

            <CartTotal />
          </div>
        )}
      </div>
    </div>
  );
};

export default CartCard;
