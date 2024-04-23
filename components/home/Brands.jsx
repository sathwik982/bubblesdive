import Image from "next/image";
import React from "react";
import bg from "../../lib/assets/home/brands.webp"

const Brands = () => {
  return (
    <div className="relative w-full my-10 lg:my-20">
      <Image
        src={bg}
        className="object-cover w-full h-auto"
        layout="responsive"
        width={2500}
        height={2000} alt="brands"
      />
    </div>
  );
};

export default Brands;
