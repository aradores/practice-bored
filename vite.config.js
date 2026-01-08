import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/css/flatpickr.css",
                "resources/css/flatpickr_admin.css",
                "resources/css/flatpickr_merchant.css",
                "resources/js/app.js",
                "resources/js/guest.js",
                "resources/js/swiper-repay-features.js",
                "resources/js/swiper-repay-about.js",
                "resources/js/swiper-operating-days.js",
                "resources/js/leaflet-map.js",
                "resources/js/swiper-previous-works.js",
                "resources/js/swiper-products-services-details-pictures.js",
                "resources/js/swiper-store-management-cards.js",
                "resources/js/flatpickr.js",
                "resources/js/reusable-chart.js",
                "resources/js/qrCode.js",
                "resources/js/store/left_sidebar.js",
                "resources/js/cash-inflow-category-swiper.js",
                "resources/css/date-range-picker.css",
                "resources/css/date-time-picker.css",
                "resources/css/referral-system.css",
            ],
            refresh: true,
        }),
    ],
    server: {
        cors: true,
        watch: {
            ignored: ["**/storage/framework/views/**"],
        },
    },
});
