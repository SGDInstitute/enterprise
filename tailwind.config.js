import preset from "./vendor/filament/support/tailwind.config.preset";

const colors = require("tailwindcss/colors");
const { fontFamily } = require("tailwindcss/defaultTheme");
const brandGreen = {
    50: "#F3F9F8",
    100: "#E6F2F2",
    200: "#C1DFDE",
    300: "#9CCCCA",
    400: "#51A6A3",
    500: "#07807B",
    600: "#06736F",
    700: "#044D4A",
    800: "#033A37",
    900: "#022625",
};

const brandYellow = {
    400: "#F4C33E",
    500: "#F2B716",
    600: "#D49F0C",
    700: "#ae820a",
    800: "#745707",
    900: "#3a2b03",
};

module.exports = {
    darkMode: "class",
    presets: [preset],
    content: [
        "./resources/**/*.blade.php",
        "./app/Filament/**/*.php",
        "./vendor/filament/**/*.blade.php",
    ],

    theme: {
        extend: {
            colors: {
                danger: colors.rose,
                primary: brandGreen,
                success: colors.green,
                warning: brandYellow,
                gray: {
                    850: "#172033",
                    ...colors.slate,
                },
                green: brandGreen,
                yellow: brandYellow,
            },
            height: {
                "1/2-screen": "50vh",
                "2/3-screen": "66vh",
                "2/3": "66.666667%",
                "1/3": "33.333333%",
                "1/4": "25%",
                18: "4.5rem",
            },
            fontFamily: {
                raleway: ["Raleway", ...fontFamily.sans],
                newscycle: ["News Cycle", ...fontFamily.sans],
                sans: ["Lato", ...fontFamily.sans],
            },
            fontSize: {
                "7xl": "5rem",
            },
            maxWidth: {
                prose: "65ch",
            },
            typography: (theme) => ({
                DEFAULT: {
                    css: [
                        {
                            color: theme("colors.black"),
                            a: {
                                color: theme("colors.green.600"),
                                textDecoration: "none",
                                "&:hover": {
                                    textDecoration: "underline",
                                },
                            },
                            h1: {
                                color: theme("colors.gray.700"),
                                fontFamily:
                                    '"News Cycle", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
                                fontSize: theme("fontSize.5xl"),
                            },
                            "h1 strong": {
                                color: theme("colors.gray.700"),
                                fontFamily:
                                    '"News Cycle", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
                                fontSize: theme("fontSize.5xl"),
                            },
                            h2: {
                                color: theme("colors.green.500"),
                                fontFamily:
                                    '"News Cycle", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
                                fontSize: theme("fontSize.4xl"),
                            },
                            "h2 strong": {
                                color: theme("colors.green.500"),
                                fontFamily:
                                    '"News Cycle", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
                                fontSize: theme("fontSize.4xl"),
                            },
                            h3: {
                                color: theme("colors.gray.700"),
                                fontFamily:
                                    'Lato, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
                                fontSize: theme("fontSize.xl"),
                            },
                            "h3 strong": {
                                color: theme("colors.gray.700"),
                                fontFamily:
                                    'Lato, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
                                fontSize: theme("fontSize.xl"),
                            },
                            h4: {
                                color: theme("colors.gray.700"),
                                fontFamily:
                                    'Lato, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
                                fontWeight: theme("fontWeight.semibold"),
                                textTransform: theme("textTransform.uppercase"),
                                letterSpacing: theme("letterSpacing.wider"),
                                fontSize: theme("fontSize.lg"),
                            },
                            "h4 strong": {
                                color: theme("colors.gray.700"),
                                fontFamily:
                                    'Lato, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
                                fontWeight: theme("fontWeight.semibold"),
                                textTransform: theme("textTransform.uppercase"),
                                letterSpacing: theme("letterSpacing.wider"),
                                fontSize: theme("fontSize.lg"),
                            },
                            "figure figcaption": {
                                fontSize: theme("fontSize.sm"),
                                color: theme("colors.gray.600"),
                            },
                            blockquote: {
                                fontSize: theme("fontSize.xl"),
                                fontWeight: "500",
                                fontStyle: "italic",
                                color: theme("colors.green.500"),
                                borderLeft: 0,
                                paddingLeft: 0,
                            },
                            "blockquote p:first-of-type::before": false,
                            "blockquote p:last-of-type::after": false,
                        },
                    ],
                },
                light: {
                    css: [
                        {
                            color: theme("colors.gray.300"),
                            '[class~="lead"]': {
                                color: theme("colors.gray.300"),
                            },
                            a: {
                                color: theme("colors.green.300"),
                            },
                            strong: {
                                color: theme("colors.gray.100"),
                                fontWeight: "600",
                            },
                            "ol > li::before": {
                                color: theme("colors.gray.400"),
                            },
                            "ul > li::before": {
                                backgroundColor: theme("colors.gray.600"),
                            },
                            hr: {
                                borderColor: theme("colors.gray.700"),
                            },
                            blockquote: {
                                color: theme("colors.green.300"),
                            },
                            h1: {
                                color: theme("colors.gray.100"),
                            },
                            "h1 strong": {
                                color: theme("colors.gray.100"),
                            },
                            h2: {
                                color: theme("colors.gray.100"),
                            },
                            "h2 strong": {
                                color: theme("colors.gray.100"),
                            },
                            h3: {
                                color: theme("colors.gray.100"),
                            },
                            "h3 strong": {
                                color: theme("colors.gray.100"),
                            },
                            h4: {
                                color: theme("colors.gray.100"),
                            },
                            "h4 strong": {
                                color: theme("colors.gray.100"),
                            },
                            "figure figcaption": {
                                color: theme("colors.gray.400"),
                            },
                            code: {
                                color: theme("colors.gray.100"),
                            },
                            "a code": {
                                color: theme("colors.white"),
                            },
                            pre: {
                                color: theme("colors.gray.200"),
                                backgroundColor: theme("colors.gray.800"),
                            },
                            thead: {
                                color: theme("colors.gray.100"),
                                borderBottomColor: theme("colors.gray.600"),
                            },
                            "tbody tr": {
                                borderBottomColor: theme("colors.gray.700"),
                            },
                        },
                    ],
                },
            }),
        },
    },

    plugins: [
        require("@tailwindcss/aspect-ratio"),
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
