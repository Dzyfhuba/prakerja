import react from '@vitejs/plugin-react'
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/react.tsx'
      ],
      ssr: 'resources/js/ssr.tsx',
      refresh: true,
    }),
    react()
  ],
  define: {
    _globals: {},
  },
  esbuild: {
    drop: process.env.APP_ENV ? ['console', 'debugger'] : undefined,
    minify: process.env.APP_ENV == 'production',
  },
  build: {
    minify: process.env.APP_ENV == 'production',
  },
  mode: process.env.APP_ENV == 'production' ? 'production' : 'development'
});
