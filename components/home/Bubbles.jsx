import React, { useEffect, useState } from "react";

const Bubbles = () => {
  const [bubbleElements, setBubbleElements] = useState([]);

  useEffect(() => {
    const bArray = [];
    const sArray = [4, 6, 8, 10, 12, 14, 16, 18];

    for (let i = 0; i < document.querySelector(".bubbles").clientWidth; i++) {
      bArray.push(i);
    }

    const generatedBubbles = sArray.map((item, index) => {
      const randomValue = (arr) => arr[Math.floor(Math.random() * arr.length)];
      const size = randomValue(sArray);
      const delay = Math.random() * 10; // Random delay for each bubble
      return {
        key: index,
        style: {
          left: `${randomValue(bArray)}px`,
          width: `${size}px`,
          height: `${size}px`,
          animationDelay: `${delay}s`, // Set animation delay
        },
      };
    });

    setBubbleElements(generatedBubbles);

    // Clean-up function, runs only once when the component unmounts
    return () => {
      // Perform clean-up here if necessary
    };
  }, []); // Empty dependency array ensures that this effect runs only once

  return (
    <div className="underwater-body relative overflow-hidden">
      <div className="hidden bubbles absolute -z-0">
        {bubbleElements.map((bubble, index) => (
          <div
            key={index}
            className="individual-bubble absolute"
            style={{ ...bubble.style }}
          ></div>
        ))}
      </div>
    </div>
  );
};

export default Bubbles;
