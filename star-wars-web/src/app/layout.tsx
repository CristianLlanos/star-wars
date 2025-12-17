import type { Metadata } from "next";
import { Geist, Geist_Mono } from "next/font/google";
import "./globals.css";

const geistSans = Geist({
  variable: "--font-geist-sans",
  subsets: [ "latin" ],
});

const geistMono = Geist_Mono({
  variable: "--font-geist-mono",
  subsets: [ "latin" ],
});

export const metadata: Metadata = {
  title: "Star Wars App",
  description: "Explore the Star Wars crew and movies.",
};

export default function RootLayout({
                                     children,
                                   }: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en">
    <body
      className={`${geistSans.variable} ${geistMono.variable} antialiased`}
    >

    <div className="layout">
      <header className="navbar">
        <div className="logo">
          <span className="sw-starter">
            SWStarter
          </span>
        </div>
      </header>

      <main className="content">
        {children}
      </main>

      <footer className="footer">
        <p>&copy; {new Date().getFullYear()} Star Wars Explorer</p>
      </footer>
    </div>
    </body>
    </html>
  );
}
