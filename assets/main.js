import 'vite/modulepreload-polyfill';
import FlyntComponent from "./scripts/FlyntComponent.js";

import 'lazysizes';

import '@oddbird/popover-polyfill';

import.meta.glob([
  '../Components/**',
  '../assets/**',
  '!**/*.js',
  '!**/*.scss',
  '!**/*.php',
  '!**/*.twig',
  '!**/screenshot.webp',
  '!**/*.md',
]);

window.customElements.define('flynt-component', FlyntComponent);
