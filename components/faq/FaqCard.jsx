"use client"
import React, { useState, useEffect } from "react";
import axios from "axios";
import { useThemeContext } from "@/hooks/ThemeContext";
import Image from "next/image";
import Link from "next/link";
import { FaPlus, FaMinus } from "react-icons/fa6";
import bg from "../../lib/assets/home/home-1.jpg";

const FaqCard = () => {
  const [showAnswer, setShowAnswer] = useState(null);
  const { isDarkMode } = useThemeContext();
  const [faqs, setFaqs] = useState([]);

  useEffect(() => {
    const fetchFaqs = async () => {
      try {
        const response = await axios.get("faq.php");
        console.log(response);
        if (response.data.status === "success") {
          setFaqs(response.data.faqs);
        } else {
          console.error("Failed to fetch FAQs:", response.data.message);
        }
      } catch (error) {
        console.error("Error fetching FAQs:", error);
      }
    };

    fetchFaqs();
  }, []);

  const handleToggleAnswer = (index) => {
    setShowAnswer((prevIndex) => (prevIndex === index ? null : index));
  };

  return (
    <div className={`${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
      <div className="relative">
        <Image
          src={bg}
          className="w-full h-[250px] lg:h-[280px]  object-cover filter brightness-50"
        />
        <div className="max-w-[1100px] mx-auto px-2">
          <div className=" absolute text-center  bottom-4 md:bottom-12 flex flex-col gap-5 items-center  ">
            <h2 className="text-white font-semibold text-xl md:text-2xl lg:text-3xl w-full text-center">
              Frequently Asked Questions
            </h2>
            <p className="text-gray-300 text-center text-sm md:text-base">
              Got a question? We&apos;ve got answers. If you have some other
              questions, feel free to send us an email to{" "}
              <Link
                href="mailto:info@bubblesdivingcenter.com"
                className="text-blue-700 font-medium"
              >
                info@bubblesdivingcenter.com
              </Link>
            </p>
          </div>
        </div>
      </div>
      <div>
        <div className="grid grid-cols-1  gap-5 pt-10 pb-20 max-w-[1200px] mx-auto px-3 md:px-5">
          {faqs.map((faq, index) => (
            <div
              className="max-w-[1000px] w-full mx-auto"
              key={faq.id}
              onClick={() => handleToggleAnswer(index)}
            >
              <div
                className={` border-t ${
                  isDarkMode ? "border-gray-500" : "border-gray-500"
                } p-4 flex flex-col gap-2 `}
              >
                <div className="flex items-center justify-between cursor-pointer">
                  <h2
                    className={`text-base md:text-lg ${
                      isDarkMode ? "text-gray-300" : "text-black"
                    } font-medium `}
                  >
                    {faq.question}
                  </h2>
                  <div
                    className={`${
                      isDarkMode ? "text-gray-400" : "text-gray-500"
                    } focus:outline-none`}
                    aria-expanded={showAnswer === index}
                    aria-label={
                      showAnswer === index ? "Collapse answer" : "Expand answer"
                    }
                  >
                    {showAnswer === index ? (
                      <FaMinus size={18} />
                    ) : (
                      <FaPlus size={18} />
                    )}
                  </div>
                </div>
                {showAnswer === index && (
                  <p
                    className={`${
                      isDarkMode ? "text-gray-400" : "text-gray-500"
                    } px-2`}
                  >
                    {faq.answer}
                  </p>
                )}
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};

export default FaqCard;
