import "./bootstrap";
import "preline";

import AOS from 'aos';
import 'aos/dist/aos.css';

import Alpine from "alpinejs";
import { HSStaticMethods } from "preline";

window.Alpine = Alpine;
window.AOS = AOS;

// ─── Reusable Lightbox Zoom + Pan Component ──────────────────────────────────
// Usage: <div x-data="lightboxZoom()"> around any lightbox image.
// Parent navigates/closes by dispatching window events:
//   window.dispatchEvent(new CustomEvent('lightbox:navigate'))
//   window.dispatchEvent(new CustomEvent('lightbox:close'))
Alpine.data('lightboxZoom', () => ({
    zoomed: false,
    panX: 0,
    panY: 0,
    isPanning: false,
    startPanX: 0,
    startPanY: 0,
    scale: 1.8,

    init() {
        this._reset = () => this.resetZoom();
        window.addEventListener('lightbox:navigate', this._reset);
        window.addEventListener('lightbox:close', this._reset);
    },
    destroy() {
        window.removeEventListener('lightbox:navigate', this._reset);
        window.removeEventListener('lightbox:close', this._reset);
    },
    resetZoom() {
        this.zoomed = false;
        this.panX = 0;
        this.panY = 0;
        this.isPanning = false;
    },
    toggleZoom() {
        if (this.isPanning) return;
        this.zoomed = !this.zoomed;
        if (!this.zoomed) { this.panX = 0; this.panY = 0; }
    },
    startPan(e) {
        if (!this.zoomed) return;
        this.isPanning = true;
        this.startPanX = e.clientX - this.panX;
        this.startPanY = e.clientY - this.panY;
        e.preventDefault();
    },
    doPan(e) {
        if (!this.isPanning) return;
        this.panX = e.clientX - this.startPanX;
        this.panY = e.clientY - this.startPanY;
    },
    stopPan() { this.isPanning = false; },
    startTouchPan(e) {
        if (!this.zoomed) return;
        const t = e.touches[0];
        this.isPanning = true;
        this.startPanX = t.clientX - this.panX;
        this.startPanY = t.clientY - this.panY;
    },
    doTouchPan(e) {
        if (!this.isPanning) return;
        const t = e.touches[0];
        this.panX = t.clientX - this.startPanX;
        this.panY = t.clientY - this.startPanY;
        e.preventDefault();
    },
    get imgStyle() {
        const tx = this.zoomed ? this.panX / this.scale : 0;
        const ty = this.zoomed ? this.panY / this.scale : 0;
        const tr = this.isPanning ? 'none' : 'transform 0.3s ease-in-out';
        return `transform: scale(${this.zoomed ? this.scale : 1}) translate(${tx}px, ${ty}px); transition: ${tr}; will-change: transform;`;
    },
    get cursorClass() {
        if (!this.zoomed) return 'cursor-zoom-in';
        return this.isPanning ? 'cursor-grabbing' : 'cursor-grab';
    }
}));

Alpine.start();


    // Initialize AOS immediately
    AOS.init({
        duration: 1000,
        once: true,
        offset: 0,
        easing: 'ease-in-out',
        startEvent: 'DOMContentLoaded', // Faster initial check
    });

    // CRITICAL FIX: Refresh AOS when resources load or Alpine inits
    window.addEventListener('load', () => AOS.refresh());
    document.addEventListener('alpine:initialized', () => {
        AOS.refresh();
        setTimeout(() => AOS.refresh(), 500);
    });

    // Final fallback: Mutation Observer to catch dynamic layout shifts
    const observer = new MutationObserver(() => {
        AOS.refresh();
    });
    observer.observe(document.body, { childList: true, subtree: false });

// Reinitialize Preline components after every page load
document.addEventListener("DOMContentLoaded", function () {
    if (typeof HSStaticMethods !== "undefined" && HSStaticMethods.autoInit) {
        HSStaticMethods.autoInit();
    }
});

// Search menu functionality (only on backend pages that have the sidebar)
const input = document.getElementById("menuSearch");
const suggestionsBox = document.getElementById("menuSuggestions");

if (input && suggestionsBox) {
    // Prepare menu list
    const menuItems = Array.from(document.querySelectorAll(".sidebar-nav li"))
        .map((li) => {
            const textEl =
                li.querySelector("h1.hideable") || li.querySelector("a");
            if (!textEl) return null;

            return {
                label: textEl.textContent.trim(),
                target: li.querySelector("a")?.href || "#",
            };
        })
        .filter(Boolean);

    input.addEventListener("input", function () {
        const keyword = this.value.toLowerCase().trim();
        suggestionsBox.innerHTML = "";

        if (!keyword) {
            suggestionsBox.classList.add("hidden");
            return;
        }

        const matches = menuItems.filter((item) =>
            item.label.toLowerCase().includes(keyword)
        );

        if (matches.length === 0) {
            suggestionsBox.innerHTML = `<li class="px-4 py-2 text-gray-500">No menu found</li>`;
        } else {
            matches.forEach((item) => {
                const li = document.createElement("li");
                li.innerHTML = `<a href="${item.target}" class="block px-4 py-2 hover:bg-gray-200 transition">${item.label}</a>`;
                suggestionsBox.appendChild(li);
            });
        }

        suggestionsBox.classList.remove("hidden");
    });

    // Optional: hide on outside click
    document.addEventListener("click", (e) => {
        if (
            !e.target.closest("#menuSearch") &&
            !e.target.closest("#menuSuggestions")
        ) {
            suggestionsBox.classList.add("hidden");
        }
    });
}

