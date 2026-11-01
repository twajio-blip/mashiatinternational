import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import scrollbar from "tailwind-scrollbar";
import preline from "preline/plugin";

function widthOpacity(variableName) {
    return ({ opacityValue }) => {
        if (opacityValue != undefined) {
            return `rgba(var(${variableName}),${opacityValue})`;
        }
        return `rgba(var(${variableName}))`;
    };
}

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        // Single reliable glob - covers ALL .blade.php and .php files at any depth
        "./resources/**/*.blade.php",
        "./resources/**/*.php",
        "node_modules/preline/dist/*.js",
        "./resources/js/**/*.js",
        "./documentation/new.html",
    ],

    theme: {
        extend: {
            colors: {
                brand: {
                    red: 'var(--brand-red)',
                    redHover: 'var(--brand-red-hover)',
                    charcoal: 'var(--brand-charcoal)',
                    blue: 'var(--brand-blue)',
                    amber: 'var(--brand-amber)',
                    green: 'var(--brand-green)',
                    light: 'var(--brand-light)',
                    gray: 'var(--brand-gray)',
                }
            },
            fontFamily: {
                heading: 'var(--font-heading)',
                body: 'var(--font-body)',
            },
            borderColor: {
                default: widthOpacity("--default-border"),
                highlight: widthOpacity("--highlight-border"),
            },
            textColor: {
                skin: {
                    hover: widthOpacity("--color-text-hover"),
                    heading: widthOpacity("--color-text-heading"),
                    title: widthOpacity("--color-text-title"),
                    base: widthOpacity("--color-text-base"),
                    invert: widthOpacity("--color-text-invert"),
                    muted: widthOpacity("--color-text-muted"),
                    'backend-text-base': widthOpacity("--color-backend-text-base"),
                },
            },
            backgroundColor: {
                skin: {
                    primary: widthOpacity("--color-background-primary"),
                    secondary: widthOpacity("--color-background-secondary"),
                    default: widthOpacity("--color-background-default"),
                    content: widthOpacity("--color-background-content"),

                    'backend-primary': widthOpacity("--color-backend-background-primary"),
                    'backend-secondary': widthOpacity("--color-backend-background-secondary"),
                    'backend-accent': widthOpacity("--color-backend-background-accent"), 
                },
            },
        },
    },

    plugins: [forms, scrollbar, preline],
};
