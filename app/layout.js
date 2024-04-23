import Header from "../components/header.jsx";
import Footer from "@/components/footer.jsx";

import { Poppins } from "next/font/google";
import "./globals.css";
import { LanguageContextProvider } from "@/hooks/LanguageContext.jsx";
import { ProductContextProvider } from "@/hooks/ProductContext.jsx";
import { TripContextProvider } from "@/hooks/TripContext.jsx";
import { CourseContextProvider } from "@/hooks/CourseContext.jsx";
import { ThemeContextProvider } from "@/hooks/ThemeContext.jsx";

const poppins = Poppins({
  subsets: ["latin"],
  weight: ["300", "400", "500", "600", "700", "800", "900"],
});

export const metadata = {
  title: "Bubbles Diving Center",
  description: "Bubbles Diving Center",
  icons: {
    icon: "/icon.png",
  },
};

export default function RootLayout({ children }) {
  return (
    <html lang="en">
      <body className={poppins.className}>
        <ThemeContextProvider>
          <LanguageContextProvider>
            <ProductContextProvider>
              <TripContextProvider>
                <CourseContextProvider>
                  <Header />
                  <div>{children}</div>
                  <Footer />
                </CourseContextProvider>
              </TripContextProvider>
            </ProductContextProvider>
          </LanguageContextProvider>
        </ThemeContextProvider>
      </body>
    </html>
  );
}