// end of Search menu functionality


const observeAndAnimate = function (selector, toggleClasses) {
    const observer = new IntersectionObserver(
        (entries, observerInstance) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    $(entry.target).addClass("in-view");
                    $(entry.target).toggleClass(toggleClasses);
                    observerInstance.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1 }
    );

    $(`[data-observe="${selector}"]`).each(function () {
        observer.observe(this);
    });
};

let allObserver = document.querySelectorAll("[data-observe]");

allObserver.forEach((element) => {
    let selector = element.getAttribute("data-observe");
    let toggleClasses = element.getAttribute("data-toggle");
    let togglePosition = "";
    if (toggleClasses == "right") {
        togglePosition =
            "-translate-x-[100px] opacity-0 translate-x-0 opacity-100";
    } else if (toggleClasses == "left") {
        togglePosition =
            "translate-x-[100px] opacity-0 translate-x-0 opacity-100";
    } else if (toggleClasses == "top") {
        togglePosition =
            "translate-y-[100px] opacity-0 translate-y-0 opacity-100";
    }

    observeAndAnimate(selector, togglePosition);
});

observeAndAnimate(
    ".service-3-left",
    "-translate-x-[100px] opacity-0 translate-x-0 opacity-100"
);
observeAndAnimate(
    ".service-3-right",
    "translate-x-[100px] opacity-0 translate-x-0 opacity-100"
);
observeAndAnimate(
    ".reviews-title",
    "-translate-x-[100px] opacity-0 translate-x-0 opacity-100"
);
observeAndAnimate(
    ".reviews-nav",
    "translate-x-[100px] opacity-0 translate-x-0 opacity-100"
);
observeAndAnimate(
    ".work-3-left",
    "-translate-x-[100px] opacity-0 translate-x-0 opacity-100"
);
observeAndAnimate(
    ".work-3-right",
    "translate-x-[100px] opacity-0 translate-x-0 opacity-100"
);
observeAndAnimate(
    ".subscribe-left",
    "-translate-x-[100px] opacity-0 translate-x-0 opacity-100"
);
observeAndAnimate(
    ".subscribe-right",
    "translate-x-[100px] opacity-0 translate-x-0 opacity-100"
);
observeAndAnimate(
    ".subscribe-2",
    "translate-y-[40px] opacity-0 translate-y-0 opacity-100"
);
observeAndAnimate(
    ".blog-3-header",
    "translate-y-[100px] opacity-0 translate-y-0 opacity-100"
);
observeAndAnimate(
    ".blog-3-body",
    "translate-y-[100px] opacity-0 translate-y-0 opacity-100"
);
observeAndAnimate(
    ".pre-footer-3",
    "translate-y-[40px] opacity-0 translate-y-0 opacity-100"
);
observeAndAnimate(
    ".step-header",
    "translate-y-[40px] opacity-0 translate-y-0 opacity-100"
);
observeAndAnimate(
    ".step-body",
    "translate-y-[40px] opacity-0 translate-y-0 opacity-100"
);
observeAndAnimate(
    ".team-3-header",
    "translate-y-[40px] opacity-0 translate-y-0 opacity-100"
);
observeAndAnimate(
    ".review-3-header",
    "translate-y-[40px] opacity-0 translate-y-0 opacity-100"
);
observeAndAnimate(
    ".company-header",
    "translate-y-[40px] opacity-0 translate-y-0 opacity-100"
);
observeAndAnimate(
    ".team-header",
    "translate-y-[40px] opacity-0 translate-y-0 opacity-100"
);
observeAndAnimate(
    ".blog-header",
    "translate-y-[40px] opacity-0 translate-y-0 opacity-100"
);
observeAndAnimate(
    ".pre-footer-2",
    "translate-y-[40px] opacity-0 translate-y-0 opacity-100"
);

observeAndAnimate(
    ".team-2-title",
    "-translate-x-[100px] opacity-0 translate-x-0 opacity-100"
);
observeAndAnimate(
    ".team-2-button",
    "translate-x-[100px] opacity-0 translate-x-0 opacity-100"
);

observeAndAnimate(
    ".about-2-left",
    "-translate-x-[100px] opacity-0 translate-x-0 opacity-100"
);
observeAndAnimate(
    ".about-2-right",
    "translate-x-[100px] opacity-0 translate-x-0 opacity-100"
);

// observeAndAnimate(
//     ".about-3-left",
//     "-translate-x-[100px] opacity-0 translate-x-0 opacity-100"
// );
// observeAndAnimate(
//     ".about-3-right",
//     "translate-x-[100px] opacity-0 translate-x-0 opacity-100"
// );

