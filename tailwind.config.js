/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./public/index.html', './public/pastMeetup.html'],
  theme: {
    extend: {
      screens: {
        '3xl': '1920px',
        '4xl': '2400px',
      },
    },
  },
  plugins: [],
}
