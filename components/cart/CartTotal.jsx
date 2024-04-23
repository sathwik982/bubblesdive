"use client";
import React from "react";
import Link from "next/link";
import { useCourseContext } from "@/hooks/CourseContext";
import { useTripContext } from "@/hooks/TripContext";
import { useProductContext } from "@/hooks/ProductContext";
import { useThemeContext } from "@/hooks/ThemeContext";

const CartTotal = () => {
  const { courseCartTotal } = useCourseContext();
  const { tripCartTotal } = useTripContext();
  const { productCartTotal } = useProductContext();
  const { isDarkMode } = useThemeContext();
  const subTotal = courseCartTotal() + tripCartTotal() + productCartTotal();

  // Check if subTotal is a valid number
  const formattedSubTotal =
    typeof subTotal === "number" ? subTotal.toFixed(2) : "";
  return (
    <div
      className={`${
        isDarkMode ? "border-gray-400" : "border-gray-200"
      } border-t px-4 py-6 sm:px-6`}
    >
      <div
        className={`flex justify-between text-base font-medium ${
          isDarkMode ? "text-gray-300" : "text-gray-900"
        }`}
      >
        <p>Subtotal</p>
        <p className="tracking-wider font-semibold">KD{formattedSubTotal}</p>
      </div>
      <p
        className={`mt-0.5 text-sm ${
          isDarkMode ? "text-gray-400" : "text-gray-400"
        }`}
      >
        Shipping and taxes calculated at checkout.
      </p>
      <div className="mt-6">
        <Link
          href="/checkout"
          className={`flex items-center justify-center rounded-md border border-transparent ${
            isDarkMode ? "bg-blue-700" : "bg-primary"
          }  hover:bg-gray-700 px-6 py-3 text-base font-medium text-white shadow-sm`}
        >
          Checkout
        </Link>
      </div>
    </div>
  );
};

export default CartTotal;
