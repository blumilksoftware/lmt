/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./public/meetup.html', './public/pastMeetup.html'],
  theme: {
    extend: {
      screens: {
        'xs': '375px',
        '3xl': '1920px',
        '4xl': '2400px',
      },
      colors: {
        violetb: '#ad92e0',
      },
    },
  },
  plugins: [],
}