observeAndAnimate(
    ".service-title",
    "-translate-x-[100px] opacity-0 translate-x-0 opacity-100"
);
observeAndAnimate(
    ".service-button",
    "translate-x-[100px] opacity-0 translate-x-0 opacity-100"
);

observeAndAnimate(
    ".statistic-2-left",
    "-translate-x-[100px] opacity-0 translate-x-0 opacity-100"
);
observeAndAnimate(
    ".statistic-2-right",
    "translate-x-[100px] opacity-0 translate-x-0 opacity-100"
);

observeAndAnimate(
    ".blog-2-left",
    "-translate-x-[100px] opacity-0 translate-x-0 opacity-100"
);
observeAndAnimate(
    ".blog-2-right",
    "translate-x-[100px] opacity-0 translate-x-0 opacity-100"
);

observeAndAnimate(
    ".work-2-header",
    "translate-y-[40px] opacity-0 translate-y-0 opacity-100"
);
// observeAndAnimate(
//     ".company-header",
//     "translate-y-[40px] opacity-0 translate-y-0 opacity-100"
// );
observeAndAnimate(
    ".review-2-header",
    "translate-y-[40px] opacity-0 translate-y-0 opacity-100"
);
// observeAndAnimate(
//     ".subscribe-2",
//     "translate-y-[40px] opacity-0 translate-y-0 opacity-100"
// );
// observeAndAnimate(
//     ".pre-footer-2",
//     "translate-y-[40px] opacity-0 translate-y-0 opacity-100"
// );

$(document).ready(function () {
    // Toggle Dropdown
    $(document).on("click", ".dropdown-trigger", function () {
        if ($(this).next().css("display") !== "block") {
            $(this).closest("ul").children().children(".dropdown").slideUp(300);
            $(this)
                .closest("ul")
                .children()
                .children(".dropdown-trigger")
                .children(".dropdown-icon")
                .removeClass("rotate-180");
        }
        $(this).children(".dropdown-icon").toggleClass("rotate-180");
        $(this).next().slideToggle(300);
    });
    // Toggle active on sidebar nave item
    $(document).on("click", ".active-trigger", function () {
        $(this)
            .closest(".sidebar-nav")
            .find(".sidebar-nav-active")
            .removeClass("sidebar-nav-active");
        $(this).parents(".dropdown").prev().addClass("sidebar-nav-active");
        $(this).addClass("sidebar-nav-active");
    });
    // Toggle sidebar on click
    $(document).on("click", ".sidebar-trigger-btn", function () {
        if ($(".sidebar").hasClass("sidebar-active")) {
            $(this)
                .closest("aside")
                .addClass("md:w-[70px]")
                .removeClass("md:w-[240px]");
            $(this).closest("aside").find(".hideable").addClass("hidden");
            $(this).closest("aside").find(".dropdown").addClass("!hidden");
            $(this)
                .closest("aside")
                .find(".nav-section-title")
                .html('<i class="fa-solid fa-ellipsis"></i>');
        } else {
            $(this)
                .closest("aside")
                .addClass("md:w-[240px]")
                .removeClass("md:w-[70px]");
            $(this).closest("aside").find(".hideable").removeClass("hidden");
            $(this).closest("aside").find(".dropdown").removeClass("!hidden");
            $(this)
                .closest("aside")
                .find(".nav-section-title")
                .each(function () {
                    let oldData = $(this).attr("old_data");
                    $(this).html(oldData);
                });
        }
        $(this).children("i").toggleClass("text-skin-hover");
        $(this).closest("aside").toggleClass("sidebar-active");
        $(".main-content").toggleClass("md:pl-[94px] md:pl-[260px]");
    });
    // open sidebar on hover in
    $(document).on("mouseenter", ".sidebar", function () {
        if (!$(".sidebar").hasClass("sidebar-active")) {
            $(this)
                .closest("aside")
                .removeClass("md:w-[70px]")
                .addClass("md:w-[240px]");
            $(this).closest("aside").find(".hideable").removeClass("hidden");
            $(this).closest("aside").find(".dropdown").removeClass("!hidden");
            $(this)
                .closest("aside")
                .find(".nav-section-title")
                .each(function () {
                    let oldData = $(this).attr("old_data");
                    $(this).html(oldData);
                });
        }
    });
    // close sidebar on hover out
    $(document).on("mouseleave", ".sidebar", function () {
        if (!$(".sidebar").hasClass("sidebar-active")) {
            $(this)
                .closest("aside")
                .addClass("md:w-[70px]")
                .removeClass("md:w-[240px] ");
            $(this).closest("aside").find(".hideable").addClass("hidden");
            $(this).closest("aside").find(".dropdown").addClass("!hidden");
            $(this)
                .closest("aside")
                .find(".nav-section-title")
                .html('<i class="fa-solid fa-ellipsis"></i>');
        }
    });
    // Small Screen Sidebar Toggle
    $(document).on("click", ".sm-sidebar-trigger-btn", function (event) {
        if (!$(".sidebar").hasClass("sidebar-active")) {
            $(".sidebar-trigger-btn").trigger("click");
        }
        $(".sidebar").toggleClass("-translate-x-[110%]");
        $(".overlay").toggleClass("w-fit w-full");
    });
    $(document).on("click", ".sidebar", function (event) {
        event.stopPropagation();
    });
    $(document).on("click", ".overlay", function () {
        $(".sidebar").toggleClass("-translate-x-[110%]");
        $(".overlay").toggleClass("w-fit w-full");
    });
});

