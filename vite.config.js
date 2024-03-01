import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';


export default defineConfig({
    "plugins":[
        laravel({
            "input": [
                "resources/css/app.css",
                "resources/js/app.ts",
            ],
            "refresh": true
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
			},
		 })
	 ],
     resolve:{
        alias:{
            '@': resolve(__dirname,"./resources/js"),
            '@partials': resolve(__dirname,"./resources/js/Pages/Profile/Partials"),
            '@component': resolve(__dirname,"./resources/js/Components"),
            '@route': resolve(__dirname,"./vendor/tightenco/ziggy/src/js"),
            '@interfaces':resolve(__dirname,"./resources/js/interfaces"),
            "@global": resolve(__dirname,"./resources/js/global")
        }
     }
 });
