import { defineConfig } from 'vite'
import { resolve } from 'path'

export default defineConfig({
    root: './src',
    base: '/dist/',

    build: {
        outDir: '../public/dist',
        emptyOutDir: true,
        manifest: true,
        chunkSizeWarningLimit: 1000,

        rollupOptions: {
            input: {
                assemblage: resolve(__dirname, 'src/js/assemblage.js'),
                categories: resolve(__dirname, 'src/js/categories.js'),
                footer: resolve(__dirname, 'src/js/footer.js'),
                index: resolve(__dirname, 'src/js/index.js'),
                methodologies: resolve(__dirname, 'src/js/methodologie.js'),
                nutriments: resolve(__dirname, 'src/js/nutriments.js'),
                partage: resolve(__dirname, 'src/js/partage.js'),
            }
        }
    },

    server: {
        strictPort: true,
        port: 5173,
        host: 'localhost',
        origin: 'http://localhost:5173',
        cors: true,
    }
})