$(document).ready(function () {
    // Toggle Navbar Starts
    $(document).on("click", ".menu-btn", function () {
        $(this)
            .closest(".navbar")
            .find(".nav-ul")
            .toggleClass("-left-full left-0");
        $(this)
            .closest(".navbar")
            .find(".nav-overlay")
            .addClass("h-screen w-screen")
            .removeClass("h-fit w-fit");
    });
    $(document).on("click", ".nav-overlay", function () {
        $(this)
            .closest(".navbar")
            .find(".nav-ul")
            .toggleClass("-left-full left-0");
        $(this)
            .closest(".navbar")
            .find(".nav-overlay")
            .removeClass("h-screen w-screen")
            .addClass("h-fit w-fit");
    });
    // Toggle Navbar Ends

    // nav scroll
    $(window).on("scroll", function () {
        if ($(this).scrollTop() > 100) {
            $(".navbar").addClass("!bg-[#252525] !bg-opacity-80");
        } else {
            $(".navbar").removeClass("!bg-[#252525] !bg-opacity-80");
        }
    });
    // nav scroll

    // To prevent the click event from reaching the parent element
    $(document).on("click", ".nav-ul", function (event) {
        event.stopPropagation();
    });

    // dropdown
    $(document).on("click", ".dropdown-trigger-1", function () {
        if (!$(this).hasClass("dropdown-active")) {
            $(this)
                .closest(".multiple-dropdown-container")
                .find(".dropdown-content")
                .slideUp(300);
            $(this)
                .closest(".multiple-dropdown-container")
                .find(".dropdown-trigger-1")
                .children("span")
                .children("i")
                .removeClass("fa-minus")
                .addClass("fa-plus");
            $(this)
                .closest(".multiple-dropdown-container")
                .find(".dropdown-trigger-1")
                .removeClass("dropdown-active");
            $(this).addClass("dropdown-active");
        }
        $(this).next(".dropdown-content").slideToggle(300);
        $(this).children("span").children("i").toggleClass("fa-plus fa-minus");
    });
    // dropdown
    $(document).on("click", ".dropdown-trigger-2", function () {
        if (!$(this).hasClass("dropdown-active")) {
            $(this)
                .closest(".multiple-dropdown-container")
                .find(".dropdown-content")
                .slideUp(300);
            $(this)
                .closest(".multiple-dropdown-container")
                .find(".dropdown-trigger-2")
                .children("span")
                .children("i")
                .removeClass("fa-angle-up")
                .addClass("fa-angle-down");
            $(this)
                .closest(".multiple-dropdown-container")
                .find(".dropdown-trigger-2")
                .removeClass("dropdown-active");
            $(this).addClass("dropdown-active");
        }
        $(this).next(".dropdown-content").slideToggle(300);
        $(this)
            .children("span")
            .children("i")
            .toggleClass("fa-angle-down fa-angle-up");
    });

    // Fade text
    $(document).on("click", ".fade-trigger", function () {
        $(this)
            .closest(".swiperHistory")
            .find(".fade-trigger")
            .removeClass("before:w-full text-skin-hover")
            .addClass("before:w-0");
        $(this)
            .addClass("before:w-full text-skin-hover")
            .removeClass("before:w-0");
        var fadeclass = "." + $(this).attr("fade");
        $(".fade-container").children().hide();
        $(".fade-container").children(fadeclass).fadeIn(500);
    });

    function checkTextLines() {
        var featureCardText = $(".feature-card > :last-child").find("p");
        var lineHeight = parseFloat(featureCardText.css("line-height"));
        var twoLinesHeight = lineHeight * 2;

        featureCardText.each(function (index, element) {
            var $element = $(element);
            if ($element.height() > twoLinesHeight) {
                $element.next().removeClass("hidden");
                $element.addClass("line-clamp-2");
            } else {
                $element.next().addClass("hidden");
                $element.removeClass("line-clamp-2");
            }
        });
    }

    $(window).on("load resize", checkTextLines);

    // learn more button
    $(document).on("click", ".learn-more-btn", function () {
        $(this).parent().children("p").toggleClass("line-clamp-6");
        if ($(this).text().trim() == "Learn More") {
            $(this).text("Learn Less");
        } else if ($(this).text().trim() == "Learn Less") {
            $(this).text("Learn More");
        }
    });
});

