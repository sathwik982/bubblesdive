"use client";
import BreadCrumbs from "@/components/BreadCrumbs";
import { useThemeContext } from "@/hooks/ThemeContext";
import { truncate } from "@/lib/trucate";
import Link from "next/link";
import React from "react";

const ArticleCard = () => {
  const { isDarkMode } = useThemeContext();
  const articles = [
    {
      id: "1",
      title: "We are honored to present our high quality products and services",
      category: "Dive Computers",
      description:
        "Our company has great experience and perfect reputation in this sphere. We are honored to present our high quality products and services. Our dedicated team of experienced instructors is always available to help you. Our employees put in great efforts to produce and prepare these commodities. Our goods were made up by the best experts with the help of most advanced technologies, and it gives us the right to consider these products to be premium.Our unbelievable variety will be a pleasant surprise for you. You can rely on our reputation because we provide only branded commodities. We assume that mutual trust is the base for the good cooperation. The goods of our store are very reliable and durable. We care about the safety of our clients because it is a base of our success. That is why we have so many devoted clients and friends all over the country.",
      image:
        "https://cdn.shopify.com/s/files/1/0538/4028/1792/t/8/assets/pf-fec717a4--googlecover.jpg?v=1620923457",
      commentsCount: 4,
      date: "2021-08-30",
    },
    {
      id: "2",
      title:
        "Our company has great experience and perfect reputation in this sphere",
      category: "Dive Planning",
      description:
        " Lorem ipsum dolor sit amet consectetur, adipisicing elit. Neque numquam, nobis porro perferendis, similique autem deserunt fugit cupiditate optio consequatur eaque ipsam commodi et enim aperiam accusantium. Itaque eum rem voluptates incidunt accusamus. Hic culpa, a accusantium quibusdam inventore quam adipisci repellendus id unde, quaerat excepturi ipsa commodi sapiente mollitia!",
      image: "https://dipndive.com/cdn/shop/articles/air.jpg?v=1624989323",
      commentsCount: 1,
      date: "2021-08-30",
    },
    {
      id: "3",
      title:
        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, aperiam.",
      category: "Fins",
      description:
        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio quibusdam quos nam officiis doloribus rerum quae quaerat odit quo placeat.dddd   ",
      image:
        "https://dipndive.com/cdn/shop/articles/photo_two.jpg?v=1651592556",
      commentsCount: 3,
      date: "2024-09-30",
    },
    {
      id: "4",
      title: "Underwater Photography Glossary",
      category: "Underwater",
      description:
        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio quibusdam quos nam officiis doloribus rerum quae quaerat odit quo placeat.dddd   ",
      image:
        "https://dipndive.com/cdn/shop/articles/underwaterphoto2.jpg?v=1634738628",
      commentsCount: 3,
      date: "2024-09-30",
    },
    {
      id: 3,
      title:
        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Qui, aperiam.",
      description:
        "Lorem ipsum dolor sit amet consectetur adipisicing elit. Odio quibusdam quos nam officiis doloribus rerum quae quaerat odit quo placeat.dddd   ",
      image:
        "https://dipndive.com/cdn/shop/articles/photo_two.jpg?v=1651592556",
      commentsCount: 3,
      date: "2024-09-30",
    },
  ];
  return (
    <div className={`min-h-screen ${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
      <BreadCrumbs heading={"Article"} />
      <div className="px-3 py-10 md:py-14 min-h-screen  w-full flex gap-5 flex-wrap justify-center">
        {articles.map((article, idx) => (
          <div
            className={`max-w-[400px] md:min-h-[580px] lg:min-h-[520px] h-fit group   shadow-lg rounded-lg pb-2 md:pb-0 ${
              isDarkMode ? "bg-gray-800" : "bg-white border"
            }`}
            key={idx}
          >
            <img
              src={article.image}
              
              alt={"article title"}
              className="w-full  rounded-md h-[220px] object-cover overflow-hidden"
            />
            <div className="py-1 px-3">
              <h2
                className={`font-medium ${
                  isDarkMode
                    ? "text-white group-hover:text-blue-700"
                    : "text-gray-900  group-hover:text-primary"
                } mb-3 text-lg`}
              >
                {truncate(article.title, 50)}
              </h2>

              <h3
                className={`${
                  isDarkMode ? "text-gray-300" : "text-gray-500"
                } mb-3 px-2`}
              >
                {article?.category}
              </h3>

              <p
                className={` ${
                  isDarkMode ? "text-gray-400" : "text-gray-500"
                } mb-4 text-sm md:text-base px-2`}
              >
                {truncate(article.description, 200)}
              </p>

              <div className="text-center w-full ">
                <Link
                  className={`${
                    isDarkMode ? "text-blue-700" : "text-primary"
                  } font-bold text-center  w-full uppercase `}
                  href={`/article/${article.id}`}
                >
                  read more
                </Link>
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default ArticleCard;
