"use client";
import { createContext, useState, useEffect, useContext } from "react";

const TripContext = createContext();

export const useTripContext = () => {
  const context = useContext(TripContext);
  return context;
};

export const TripContextProvider = ({ children }) => {
  const [tripItems, setTripItems] = useState(() => {
    // Check if localStorage is available before accessing it
    if (typeof window !== "undefined") {
      const storedTripItems = JSON.parse(localStorage.getItem("tripItems"));
      return storedTripItems || [];
    } else {
      return [];
    }
  });

  useEffect(() => {
    // Check if localStorage is available before using it
    if (typeof window !== "undefined") {
      localStorage.setItem("tripItems", JSON.stringify(tripItems));
    }
  }, [tripItems]);

  const addTripToCart = (trip) => {
    const isTripInCart = tripItems.find(
      (tripItems) => tripItems.id === trip.id
    );

    if (isTripInCart) {
      setTripItems(
        tripItems.map((tripItem) =>
          tripItem.id === trip.id
            ? { ...tripItem, quantity: tripItem.quantity + 1 }
            : tripItem
        )
      );
    } else {
      setTripItems([...tripItems, { ...trip, quantity: 1 }]);
    }
  };

  const removeTripFromCart = (trip) => {
    const isTripInCart = tripItems.find((tripItem) => tripItem.id === trip.id);

    if (isTripInCart?.quantity === 1) {
      setTripItems(tripItems.filter((tripItem) => tripItem.id !== trip.id));
    } else {
      setTripItems(
        tripItems.map((tripItem) =>
          tripItem.id === trip.id
            ? { ...tripItems, quantity: (tripItem.quantity || 0) - 1 }
            : tripItem
        )
      );
    }
  };

  const clearTripFromCart = (id) => {
    setTripItems(tripItems.filter((tripItem) => tripItem.id !== id));
  };

  const tripCartTotal = () => {
    return tripItems.reduce(
      (total, item) => total + item.price * item.quantity,
      0
    );
  };


  return (
    <TripContext.Provider
      value={{
        tripItems,
        addTripToCart,
        removeTripFromCart,
        clearTripFromCart,
        tripCartTotal,
      }}
    >
      {children}
    </TripContext.Provider>
  );
};