// Swiper Slide
document.addEventListener("DOMContentLoaded", function () {
    var mySwiper = new Swiper("#swiper-1", {
        effect: "slide",
        speed: 800,
        navigation: {
            nextEl: "#nav-right",
            prevEl: "#nav-left",
        },
        pagination: {
            el: ".swiper-pagination",
            // Other pagination options like type, clickable, etc.
        },
        // Optional parameters
        direction: "horizontal",
        loop: true,

        autoplay: {
            delay: 3000, // milliseconds
            disableOnInteraction: false,
        },
    });

    // AOS.init({
    //   // AOS options here...
    //   // For example:
    //   offset: 100,
    //   duration: 1000,
    //   easing: 'ease-in-out',
    //   });
});
// swiper card
var swiper = new Swiper(".mySwiper", {
    slidesPerView: 1,
    spaceBetween: 20,
    touch: true,
    speed: 800,
    slidesPerGroup: 1,
    rewind: true,
    navigation: {
        nextEl: "#card-nav-right",
        prevEl: "#card-nav-left",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    autoplay: {
        delay: 3000, // milliseconds
        disableOnInteraction: false,
    },
    breakpoints: {
        // Responsive breakpoints
        500: {
            slidesPerView: 2,
            slidesPerGroup: 2,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 3,
            slidesPerGroup: 3,
            spaceBetween: 30,
        },
    },
});
// swiper card
var swiper = new Swiper(".mySwiperP", {
    pagination: {
        el: ".swiper-pagination",
        type: "progressbar",
    },
    navigation: {
        nextEl: "#swiper-button-nexts",
        prevEl: "#swiper-button-prevs",
    },
});
// verticale slider
var swiper = new Swiper(".mySwiperV", {
    direction: "vertical",
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});
// slider scroll
var swiper = new Swiper(".mySwiperS", {
    scrollbar: {
        el: ".swiper-scrollbar",
        hide: true,
    },
});
// swiper service
var swiper = new Swiper(".mySwiper-service", {
    slidesPerView: 1,
    spaceBetween: 20,
    touch: true,
    speed: 800,
    slidesPerGroup: 1,
    loop: true,
    navigation: {
        nextEl: "#card-nav-right",
        prevEl: "#card-nav-left",
    },
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    autoplay: {
        delay: 3000, // milliseconds
        disableOnInteraction: false,
    },
    breakpoints: {
        // Responsive breakpoints
        500: {
            slidesPerView: 2,
            slidesPerGroup: 2,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 3,
            slidesPerGroup: 3,
            spaceBetween: 30,
        },
    },
});
// swiper work
var swiper = new Swiper(".mySwiper-work", {
    slidesPerView: "auto",
    centeredSlides: true,
    spaceBetween: 60,
    loop: true,
    navigation: {
        nextEl: "#card-nav-right",
        prevEl: "#card-nav-left",
    },
    autoplay: {
        delay: 3000, // Time between slides in milliseconds
        disableOnInteraction: false, // Autoplay will not stop after user interaction
    },
});
// swiper review
var swiper = new Swiper(".mySwiper-review", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    navigation: {
        nextEl: "#review-nav-right",
        prevEl: "#review-nav-left",
    },
    autoplay: {
        delay: 3000, // Time between slides in milliseconds
        disableOnInteraction: false, // Autoplay will not stop after user interaction
    },
    breakpoints: {
        // Small screens (up to 640px)
        640: {
            slidesPerView: 2, // Show 2 slides
            spaceBetween: 6, // Add spacing between slides
        },
        // Medium screens (up to 768px)
        768: {
            slidesPerView: 3, // Show 3 slides
            spaceBetween: 6,
        },
    },
});
// swiper review
var swiper = new Swiper(".mySwiper-review2", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    navigation: {
        nextEl: "#review-nav-right",
        prevEl: "#review-nav-left",
    },
    autoplay: {
        delay: 3000, // Time between slides in milliseconds
        disableOnInteraction: false, // Autoplay will not stop after user interaction
    },
    breakpoints: {
        // Small screens (up to 640px)
        640: {
            slidesPerView: 2, // Show 2 slides
            spaceBetween: 20, // Add spacing between slides
        },
        // Medium screens (up to 768px)
        768: {
            slidesPerView: 3, // Show 3 slides
            spaceBetween: 80,
        },
    },
});
// swiper review 3
var swiper = new Swiper(".mySwiper-review3", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    navigation: {
        nextEl: "#review-nav-right",
        prevEl: "#review-nav-left",
    },
    autoplay: {
        delay: 10003000, // Time between slides in milliseconds
        disableOnInteraction: false, // Autoplay will not stop after user interaction
    },
});
// swiper blog
var swiper = new Swiper(".mySwiper-blog", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    autoplay: {
        delay: 3000, // Time between slides in milliseconds
        disableOnInteraction: false, // Autoplay will not stop after user interaction
    },
    breakpoints: {
        // Small screens (up to 640px)
        640: {
            slidesPerView: 2, // Show 2 slides
            spaceBetween: 6, // Add spacing between slides
        },
        // Medium screens (up to 768px)
        768: {
            slidesPerView: 3, // Show 3 slides
            spaceBetween: 6,
        },
    },
});
// swiper team 1 card
var swiper = new Swiper(".mySwiper-team", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    autoplay: {
        delay: 3000, // Time between slides in milliseconds
        disableOnInteraction: false, // Autoplay will not stop after user interaction
    },
    breakpoints: {
        // Small screens (up to 640px)
        640: {
            slidesPerView: 2, // Show 2 slides
            spaceBetween: 6, // Add spacing between slides
        },
        // Medium screens (up to 768px)
        768: {
            slidesPerView: 3, // Show 3 slides
            spaceBetween: 6,
        },
    },
});
// swiper team 2 card
var swiper = new Swiper(".mySwiper-team2", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    autoplay: {
        delay: 100000, // Time between slides in milliseconds
        disableOnInteraction: false, // Autoplay will not stop after user interaction
    },
    breakpoints: {
        // Small screens (up to 640px)
        640: {
            slidesPerView: 2, // Show 2 slides
        },
        // Medium screens (up to 768px)
        768: {
            slidesPerView: 3, // Show 3 slides
        },
    },
});
// swiper partner
var swiper = new Swiper(".swiperPartner", {
    slidesPerView: 2,
    spaceBetween: 20,
    speed: 800,
    slidesPerGroup: 2,
    rewind: true,
    autoplay: {
        delay: 3000, // milliseconds
        disableOnInteraction: false,
    },
    breakpoints: {
        // Responsive breakpoints
        500: {
            slidesPerView: 4,
            slidesPerGroup: 4,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 5,
            slidesPerGroup: 5,
            spaceBetween: 30,
        },
    },
});
// swiper company history
var swiper = new Swiper(".swiperHistory", {
    slidesPerView: 2,
    spaceBetween: 10,
    speed: 800,
    grabCursor: true,
    slidesPerGroup: 1,
    rewind: true,
    breakpoints: {
        // Responsive breakpoints
        568: {
            slidesPerView: 3,
        },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
        1540: {
            slidesPerView: 4,
        },
    },
});
var swiper = new Swiper(".company2", {
    loop: true,
    freeMode: true,
    grabCursor: true,
    slidesPerView: 1,
    loop: true,
    autoplay: {
        delay: 1,
        disableOnInteraction: false,
    },
    freeMode: true,
    speed: 5000,
    freeModeMomentum: false,
    breakpoints: {
        // Small screens (up to 640px)
        400: {
            slidesPerView: 2, // Show 2 slides
        },
        // Medium screens (up to 768px)
        768: {
            slidesPerView: 3, // Show 3 slides
        },
        // Large screens (up to 624px)
        1024: {
            slidesPerView: 4, // Show 4 slides
        },
        // Extra large screens (default)
        1280: {
            slidesPerView: 6, // Default number of slides
        },
    },
});
// Magnific popup starts
$(".parent-container").magnificPopup({
    delegate: "a", // child items selector, by clicking on it popup will open
    type: "image",
    gallery: {
        enabled: true,
    },
});
// Magnific popup ends

