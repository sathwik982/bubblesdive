import Link from "next/link";
import React from "react";
import ProductCard from "../products/ProductCard";

const HomeProducts = () => {
  const scubaDivingProducts = [
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
  ];
  return (
    <div className="max-w-[1300px] mx-auto my-10 lg:my-20">
      <div className="flex justify-between  items-center px-2">
        <p className="font-semibold text-xl ">Featured Products</p>
        <Link className="  text-primary font-bold" href={"/products"}>
          View All
        </Link>
      </div>
      <div className="flex gap-5 my-5 flex-wrap justify-center">
        {scubaDivingProducts.map((product) => (
          <ProductCard product={product} key={product.id} />
        ))}
      </div>
    </div>
  );
};

export default HomeProducts;
