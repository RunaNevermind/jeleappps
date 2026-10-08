import vue from '@vitejs/plugin-vue'
import { defineConfig } from 'vite'

export default defineConfig({
  plugins: [vue()],
  base: '/dist/',
  build: {
    outDir: '../public/dist',
    emptyOutDir: true,
  },
  server: {
    proxy: {
      '/api': {
        target: 'http://jeleappps.test',
        changeOrigin: true,
      },
    },
  },
})