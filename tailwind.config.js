import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            colors: {
                // Latar & netral — biru-abu sejuk, bukan abu netral generik
                canvas: "#F4F7FB",
                ink: "#1E2A3A",

                // Identitas utama CalmAcad
                calm: {
                    50: "#EEF4FF",
                    100: "#DCE8FF",
                    400: "#5B82E0",
                    600: "#3454B4",
                    700: "#1E3A8A",
                },

                // Aksen tenang — selaras dengan tema "pulih"
                sage: {
                    100: "#E3F2EE",
                    400: "#4F9D8C",
                    600: "#2F7566",
                },

                // 5 tingkat stres — diambil persis dari basis pengetahuan dokumen
                level: {
                    normal: "#10B981",
                    ringan: "#F59E0B",
                    sedang: "#F97316",
                    berat: "#EF4444",
                    kritis: "#7C3AED",
                },
            },

            fontFamily: {
                display: ['"Fraunces"', ...defaultTheme.fontFamily.serif],
                sans: ['"Inter"', ...defaultTheme.fontFamily.sans],
                mono: ['"IBM Plex Mono"', ...defaultTheme.fontFamily.mono],
            },

            boxShadow: {
                soft: "0 1px 2px rgba(30,42,58,0.04), 0 8px 24px -8px rgba(30,42,58,0.10)",
            },

            borderRadius: {
                xl2: "1.25rem",
            },
        },
    },

    plugins: [],
};
