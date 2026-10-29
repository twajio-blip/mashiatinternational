import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

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
        "./resources/views/**/*.php",
        "./resources/views/*.php",
        "./resources/views/**/**/*.php",
        "./resources/views/**/**/**/*.php",
        "./resources/views/**/**/**/**/**/*.php",
        "node_modules/preline/dist/*.js",
        "./resources/js/**/*.js",
        "./resources/views/components/frontend/notice.blade.php",
        "./resources/views/components/frontend/clients.blade.php",
        "./resources/views/components/frontend/navbar.blade.php",
        "./resources/views/components/frontend/about-section.blade.php",
        "./resources/views/components/frontend/about-section2.blade.php", 
        "./resources/views/components/frontend/about-section3.blade.php", 
        "./resources/views/components/frontend/team2.blade.php",
        "./resources/views/components/frontend/blog3.blade.php",
        "./resources/views/components/frontend/hero2.blade.php",
        "./resources/views/components/frontend/hero3.blade.php",
        "./resources/views/components/frontend/statistics-with-year.blade.php",
        "./resources/views/components/frontend/service-banner.blade.php",
        "./resources/views/components/frontend/service-banner2.blade.php",
        "./resources/views/components/frontend/service2.blade.php",
        "./resources/views/components/frontend/statistics2.blade.php",
        "./resources/views/components/frontend/work.blade.php",
        "./resources/views/components/frontend/company.blade.php",
        "./resources/views/components/frontend/reviews2.blade.php",
        "./resources/views/components/frontend/reviews3.blade.php",
        "./resources/views/components/frontend/reviews.blade.php",
        "./resources/views/components/frontend/subscribe.blade.php", 
        "./resources/views/components/frontend/footer2.blade.php",
        "./resources/views/components/frontend/about-section-2.blade.php",
        "./resources/views/components/frontend/steps_we_follow.blade.php",
        "./resources/views/components/frontend/pre_footer_2.blade.php",
        "./resources/views/components/frontend/pre_footer_3.blade.php",
        "./resources/views/components/frontend/contact2.blade.php",
        "./resources/views/components/frontend/portfolio.blade.php",
        "./resources/views/components/frontend/award.blade.php",
        "./resources/views/components/frontend/career-about.blade.php",
        "./resources/views/components/frontend/career-faq.blade.php",
        "./resources/views/components/frontend/job-post.blade.php",
        "./resources/views/backend/pages/pages/model/field-data-model.blade.php",
        "./resources/views/components/frontend/navbar2.blade.php",
        "./resources/views/components/frontend/default-button2.blade.php",
        "./resources/views/components/backend/input-checkbox.blade.php",
        "./resources/views/components/backend/header.blade.php",

        "./documentation/new.html",
        "./resources/views/layouts/deshboard.blade.php",
        "./resources/views/service-view.blade.php",
        "./resources/views/eventsView.blade.php",
    ],

    theme: {
        extend: {
            backgroundImage: {
                'placeholder': "url('/public/defualt/placeholder.png')"
            },
            colors: {
                brand: {
                    red: '#CC0000',
                    redHover: '#A30000',
                    charcoal: '#1A1A1A',
                    blue: '#1E3A8A',
                    amber: '#F59E0B',
                    green: '#16A34A',
                    light: '#F8F9FA',
                    gray: '#6B7280',
                },
                background: 'var(--background)',
                'background-2': 'var(--background-2)',
                'background-3': 'var(--background-3)',
                header: 'var(--header)',
                status: 'var(--status)',
                danger: 'var(--danger)',
                'danger-hover': 'var(--danger-hover)',
                success: 'var(--success)',
                'success-hover': 'var(--success-hover)',
                'confirm-hover': 'var(--confirm-hover)',
                warning: 'var(--warning)',
                light: 'var(--light)',
                dark: 'var(--dark)',
                'soft-dark': 'var(--soft-dark)',
                muted: 'var(--muted)',
                'muted-foreground': 'var(--muted-foreground)',
                tag: 'var(--tag)',
                'btn-primary': 'var(--btn-primary)',
                'btn-primary-hover': 'var(--btn-primary-hover)',
                'border-color': 'var(--border-color)',
            },
            fontFamily: {
                sans: ['Manrope', ...defaultTheme.fontFamily.sans],
                heading: ['Manrope', ...defaultTheme.fontFamily.sans],
                body: ['Manrope', ...defaultTheme.fontFamily.sans],
            },
            maxWidth: {
                295: '73.75rem',
                310: '77.5rem',
            },
            spacing: {
                xsmall: '0.25rem',
                small: '0.725rem',
                large: '1rem',
                huge: '1.25rem',
                xhuge: '1.5rem',
                '2xhuge': '2rem',
            },
            boxShadow: {
                card: '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)',
                'card-hover': '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
            },
            keyframes: {
                wiggle: {
                    "0%": { transform: "translateX(-100%)", opacity: "0" },
                    "100%": { transform: "translateX(120%)" },
                },
                float: {
                    "0%": {
                        transform: "translate(0px, 0px)", // Starting position
                    },
                    "50%": {
                        transform: "translate(30px, -30px)", // Move diagonally (right and up)
                    },
                    "100%": {
                        transform: "translate(0px, 0px)", // Back to starting position
                    },
                },
                glossy: {
                    "0%": {
                        transform: "translate(-250px,-50%) rotate(45deg)", // Combined transform
                    }, 
                    "100%": {
                        transform: "translate(50px,-50%) rotate(45deg)", // Only translate at the end
                    },
                },
                
                spin_reverse: {
                    to: {
                        transform: "rotate(-360deg)", // Fixed: added quotes
                    }
                },
            },
            animation: {
                wiggle: "wiggle 1s ease-in forwards",
                float: "float 10s infinite ease-in-out",
                glossy: "glossy 10s infinite ease-in-out alternate",
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

    plugins: [forms, require("tailwind-scrollbar")],
};
