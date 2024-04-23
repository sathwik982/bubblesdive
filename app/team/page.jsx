import BreadCrumbs from "@/components/BreadCrumbs";
import TeamCard from "@/components/team/TeamCard";
import React from "react";

export const metadata = {
  title: "Team | Bubbles Diving Center",
  description: "Bubbles Diving Center",
};

const Team = () => {
  return (
    <div>
      <BreadCrumbs heading={"Our Team"} />
      <div className="mt-10 mb-20 max-w-[1300px] mx-auto px-3 md:px-5 lg:px-8">
        <TeamCard />
      </div>
    </div>
  );
};

export default Team;
