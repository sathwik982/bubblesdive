"use client";


import Login from "@/components/auth/Login";
import Signup from "@/components/auth/Signup";
import { useRouter } from "next/navigation";
useRouter;
import React, { useState } from "react";


const Auth = () => {
  const router = useRouter();
  const [isLogin, setIsLogin] = useState(true);
  const setLogin = () => {
    setIsLogin(!isLogin);
  };
  

  return (
    <>
      
      {isLogin ? <Login onClick={setLogin} /> : <Signup onClick={setLogin} />}
    </>
  );
};

export default Auth;