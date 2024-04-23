"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import React from "react";

const DetailArticleCard = ({ params }) => {
  const { isDarkMode } = useThemeContext();
  const article = {
    title: "Where Is My Buddy: What to Do if You Get Separated",
    category: "Dive Planning",
    description: `The buddy system is something that every diver learns during their very first certification course. No matter whether you are an experienced diver or a newbie, the general rule is that you should always dive with a partner. The most apparent reason for following the buddy system is that it can minimize the chances of diving accidents. Having someone at your side grants you a sense of safety and gives you confidence. Nevertheless, it may happen that you lose sight of each other during the dive. Getting separated from your buddy can be an unpleasant experience evoking anxiety and disorientation. So you should know how to prevent and deal with buddy separation if it does happen to you.
      Good preparation for your upcoming dive can decrease the chance of buddy separation greatly. You should thoroughly plan your dive with your buddy and determine clear rules for underwater communication. Specify the route and the maximum depth to avoid any misunderstanding once you are underwater. Moreover, as there are no standard rules for what to do in case of buddy separation, you and your dive partner should come up with a detailed plan of your actions in case you accidentally split up underwater. An explicit separation protocol is especially important if you are planning to dive on a drift dive or in low-light conditions. For instance, you can come up with specific light signals to communicate certain messages with your dive torches.
`,
    image: "https://dipndive.com/cdn/shop/articles/photo_two.jpg?v=1651592556",
  };

  return (
    <>
      <div className="">
        <div className={`pb-20 ${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
          <div className="">
            <img
              src={article.image}
              className="w-full h-[50vh] lg:h-[70vh] object-cover rounded-md"
              alt="article image"
            />
          </div>
          <div className="max-w-[1200px] mx-auto">
            <h2
              className={`my-3 md:my-5 px-3 font-semibold text-xl md:text-2xl lg:text-3xl ${
                isDarkMode ? "text-blue-700" : "text-primary"
              } `}
            >
              {article.title}
            </h2>
            <h3
              className={`my-3 md:my-5 px-8 font-medium ${
                isDarkMode ? "text-gray-300" : "text-gray-900"
              } `}
            >
              {article.title}
            </h3>
            <p
              className={`${
                isDarkMode ? "text-gray-400" : "text-gray-600"
              } px-8`}
            >
              {article.description}
            </p>
          </div>
        </div>
      </div>
    </>
  );
};

export default DetailArticleCard;