// navebar onscroll
var navbar = $(".navbar");

// Define the scroll threshold
var scrollThreshold = 200; // Adjust this value as needed

// btn text width
$(".btn").hover(function () {
    let textWidth = $(this).find(".btn-text").width();
    $(this).find(".btn-icon").css("--text-translate", `${textWidth}px`);
});

// Text Expand Btn
$(document).on("click", ".text-expand-btn", function () {
    $(this).prev().toggleClass("line-clamp-2");
    $(this).toggleClass("rotate-180");
});
// team social btn
$(document).on("click", ".team-social-btn", function () {
    $(this).next().toggleClass("h-0 h-44");
    $(this).find(".fa-share-alt").toggleClass("hidden");
    $(this).find(".fa-xmark").toggleClass("hidden");
});
$(window).on("load", function () {
    if (!localStorage.getItem("setCookies")) {
        $(".cookie-alert").delay(2000).slideToggle(500);
    }
});
$(document).on("click", ".cookie-accept", function () {
    localStorage.setItem("setCookies", true);
    $(".cookie-alert").delay(200).slideToggle(500);
});

highlightWord(".highlight-title");

function highlightWord(selector) {
    const containers = document.querySelectorAll(selector);

    const decodeAndNormalize = (html) => {
        const txt = document.createElement("textarea");
        txt.innerHTML = html;
        return txt.value.replace(/\u00A0/g, " ").trim();
    };

    const normalize = (str) => str.toLowerCase().replace(/[^\w]/g, "").trim(); // remove punctuation for matching

    containers.forEach((item) => {
        const sentence = decodeAndNormalize(item.getAttribute("content") || "");
        const highlightPhrase = decodeAndNormalize(
            item.getAttribute("highlight") || ""
        );

        const sentenceWords = sentence.split(/\s+/);
        const highlightWords = highlightPhrase.split(/\s+/);

        item.innerHTML = ""; // Clear existing content

        // Create spans for each word
        const spans = sentenceWords.map((word, index) => {
            const span = document.createElement("span");
            span.textContent = word;
            item.appendChild(span);
            if (index < sentenceWords.length - 1) item.append(" "); // Add space
            return span;
        });

        // Search for matching phrases
        for (let i = 0; i <= spans.length - highlightWords.length; i++) {
            let match = true;
            for (let j = 0; j < highlightWords.length; j++) {
                const target = normalize(highlightWords[j]);
                const current = normalize(spans[i + j].textContent);
                if (target !== current) {
                    match = false;
                    break;
                }
            }
            if (match) {
                for (let j = 0; j < highlightWords.length; j++) {
                    spans[i + j].classList.add("highlight-text");
                }
                i += highlightWords.length - 1; // avoid overlapping matches
            }
        }
    });
}

