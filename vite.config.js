import { defineConfig, loadEnv } from 'vite';
import autoprefixer from 'autoprefixer';
import flynt from './vite-plugin-flynt';
import sassGlobImports from 'vite-plugin-sass-glob-import';
import FullReload from 'vite-plugin-full-reload';
import fs from 'fs';

const wordpressHost = 'http://e-commerce.local';

const dest = "./dist";
const entries = [
  "./assets/admin.js",
  "./assets/admin.scss",
  "./assets/editor-style.scss",
  "./assets/main.js",
  "./assets/main.scss",
];
const watchFiles = [
  '*.php',
  'templates/**/*',
  'lib/**/*',
  'inc/**/*',
  './Components/**/*.{php,twig}'
];

export default defineConfig(({ mode }) => {
  const env = loadEnv(mode, process.cwd(), '');
  const host = env.VITE_DEV_SERVER_HOST || wordpressHost;
  const isSecure = host.indexOf('https://') === 0 && (env.VITE_DEV_SERVER_KEY || env.VITE_DEV_SERVER_CERT);

  return {
    base: "./",
    css: {
      devSourcemap: true,
      preprocessorOptions: {
        scss: {
          silenceDeprecations: ['import'],
        },
      },
      postcss: {
        plugins: [autoprefixer()]
      }
    },
    resolve: {
      alias: {
        "@": __dirname
      }
    },
    plugins: [flynt({ dest, host }), FullReload(watchFiles), sassGlobImports()],
    server: {
      https: isSecure
        ? {
            key: fs.readFileSync(env.VITE_DEV_SERVER_KEY),
            cert: fs.readFileSync(env.VITE_DEV_SERVER_CERT)
          }
        : false,
      host: 'localhost'
    },
    build: {
      manifest: true,
      outDir: dest,
      assetsInlineLimit: 0, // Disable assets inlining
      rollupOptions: {
        input: entries
      }
    },
  }
});
