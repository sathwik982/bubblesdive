"use client";
import { createContext, useState, useContext, useEffect } from "react";

const ProductContext = createContext();

export const useProductContext = () => {
  const context = useContext(ProductContext);
  return context;
};

export const ProductContextProvider = ({ children }) => {
  const [productItems, setProductItems] = useState(() => {
    // Check if localStorage is available before accessing it
    if (typeof window !== "undefined") {
      const storedProductItems = JSON.parse(
        localStorage.getItem("productItems")
      );
      return storedProductItems || [];
    } else {
      return [];
    }
  });

  useEffect(() => {
    // Check if localStorage is available before using it
    if (typeof window !== "undefined") {
      localStorage.setItem("productItems", JSON.stringify(productItems));
    }
  }, [productItems]);

  const addProductToCart = (product) => {
    const isProductInCart = productItems.find(
      (productItem) => productItem.id === product.id
    );

    if (isProductInCart) {
      setProductItems(
        productItems.map((productItem) =>
          productItem.id === product.id
            ? { ...productItem, quantity: productItem.quantity + 1 }
            : productItem
        )
      );
    } else {
      setProductItems([...productItems, { ...product, quantity: 1 }]);
    }
  };

  const removeProductFromCart = (product) => {
    const isCourseInCart = productItems.find(
      (productItem) => productItem.id === product.id
    );

    if (isCourseInCart?.quantity === 1) {
      setProductItems(
        productItems.filter((productItem) => productItem.id !== product.id)
      );
    } else {
      setProductItems(
        productItems.map((productItem) =>
          productItem.id === product.id
            ? { ...productItem, quantity: (productItem.quantity || 0) - 1 }
            : productItem
        )
      );
    }
  };

  const clearProductFromCart = (id) => {
    setProductItems(
      productItems.filter((productItem) => productItem.id !== id)
    );
  };

  const productCartTotal = () => {
    return productItems.reduce(
      (total, item) => total + item.price * item.quantity,
      0
    );
  };

  return (
    <ProductContext.Provider
      value={{
        productItems,
        addProductToCart,
        removeProductFromCart,
        clearProductFromCart,
        productCartTotal,
      }}
    >
      {children}
    </ProductContext.Provider>
  );
};
