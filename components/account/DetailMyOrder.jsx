"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import { truncate } from "@/lib/trucate";
import Link from "next/link";
import React from "react";
import BreadCrumbs from "../BreadCrumbs";

const DetailMyOrder = () => {
  const { isDarkMode } = useThemeContext();
  const orders = [
    {
      orderNumber: "1222",
      date: "April 14, 2023",
      totalAmt: 100,
      products: [
        {
          title: "Dive Mask",
          category: "Accessories",
          productId: 1,
          price: 49.99,
          image:
            "https://media.istockphoto.com/id/576724556/photo/underwater-scuba-diver-making-self-portrait-or-selfie.jpg?s=1024x1024&w=is&k=20&c=OZ9nu6PLY-bDHtnQ3hI1D-7WR07BL-BvWdv8U1lNku4=",
          quantity: 2,
        },
        {
          title: "Wetsuit",
          category: "Apparel",
          price: 50,
          productId: 2,
          image:
            "https://media.istockphoto.com/id/1409271873/vector/full-body-diving-wetsuit-with-back-zipper-flat-sketch-design-illustration-one-piece-diving.jpg?s=612x612&w=0&k=20&c=Xn44PRs4HAPeC0WAJ5-1tHzMYCtHVIqo_EM758EjMZM=",
          quantity: 1,
        },
      ],
    },
    {
      orderNumber: "23322",
      date: "April 24, 2023",
      totalAmt: 200,
      products: [
        {
          title: "Fins",
          category: "Accessories",
          productId: 1,
          price: 79.99,
          image:
            "https://media.istockphoto.com/id/171358712/photo/scuba-diving-fins-flippers.jpg?s=1024x1024&w=is&k=20&c=Cz7YRF69KaZEXdHc_lXBJ-E3CV1lPrHbAFqNWRWrSHg=",
          quantity: 2,
        },
        {
          title: "Regulator Set",
          category: "Equipment",
          productId: 2,
          price: 399.99,
          image:
            "https://media.istockphoto.com/id/1163553758/photo/scuba-diving-air-tank-with-regulator-set-3d-rendering-illustration.jpg?s=1024x1024&w=is&k=20&c=GRM9vUs-XX0ZGeIk2V_FLfUjSQJEtwvqRuCnIA8wgfE=",
          quantity: 1,
        },
      ],
    },
  ];
  return (
    <div className={`${isDarkMode ? "bg-gray-900" : "bg-blue-100"}`}>
      <BreadCrumbs heading={"My Orders"} />
      <div className="mx-auto max-w-[1300px] pt-5 pb-10 md:pb-20 px-3 md:px-5 ">
        <>
          {orders.map((order) => (
            <div
              key={order.orderNumber}
              className="flex flex-col  py-5 md:py-10 "
            >
              <div
                className={`flex justify-between  ${
                  isDarkMode ? "bg-gray-800 border-gray-500" : "bg-white "
                } p-5 flex-wrap gap-5 border-b rounded-t-lg`}
              >
                <div className="flex flex-col gap-2">
                  <h3 className={`font-semibold ${isDarkMode && "text-white"}`}>
                    Order number
                  </h3>
                  <p
                    className={`px-1 ${
                      isDarkMode ? "text-gray-300" : "text-gray-700"
                    } font-medium`}
                  >
                    {order.orderNumber}
                  </p>
                </div>
                <div className="flex flex-col gap-2">
                  <h3 className={`font-semibold ${isDarkMode && "text-white"}`}>
                    Date placed
                  </h3>
                  <p
                    className={`px-1 ${
                      isDarkMode ? "text-gray-300" : "text-gray-700"
                    } font-medium`}
                  >
                    {order.date}
                  </p>
                </div>
                <div className="flex flex-col gap-2">
                  <h3 className={`font-semibold ${isDarkMode && "text-white"}`}>
                    Total Amount
                  </h3>
                  <p
                    className={`px-1 ${
                      isDarkMode ? "text-gray-300" : "text-gray-700"
                    } font-medium`}
                  >
                    KD {order.totalAmt}
                  </p>
                </div>
              </div>

              <div
                className={`${
                  isDarkMode ? "bg-gray-800" : "bg-white"
                } rounded-b-lg  `}
              >
                {order.products.map((product) => (
                  <Link
                    href={`/products/${product.productId}`}
                    key={product.title}
                    className={`flex gap-5 py-3 px-5 ${
                      !isDarkMode && "border-b"
                    } flex-wrap `}
                  >
                    <img
                      src={product.image}
                      alt={product.title}
                      className="h-48 w-48 object-cover "
                    />
                    <div className="p-4">
                      <h2
                        className={`text-lg font-semibold mb-2 ${
                          isDarkMode && "text-white"
                        }`}
                      >
                        {truncate(product.title, 30)}
                      </h2>
                      <p
                        className={`${
                          isDarkMode ? "text-gray-400" : "text-gray-500"
                        } mb-2 font-medium`}
                      >
                        {product.category}
                      </p>
                      <p
                        className={`${
                          isDarkMode ? "text-blue-700" : "text-primary"
                        }  mb-2 font-semibold`}
                      >
                        KD {product.price.toFixed(2)}
                      </p>
                      <p
                        className={`${
                          isDarkMode ? "text-gray-400" : "text-gray-500"
                        } mb-2 font-medium`}
                      >
                        Quantity: {product.quantity}
                      </p>
                    </div>
                  </Link>
                ))}
              </div>
            </div>
          ))}
        </>
      </div>
    </div>
  );
};

export default DetailMyOrder;
