/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./application/views/**/*.php",
    "./application/controllers/**/*.php",
    "./application/models/**/*.php",
    "./assets/js/**/*.js",
    "./*.php"
  ],
  safelist: [
    {
      pattern: /.*/,
    },
  ],
  theme: {
    extend: {
      colors: {
        primary: {
          DEFAULT: '#3B82F6', // blue-500
          dark: '#2563EB',    // blue-600
        },
        secondary: {
          DEFAULT: '#6B7280', // gray-500
          dark: '#4B5563',    // gray-600
        },
      },
      fontFamily: {
        // Add your custom fonts here
      },
      gap: {
        '10': '2.5rem',
      },
      order: {
        '1': '1',
        '2': '2',
        'first': '-9999',
        'last': '9999',
        'none': '0',
      },
    },
  },
  plugins: [],
} 