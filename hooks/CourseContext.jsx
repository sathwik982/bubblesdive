"use client";
import { createContext, useState, useEffect, useContext } from "react";

const CourseContext = createContext();

export const useCourseContext = () => {
  const context = useContext(CourseContext);
  return context;
};

export const CourseContextProvider = ({ children }) => {
  const [courseItems, setCourseItems] = useState(() => {
    // Check if localStorage is available before accessing it
    if (typeof window !== "undefined") {
      const storedCourseItems = JSON.parse(localStorage.getItem("courseItems"));
      return storedCourseItems || [];
    } else {
      return [];
    }
  });

  useEffect(() => {
    // Check if localStorage is available before using it
    if (typeof window !== "undefined") {
      localStorage.setItem("courseItems", JSON.stringify(courseItems));
    }
  }, [courseItems]);

  const addCourseToCart = (course) => {
    const isCourseInCart = courseItems.find(
      (courseItem) => courseItem.id === course.id
    );

    if (isCourseInCart) {
      setCourseItems(
        courseItems.map((courseItem) =>
          courseItem.id === course.id
            ? { ...courseItem, quantity: courseItem.quantity + 1 }
            : courseItem
        )
      );
    } else {
      setCourseItems([...courseItems, { ...course, quantity: 1 }]);
    }
  };

  const removeCourseFromCart = (course) => {
    const isCourseInCart = courseItems.find(
      (courseItem) => courseItem.id === course.id
    );

    if (isCourseInCart?.quantity === 1) {
      setCourseItems(
        courseItems.filter((courseItem) => courseItem.id !== course.id)
      );
    } else {
      setCourseItems(
        courseItems.map((courseItem) =>
          courseItem.id === course.id
            ? { ...courseItem, quantity: (courseItem.quantity || 0) - 1 }
            : courseItem
        )
      );
    }
  };

  const clearCourseFromCart = (id) => {
    setCourseItems(courseItems.filter((courseItem) => courseItem.id !== id));
  };

  const courseCartTotal = () => {
    return courseItems.reduce(
      (total, item) => total + item.price * item.quantity,
      0
    );
  };

  return (
    <CourseContext.Provider
      value={{
        courseItems,
        addCourseToCart,
        removeCourseFromCart,
        clearCourseFromCart,
        courseCartTotal,
      }}
    >
      {children}
    </CourseContext.Provider>
  );
};
