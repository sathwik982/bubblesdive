"use client";
import { useState, useEffect } from "react";

import sunnyImage from "../../lib/assets/weather/sunny.png";
import rainyImage from "../../lib/assets/weather/rainny.png";
import cloudyImage from "../../lib/assets/weather/cloudy.png";
import snowyImage from "../../lib/assets/weather/snowy.png";
import Image from "next/image";

const Weather = () => {
  const [weatherData, setWeatherData] = useState(null);
  const [weatherImage, setWeatherImage] = useState(null);

  useEffect(() => {
    const fetchWeatherData = async () => {
      try {
        // Get user's location
        navigator.geolocation.getCurrentPosition(async (position) => {
          const { latitude, longitude } = position.coords;

          // Fetch weather data using user's location
          const response = await fetch(
            `https://api.openweathermap.org/data/2.5/weather?lat=${latitude}&lon=${longitude}&appid=15bd4f1bb8999fd67e0147889a924d20&units=metric`
          );
          const data = await response.json();
          setWeatherData(data);

          // Check if weather information is available
          if (data.weather && data.weather.length > 0) {
            setWeatherImage(getWeatherImage(data.weather[0].id));
          } else {
            // If weather information is not available, set default image
            setWeatherImage(sunnyImage);
          }
        });
      } catch (error) {
        console.error("Error fetching weather data:", error);
      }
    };

    fetchWeatherData();
  }, []);

  const getWeatherImage = (weatherCode) => {
    
    switch (true) {
      case weatherCode >= 200 && weatherCode < 300:
        return rainyImage; // Thunderstorm
      case weatherCode >= 300 && weatherCode < 400:
        return rainyImage; // Drizzle
      case weatherCode >= 500 && weatherCode < 600:
        return rainyImage; // Rain
      case weatherCode >= 600 && weatherCode < 700:
        return snowyImage; // Snow
      case weatherCode === 800:
        return sunnyImage; // Clear
      case weatherCode >= 801 && weatherCode < 900:
        return cloudyImage; // Clouds
      default:
        return null;
    }
  };

  return (
    <div className="bg-primary p-4 rounded-lg shadow-md w-fit max-w-[1300px] ">
      {weatherData && (
        <div className="flex gap-1">
          <div>
            <p className="text-white font-medium text-2xl">
              {weatherData.main?.temp} °C
            </p>{" "}
            <p className="text-gray-100">
              {weatherData.weather[0].description}
            </p>
          </div>
          {weatherData.weather && weatherData.weather.length > 0 && (
            <div className="flex items-center">
              <Image
                src={weatherImage}
                alt={weatherData.weather[0].main}
                className="w-20 h-2w-20 mr-2"
              />
            </div>
          )}
        </div>
      )}
    </div>
  );
};

export default Weather;
