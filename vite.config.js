import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/assets/js/create-assessment.js",
                "resources/assets/css/create-result.css",
                "resources/assets/js/create-result.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
