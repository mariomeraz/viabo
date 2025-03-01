import path from 'path'

import react from '@vitejs/plugin-react-swc'
import million from 'million/compiler'
import { defineConfig, splitVendorChunkPlugin } from 'vite'

// https://vitejs.dev/config/

export default ({ mode }) => {
  const isProduction = mode === 'production'

  return defineConfig({
    mode: isProduction ? 'production' : 'development',
    base: isProduction ? '/app/' : '/',
    build: {
      // publicPath: '/',
      sourcemap: true,
      cssMinify: true,
      outDir: path.resolve(__dirname, '..', 'backend/public/app'),
      rollupOptions: {
        manualChunks(id) {
          if (id.includes('react-dom')) {
            return 'react-dom'
          }
        },
        output: {
          assetFileNames: assetInfo => {
            let extType = assetInfo.name.split('.').at(1)
            if (/png|jpe?g|svg|gif|tiff|bmp|ico/i.test(extType)) {
              extType = 'img'
              return `assets/${extType}/[name][extname]`
            }
            return `assets/${extType}/build-[hash][extname]`
          },
          entryFileNames: 'assets/js/[name]-[hash].js',
          chunkFileNames: 'assets/js/[name]-[hash].js'
        }
      }
    },

    plugins: [million.vite({ auto: true, mute: true }), react(), splitVendorChunkPlugin()],
    server: {
      port: 3000,
      hmr: {
        host: 'localhost',
        overlay: true
      },
      proxy: {
        '**': {
          target: 'http://viabo:80/',
          changeOrigin: true,
          secure: false
        },
        '/api': {
          target: 'http://viabo:80/',
          changeOrigin: true,
          secure: false,
          ws: true
        },
        '/storage': {
          target: 'http://viabo:80/',
          changeOrigin: true,
          secure: false,
          ws: true
        }
      }
    },
    envDir: path.resolve(__dirname, '..', '..', '..'),
    envPrefix: 'APP_',
    resolve: {
      alias: {
        '@': path.resolve(__dirname, './src'),
        '@theme': path.resolve(__dirname, './src', 'theme')
      }
    },
    test: {
      globals: true,
      environment: 'jsdom',
      css: true,
      setupFiles: ['./src/test/setup.js']
    }
  })
}
