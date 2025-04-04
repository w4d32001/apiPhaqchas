/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: {
                    50: "#fff7eb",
                    100: "#ffeed0",
                    200: "#ffd8a1",
                    300: "#ffba65",
                    400: "#ff8f27",
                    500: "#ff6e00",
                    600: "#ff4f00",
                    700: "#d63800",
                    800: "#a92d03",
                    900: "#922a07",
                    950: "#4a1000",
                },
                secondary: {
                    50: "#fdfaed",
                    100: "#f8f0cd",
                    200: "#f1df96",
                    300: "#e9c960",
                    400: "#e4b53b",
                    500: "#dc9824",
                    600: "#c3751c",
                    700: "#a2551b",
                    800: "#84431c",
                    900: "#6d381a",
                    950: "#3e1c0a",
                },'palm': {
                    '50': '#f2fde8',
                    '100': '#e1fbcc',
                    '200': '#c5f6a0',
                    '300': '#9fee68',
                    '400': '#7de13a',
                    '500': '#5dc71b',
                    '600': '#449f11',
                    '700': '#367912',
                    '800': '#2e6014',
                    '900': '#295116',
                    '950': '#0e2405',
                },

            },
            backgroundImage: {
                fondo: "url('/images/paqchas.webp')",
            },
            textShadow: {
                default: "2px 2px 4px rgba(0, 0, 0, 0.5)",
                heavy: "10px 10px 12px rgba(0, 0, 0, 0.75)",
                neutro: "10px 10px 12px rgba(255, 255, 255, 1)",
            },
            fontFamily: {
                rubik: ["Rubik Mono One", "sans-serif"],
                bungee: ["Bungee Inline", "sans-serif"],
            }
        },
    },
    plugins: [
        require("tailwindcss-textshadow"),
    ],
};
