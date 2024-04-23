"use client";
import { useThemeContext } from "@/hooks/ThemeContext";
import React from "react";
import BreadCrumbs from "../BreadCrumbs";

const TermsConditionCard = () => {
  const { isDarkMode } = useThemeContext();
  const termsAndConditionsData = [
    {
      title: "Booking and Payment",
      description:
        "All bookings require a deposit of 50% of the total price. The remaining balance is due before the start of the trip. Payments can be made via credit card or bank transfer. Prices are subject to change without notice.",
    },
    {
      title: "Cancellation Policy",
      description:
        "Cancellations made more than 30 days before the trip will receive a full refund. Cancellations made less than 30 days before the trip will not be eligible for a refund. No-shows will not be refunded.",
    },
    {
      title: "Health and Safety",
      description:
        "All participants must be in good health and free from any medical conditions that may be exacerbated by scuba diving. Participants must complete a medical questionnaire and may be required to provide a doctor's certificate of fitness to dive.",
    },
    {
      title: "Liability Waiver",
      description:
        "Participants must sign a liability waiver before participating in any scuba diving activities. By signing the waiver, participants acknowledge the risks involved in scuba diving and release the dive operator from any liability for accidents or injuries.",
    },
    {
      title: "Equipment Rental",
      description:
        "Equipment rental is available for an additional fee. Participants are responsible for the proper care and use of rental equipment. Any damage to rental equipment caused by negligence or misuse will be charged to the participant.",
    },
    {
      title: "Code of Conduct",
      description:
        "Participants must follow all instructions provided by the dive instructor or guide. They must also adhere to environmentally responsible diving practices, including avoiding contact with marine life and respecting underwater ecosystems.",
    },
    {
      title: "Weather and Conditions",
      description:
        "Dive trips are subject to weather and sea conditions. The dive operator reserves the right to cancel or reschedule trips in the event of adverse conditions. In such cases, alternative arrangements or refunds may be offered.",
    },
  ];
  return (
    <div className={`${isDarkMode ? "bg-gray-900" : "bg-white"}`}>
      <BreadCrumbs heading={"Terms and Conditions"} />
      <div className="min-h-screen pt-10 pb-20 max-w-[1300px] mx-auto px-3 md:px-5">
        {termsAndConditionsData.map((tandc, idx) => (
          <div
            className="px-2 md:px-5 py-5 md:py-8 flex-col flex gap-3"
            key={idx}
          >
            <h3
              className={`font-semibold text-xl ${
                isDarkMode ? "text-blue-700" : "text-primary"
              }`}
            >
              {tandc.title}
            </h3>
            <p
              className={`${
                isDarkMode ? "text-gray-400" : "text-gray-500"
              } px-1 md:px-2 max-w-[1000px]`}
            >
              {tandc.description}
            </p>
          </div>
        ))}
      </div>
    </div>
  );
};

export default TermsConditionCard;
