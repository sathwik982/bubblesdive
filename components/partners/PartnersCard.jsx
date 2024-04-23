import Image from "next/image";
import React from "react";

const PartnersCard = ({ partner }) => {
  return (
    <div className="  ">
      {/* <Image alt="" src={partner.image} className="h-24 w-24 object-contain" /> */}
      {partner.image}
    </div>
  );
};

export default PartnersCard;
