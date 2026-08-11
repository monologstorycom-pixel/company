import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    
    // Build optimization
    build: {
        // Enable minification (esbuild is faster and built-in)
        minify: 'esbuild',
        // ESBuild minify options
        target: 'es2015',
        
        // Code splitting
        rollupOptions: {
            output: {
                // Manual chunk splitting for better caching
                manualChunks: {
                    // Vendor chunks - keep Alpine.js in main bundle to avoid timing issues
                    'vendor-axios': ['axios'],
                },
                // Optimize chunk file names
                chunkFileNames: 'js/[name]-[hash].js',
                entryFileNames: 'js/[name]-[hash].js',
                assetFileNames: (assetInfo) => {
                    const info = assetInfo.name.split('.');
                    const ext = info[info.length - 1];
                    if (/\.(css)$/.test(assetInfo.name)) {
                        return `css/[name]-[hash].${ext}`;
                    }
                    if (/\.(png|jpe?g|svg|gif|tiff|bmp|ico)$/i.test(assetInfo.name)) {
                        return `images/[name]-[hash].${ext}`;
                    }
                    if (/\.(woff2?|eot|ttf|otf)$/i.test(assetInfo.name)) {
                        return `fonts/[name]-[hash].${ext}`;
                    }
                    return `assets/[name]-[hash].${ext}`;
                },
            },
        },
        
        // Chunk size warning limit (500kb)
        chunkSizeWarningLimit: 500,
        
        // Source maps (disable in production for better performance)
        sourcemap: process.env.NODE_ENV === 'development',
        
        // CSS code splitting
        cssCodeSplit: true,
        
        // Asset inline limit (4kb)
        assetsInlineLimit: 4096,
    },
    
    // Optimization
    optimizeDeps: {
        include: ['axios', 'alpinejs'],
    },
    
    // Server configuration
    server: {
        hmr: {
            host: 'localhost',
        },
    },
});