const container = document.getElementById("container");
if (container) {
    const content = container.getAttribute("content");
    const highlighted_words = container.getAttribute("highlight");
    const sentence = content;
    const highlightPhrase = highlighted_words;

    container.innerHTML = ""; // Clear the container
    const words = sentence.split(" ");
    const phraseWords = highlightPhrase.split(" ");

    // Step 1: Wrap each word in a span and keep track
    const spans = words.map((word) => {
        const span = document.createElement("span");
        span.textContent = word + " ";
        container.appendChild(span);
        return span;
    });

    // Step 2: Loop through to find matches
    for (let i = 0; i <= spans.length - phraseWords.length; i++) {
        let match = true;
        for (let j = 0; j < phraseWords.length; j++) {
            if (spans[i + j].textContent.trim() !== phraseWords[j]) {
                match = false;
                break;
            }
        }

        if (match) {
            // Step 3: Create one new span with the full phrase
            const highlightSpan = document.createElement("span");
            highlightSpan.classList.add("highlight-word");

            // Collect text from matched spans
            let combinedText = "";
            for (let j = 0; j < phraseWords.length; j++) {
                combinedText += spans[i + j].textContent;
            }
            highlightSpan.textContent = combinedText;

            // Add decorative inner spans
            ["top-left", "top-right", "bottom-left", "bottom-right"].forEach(
                (pos) => {
                    const innerSpan = document.createElement("span");
                    innerSpan.classList.add(pos);
                    highlightSpan.appendChild(innerSpan);
                }
            );

            // Insert new span before the first matched span
            const firstSpan = spans[i];
            container.insertBefore(highlightSpan, firstSpan);

            // Remove the matched spans
            for (let j = 0; j < phraseWords.length; j++) {
                container.removeChild(spans[i + j]);
            }

            // Update spans array since DOM has changed
            spans.splice(i, phraseWords.length, highlightSpan);
        }
    }

    // Step 4: Detect last word of first line
    let currentTop = spans[0]?.offsetTop;
    for (let i = 1; i < spans.length; i++) {
        if (spans[i].offsetTop > currentTop) {
            const lastInFirstLine = spans[i - 1];
            lastInFirstLine.classList.add("line-break-end");

            // Add 4 inner spans with individual classes
            ["top-left", "top-right", "bottom-left", "bottom-right"].forEach(
                (cls) => {
                    const inner = document.createElement("span");
                    inner.classList.add(cls);
                    lastInFirstLine.appendChild(inner);
                }
            );

            break;
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        function formatCompact(num) {
            return new Intl.NumberFormat("en", {
                notation: "compact",
                maximumFractionDigits: 1,
            }).format(num);
        }

        function countAnimation($el, max, duration = 600, stepTime = 4) {
            let current = 0;
            let increment = Math.ceil((max * stepTime) / duration);

            const interval = setInterval(() => {
                if (current + increment >= max) {
                    current = max;
                    clearInterval(interval);
                } else {
                    current += increment;
                }

                $el.attr("data-count", current);
                $el.text(formatCompact(current));
            }, stepTime);
        }

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const $container = $(entry.target);
                        const $stats = $container.find(".statistic-data");
                        $stats.each(function () {
                            const $el = $(this);
                            const max = parseInt($el.attr("data-max"));
                            countAnimation($el, max);
                        });
                        observer.unobserve(entry.target);
                    }
                });
            },
            { threshold: 0.2 }
        );

        $(".statistic-container").each(function () {
            observer.observe(this);
        });
    });
}

let monthWiseVisitorChart = document
    .querySelector("#visitorsChart")
    ?.getAttribute("data");
monthWiseVisitorChart = monthWiseVisitorChart
    ? JSON.parse(monthWiseVisitorChart)
    : [];
let deviceWiseVisitorChart = document
    .querySelector("#visitorsByDeviceChart")
    ?.getAttribute("data");
if (deviceWiseVisitorChart) {
    deviceWiseVisitorChart = JSON.parse(deviceWiseVisitorChart);
}

deviceWiseVisitorChart = deviceWiseVisitorChart ? deviceWiseVisitorChart : [];

var month = [
    "Jan",
    "Feb",
    "Mar",
    "Apr",
    "May",
    "Jun",
    "Jul",
    "Aug",
    "Sep",
    "Oct",
    "Nov",
    "Dec",
];

