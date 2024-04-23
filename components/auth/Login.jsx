"use client";
import { useState } from "react";
import Image from "next/image";
import logo from "@/lib/assets/logo.svg";
import { IoMdEye, IoMdEyeOff } from "react-icons/io";
import { useRouter } from "next/navigation";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import { useThemeContext } from "@/hooks/ThemeContext";

const Login = ({ onClick }) => {
  const { isDarkMode } = useThemeContext();
  const [showPassword, setShowPassword] = useState(false);
  const router = useRouter();
  const [formData, setFormData] = useState({
    username: "",
    password: "",
  });

  const [errors, setErrors] = useState({
    username: "",
    password: "",
  });

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });

    setErrors({
      ...errors,
      [e.target.name]: "",
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    let formIsValid = true;
    toast.dismiss();
    if (formData.username.trim() === "") {
      setErrors((prevErrors) => ({
        ...prevErrors,
        username: "Username is required",
      }));
      formIsValid = false;
      toast.error("Username is required");
    } else if (formData.password.trim() === "") {
      setErrors((prevErrors) => ({
        ...prevErrors,
        password: "Password is required",
      }));
      formIsValid = false;
      toast.error("Password is required");
    } else {
      //   if (formIsValid) {
      //     try {
      //       const response = await axios.post(
      //         "https://d-backend-ct.vercel.app/admin/login",
      //         formData
      //       );
      //       localStorage.setItem("token", response.data.response);
      //       localStorage.setItem("username", formData.username);
      //       toast.success("Logged in sucessfully");
      //       router.push("/dashboard/doctors");
      //     } catch (error) {
      //       toast.error("Invalid username or password");
      //     }
      //   }
      router.push("/");
    }
  };

  return (
    <section className={`${isDarkMode ? " bg-gray-900" : "bg-gray-100"}`}>
      <ToastContainer />
      <div className="flex flex-col items-center min-h-dvh justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div
          className={`w-full ${
            isDarkMode ? "bg-gray-800" : "bg-white border"
          }  rounded-lg shadow-xl md:mt-0 max-w-[400px] xl:p-0`}
        >
          <div className="p-6 space-y-4 md:space-y-6 sm:p-8">
            <div className="flex items-center justify-center mb-6 text-2xl font-semibold text-gray-900 ">
              <Image className="w-40 h-18 mr-2" src={logo} alt="logo" />
            </div>
            <h1
              className={`text-xl font-semibold leading-tight tracking-tight  ${
                isDarkMode ? "text-white" : "text-gray-900"
              } md:text-2xl mb-5 text-center`}
            >
              Log in to your account
            </h1>
            <form className="space-y-4 md:space-y-6">
              <div>
                <label
                  htmlFor="username"
                  className={`block mb-2 text-sm font-medium  ${
                    isDarkMode ? "text-gray-300" : "text-gray-900 "
                  }`}
                >
                  Username
                </label>
                <input
                  type="text"
                  name="username"
                  id="username"
                  value={formData.username}
                  onChange={handleChange}
                  className={` ${
                    isDarkMode
                      ? "text-gray-300 bg-gray-700"
                      : "text-gray-900 bg-gray-50 border border-gray-300 focus:border-primary"
                  }   sm:text-sm rounded-lg focus:outline-none  block w-full p-2.5 ${
                    errors.username && "border-red-500"
                  }`}
                />
              </div>
              <div>
                <label
                  htmlFor="password"
                  className={`block mb-2 text-sm font-medium  ${
                    isDarkMode ? "text-gray-300" : "text-gray-900 "
                  }`}
                >
                  Password
                </label>
                <div
                  className={`flex items-center ${
                    isDarkMode
                      ? "text-gray-300 bg-gray-700"
                      : " bg-gray-50 border border-gray-300"
                  }   sm:text-sm rounded-lg focus:outline-none focus:border-primary justify-between p-2.5 ${
                    errors.password && "border-red-500"
                  }`}
                >
                  <input
                    type={showPassword ? "text" : "password"}
                    name="password"
                    id="password"
                    value={formData.password}
                    onChange={handleChange}
                    className="outline-none w-full bg-transparent"
                  />
                  <button
                    type="button"
                    onClick={() => setShowPassword(!showPassword)}
                    className={`${isDarkMode && "text-gray-300"}`}
                  >
                    {showPassword ? (
                      <IoMdEyeOff size={20} />
                    ) : (
                      <IoMdEye size={20} />
                    )}
                  </button>
                </div>
              </div>

              <button
                type="submit"
                className={`w-full ${
                  isDarkMode ? "bg-blue-700" : "bg-primary"
                }   hover:bg-gray-500 text-white focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 text-center mt-3`}
              >
                Log in
              </button>
              <button
                className={`text-center w-full ${
                  isDarkMode && "text-gray-300"
                }`}
                onClick={() => onClick()}
              >
                Don&apos;t have an account?{" "}
                <span
                  className={`${
                    isDarkMode ? "text-blue-700" : "text-primary"
                  } font-medium`}
                >
                  Signup
                </span>
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>
  );
};
export default Login;
