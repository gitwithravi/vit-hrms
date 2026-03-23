const customColor = {
    "site-primary": "var(--color-site-primary)",
    "site-light-primary": "var(--color-site-light-primary)",
    primary: "var(--color-primary)",
    "dark-primary": "var(--color-dark-primary)",
    "darken-primary": "var(--color-darken-primary)",
    "light-primary": "var(--color-light-primary)",
    "lighten-primary": "var(--color-lighten-primary)",
    secondary: "var(--color-secondary)",
    "dark-secondary": "var(--color-dark-secondary)",
    "darken-secondary": "var(--color-darken-secondary)",
    "light-secondary": "var(--color-light-secondary)",
    "lighten-secondary": "var(--color-lighten-secondary)",
    success: "var(--color-success)",
    "dark-success": "var(--color-dark-success)",
    "light-success": "var(--color-light-success)",
    danger: "var(--color-danger)",
    "dark-danger": "var(--color-dark-danger)",
    "light-danger": "var(--color-light-danger)",
    info: "var(--color-info)",
    "dark-info": "var(--color-dark-info)",
    "light-info": "var(--color-light-info)",
    warning: "var(--color-warning)",
    "dark-warning": "var(--color-dark-warning)",
    "light-warning": "var(--color-light-warning)",
}

module.exports = {
    darkMode: "class",
    content: [
        "./node_modules/**/*.vue",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    whitelistPatterns: [],
    safelist: [],
    theme: {
        container: {
            center: true,
            padding: {
                DEFAULT: "1rem",
                sm: "1rem",
                md: "1rem",
                lg: "1rem",
                xl: "3rem",
                "2xl": "13rem",
            },
        },
        extend: {
            textColor: {
                label: "var(--color-text-label)",
                "success-label": "var(--color-success-label)",
                "danger-label": "var(--color-danger-label)",
                "info-label": "var(--color-info-label)",
                "warning-label": "var(--color-warning-label)",
                ...customColor,
            },
            ringColor: {
                ...customColor,
            },
            backgroundColor: {
                ...["even", "odd"],
                ...customColor,
            },
            borderColor: {
                ...customColor,
            },
            maxWidth: {
                "1/4": "25%",
                "1/3": "33.33%",
                "2/5": "40%",
                "1/2": "50%",
                "3/5": "60%",
                "2/3": "66.67%",
                "3/4": "75%",
                "4/5": "80%",
            },
            borderRadius: {
                none: "0",
            },
            fontFamily: {
                sans: ["Inter var"],
            },
            blur: {
                xs: "2px",
            },
            backgroundImage: (theme) => ({
                "site-background": `url("/images/site-background.svg")`,
                "grid-background": `url("/images/grid.svg")`,
            }),
        },
    },
    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
        require("@tailwindcss/aspect-ratio"),
        require("./resources/plugins/js/scrollbar.js"),
        require("./resources/plugins/js/frostui-plugin.js"),
    ],
}
