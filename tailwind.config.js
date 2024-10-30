// tailwind.config.js
module.exports = {
  content: [
    './template-parts/**/*.php',
    './templates/**/*.php',
    './inc/**/*.php',
    './assets/js/**/*.js'
  ],
  theme: {
    extend: {
      // Custom theme extensions
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
  ],
  // Enable JIT mode
  mode: 'jit',
  // Purge unused styles
  purge: {
    enabled: process.env.NODE_ENV === 'production',
    content: [
      './**/*.php',
      './assets/**/*.js',
    ],
    options: {
      safelist: [
        // Whitelist specific classes
      ],
    },
  },
}