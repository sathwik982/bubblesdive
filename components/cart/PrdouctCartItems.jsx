"use client";
import { useProductContext } from "@/hooks/ProductContext";
import { useThemeContext } from "@/hooks/ThemeContext";
import { truncate } from "@/lib/trucate";
import React from "react";

const ProductCartItems = ({ cartItems }) => {
  const { addProductToCart, removeProductFromCart, clearProductFromCart } =
    useProductContext();
  const { isDarkMode } = useThemeContext();
  return (
    <div className="">
      <ul role="list" className="md:my-6 ">
        {cartItems?.map((cart) => (
          <li
          className={`sm:flex py-5 px-3 ${
            cartItems.length >= 1 &&
            `${isDarkMode ? "border-t border-gray-500" : "border-gray-300 border-t"}`
          } `}
            key={cart?.id}
          >
            <div className="h-20 w-24 md:h-28 md:w-32 rounded-lg">
              <img
                src={cart.image}
                alt={cart.title}
                className={`h-full w-full object-cover rounded-lg object-center ${
                  !isDarkMode && "border"
                }`}
              />
            </div>

            <div className="flex  flex-col justify-between py-2 w-full">
              <div className="">
                <div className="flex justify-between text-base font-medium text-gray-900">
                  <h3
                    className={`font-medium ${
                      isDarkMode ? "text-blue-700" : "text-primary"
                    } text-sm md:text-base lg:text-lg px-2`}
                  >
                    {truncate(cart.title, 50)}
                  </h3>

                  <p
                    className={`md:px-4 font-semibold  ${
                      isDarkMode ? "text-gray-300" : "text-gray-900"
                    }`}
                  >
                    KD {cart?.price}
                  </p>
                </div>
                <p
                  className={`mt-1 text-sm ${
                    isDarkMode ? "text-gray-400" : "text-gray-500"
                  }   px-2`}
                >
                  {cart.category}
                </p>
              </div>

              <div className="flex w-full items-center mt-3 justify-between text-sm px-3">
                <div className="text-gray-500 flex items-center gap-2">
                  <button
                    className={`font-bold ${
                      isDarkMode ? "bg-blue-700" : "bg-primary"
                    } hover:bg-gray-700 px-2 text-white text-center`}
                    onClick={() => removeProductFromCart(cart)}
                  >
                    -
                  </button>
                  <p className={`${isDarkMode && "text-white"}`}>
                    {cart?.quantity}
                  </p>
                  <button
                    className={`font-bold ${
                      isDarkMode ? "bg-blue-700" : "bg-primary"
                    } hover:bg-gray-700 px-2 text-white text-center`}
                    onClick={() => addProductToCart(cart)}
                  >
                    +
                  </button>
                </div>

                <div className="flex">
                  <button
                    className={`font-semibold ${
                      isDarkMode ? "text-blue-700" : "text-primary"
                    }
                    `}
                    onClick={() => clearProductFromCart(cart.id)}
                  >
                    Remove
                  </button>
                </div>
              </div>
            </div>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default ProductCartItems;
