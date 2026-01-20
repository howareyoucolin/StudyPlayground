import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';

export default defineConfig({
  plugins: [react()],
  define: {
    'process.env': '{}',
    'process.env.NODE_ENV': '"production"',
    'process': '{ env: {} }'
  },
  build: {
    outDir: 'dist',
    lib: {
      entry: './src/main.jsx',
      name: 'ReactAuth',
      formats: ['iife'],
      fileName: 'react-auth-bundle'
    },
    rollupOptions: {
      output: {
        extend: true
      }
    }
  }
});
