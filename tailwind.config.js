/** @type {import('tailwindcss').Config} */
module.exports = {
      content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {

      colors: {
    'hot-pink': '#EF7C8E',
    'cream': '#FAE8E0',
    'spear-mint': '#B6E2D3',
    'rose-water': '#D8A7B1',
    'black': '#0E1318',
    'white': '#FFFFFF',

      },
    extend: {},
  },
  plugins: [
      require('@tailwindcss/forms'),
      require('@tailwindcss/typography'),

  ],
}