document.addEventListener("DOMContentLoaded", function () {
    // Only initialize charts if the chart elements exist on this page
    const visitorsChartEl = document.querySelector("#visitorsChart");
    if (visitorsChartEl && typeof ApexCharts !== "undefined") {
        const options = {
            chart: {
                type: "bar",
                height: 300,
                background: "transparent",
                toolbar: { show: false },
            },
            legend: {
                show: false,
            },
            series: [
                {
                    name: "Visitors",
                    data: month.map(
                        (monthName) => monthWiseVisitorChart[monthName] || 0
                    ),
                },
            ],
            xaxis: {
                categories: month,
                labels: {
                    style: {
                        colors: "#E5E5E5",
                        fontSize: "12px",
                    },
                },
                axisBorder: { show: false },
                axisTicks: { show: false },
            },
            yaxis: {
                max: 1000,
                tickAmount: 5,
                labels: {
                    style: {
                        colors: "#AAA",
                    },
                },
            },
            tooltip: {
                theme: "dark",
                y: {
                    formatter: function (val) {
                        return val + " Visitors";
                    },
                },
                style: {
                    fontSize: "14px",
                },
            },
            dataLabels: {
                enabled: false,
            },
            colors: ["#F9DF6D"],
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: "50%",
                    distributed: true,
                },
            },
            grid: {
                borderColor: "#2d2d2d",
                strokeDashArray: 4,
            },
        };

        const chart = new ApexCharts(visitorsChartEl, options);
        chart.render();
    }

    const deviceChartEl = document.querySelector("#visitorsByDeviceChart");
    if (deviceChartEl && typeof ApexCharts !== "undefined") {
        var deviceOptions = {
            chart: {
                type: "area",
                height: 350,
                background: "#252525",
                toolbar: { show: false },
            },
            series: [
                {
                    name: "Mobile",
                    data: month.map((monthName, index) => {
                        return (
                            deviceWiseVisitorChart.find(
                                (item) =>
                                    item.device === "Mobile" &&
                                    item.month == monthName
                            )?.count || 0
                        );
                    }),
                },
                {
                    name: "PC",
                    data: month.map((monthName, index) => {
                        return (
                            deviceWiseVisitorChart.find(
                                (item) =>
                                    item.device === "PC" &&
                                    item.month == monthName
                            )?.count || 0
                        );
                    }),
                },
            ],
            colors: ["#FFD700", "#00E4FF"],
            fill: {
                type: "gradient",
                gradient: {
                    shade: "dark",
                    type: "vertical",
                    gradientToColors: ["#FFA500", "#00BFFF"],
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 90, 100],
                },
            },
            xaxis: {
                categories: month,
                labels: {
                    style: { colors: "#ccc" },
                },
            },
            yaxis: {
                max: 1000,
                labels: {
                    style: { colors: "#ccc" },
                },
            },
            grid: {
                borderColor: "#444",
                row: {
                    colors: ["#1e1e1e", "transparent"],
                    opacity: 0.1,
                },
            },
            stroke: {
                curve: "straight",
                width: 6,
            },
            dataLabels: {
                enabled: false,
            },
            legend: {
                position: "bottom",
                horizontalAlign: "center",
                fontSize: "12px",
                labels: {
                    colors: "#fff",
                },
                markers: {
                    width: 4,
                    height: 4,
                    radius: 12,
                    fillColors: ["#252525", "#252525"],
                    strokeColor: ["#FFD700", "#00E4FF"],
                    strokeWidth: 4,
                },
                itemMargin: {
                    horizontal: 12,
                    vertical: 8,
                },
            },
            tooltip: {
                theme: "dark",
            },
        };

        var visitorsByDeviceChart = new ApexCharts(
            deviceChartEl,
            deviceOptions
        );
        visitorsByDeviceChart.render();
    }
});

// Generate Slug from Input Field
window.makeSlug = function (el) {
    let attributeName = el.getAttribute("data-slug");

    const slug = el.value
        .toLowerCase()
        .replace(/ /g, "-")
        .replace(/[^\w-]+/g, "");
    document.querySelector(`[target="${attributeName}"]`).value = slug;
};

const imageInput = document.getElementById("imageUpload");

const resetBtn = document.getElementById("resetImage");
const defaultSrc = "//" + window.location.hostname + "/defualt/placeholder.png";
// image preview
window.imagePreview = function (element) {
    const file = element.files[0];
    if (file && file.type.startsWith("image/")) {
        const reader = new FileReader();
        reader.onload = function () {
            element.parentElement.querySelector("#preview").src = reader.result;
            let exitsOld =
                element.parentElement.querySelector("#oldImageUpload");
            if (exitsOld) {
                exitsOld.remove();
            }
            const resetBtn = element.parentElement.querySelector("#resetImage");
            resetBtn.classList.remove("hidden");
        };
        reader.readAsDataURL(file);
    }
};
// Reset image preview
window.resetCurrentImage = function (element) {
    const preview = element.parentElement.querySelector("#preview");

    const inputName = preview.parentElement.parentElement
        .querySelector("input")
        .getAttribute("name");
    const input = document.createElement("input");
    input.type = "hidden";
    input.id = "oldImageUpload";
    input.name = "old_" + inputName;
    input.value = true;
    preview.parentElement.appendChild(input);

    preview.src = defaultSrc;
    const imageInput = element.parentElement.querySelector("#imageUpload");

    element.classList.add("hidden"); // Hide the reset button
};

