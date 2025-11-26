import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [tailwindcss()],

  build: {
    // Output files to the theme root
    outDir: 'dist',

    // Generate manifest.json for WordPress integration
    manifest: true,

    rollupOptions: {
      input: {
        main: './src/main.js',
      },
    },

    // Don't minify in development for easier debugging
    minify: 'terser',
  },

  server: {
    // Use a specific port
    port: 5173,

    // Enable hot module replacement
    hmr: {
      host: 'localhost',
      protocol: 'ws',
    },

    // Allow access from WordPress running on different port
    cors: true,

    // Ensure strict port
    strictPort: true,

    // Open browser on server start
    open: false,

    // Watch for changes
    watch: {
      usePolling: true,
    },
  },
});

