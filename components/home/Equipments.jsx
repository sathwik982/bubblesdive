import Image from "next/image";
import React from "react";
import mask from "../../lib/assets/equipments/mask.webp";
import tank from "../../lib/assets/equipments/tank.webp";
import watch from "../../lib/assets/equipments/watch.webp";
import fin from "../../lib/assets/equipments/fin.png";
import flashlight from "../../lib/assets/equipments/flash-light.webp";
import windrose from "../../lib/assets/equipments/windrose.webp";

const Equipments = () => {
  const datas = [
    {
      imageUrl: mask,
      title: "mask & snorkel",
    },
    {
      imageUrl: tank,
      title: "twin tank",
    },
    {
      imageUrl: watch,
      title: "diving watch",
    },
    {
      imageUrl: fin,
      title: "fins",
    },
    {
      imageUrl: flashlight,
      title: "flash light",
    },
    {
      imageUrl: windrose,
      title: "windroses",
    },
  ];
  return (
    <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 mx-auto my-10 px-5 md:px-10 justify-center">
      {datas.map((data, index) => (
        <div key={index} className="px-auto text-center mt-3 group">
          <Image
            className="text-center px-2 mx-auto hover:text-primary"
            height="100"
            width="100"
            src={data.imageUrl}
            alt={data.title}
          />
          <h4 className="uppercase font-semibold mt-3 group-hover:text-primary">
            {data.title}
          </h4>
        </div>
      ))}
    </div>
  );
};

export default Equipments;
