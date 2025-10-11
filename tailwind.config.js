/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './node_modules/flowbite/**/*.js'
  ],
  theme: {
    extend: {
      colors: {
        // Blizzard Blue sebagai warna utama
        primary: {
          50: '#f0f8ff',
          100: '#e0f1ff',
          200: '#bae3ff',
          300: '#7dd0ff',
          400: '#38b8ff',
          500: '#A7D3EB',
          600: '#8cc4e3',
          700: '#71b5db',
          800: '#5da7d3',
          900: '#4998cb',
        },
        // Bush Green sebagai warna sekunder
        secondary: {
          50: '#f0fdf4',
          100: '#dcfce7',
          200: '#bbf7d0',
          300: '#86efac',
          400: '#4ade80',
          500: '#16431F',
          600: '#134e1a',
          700: '#115917',
          800: '#0f6315',
          900: '#0d6e13',
        },
        // Thunderbird Red sebagai warna aksen untuk danger/error
        danger: {
          50: '#fef2f2',
          100: '#fee2e2',
          200: '#fecaca',
          300: '#fca5a5',
          400: '#f87171',
          500: '#C31118',
          600: '#b91c1c',
          700: '#991b1b',
          800: '#7f1d1d',
          900: '#651c1c',
        },
        // Wattle Yellow sebagai warna peringatan
        warning: {
          50: '#fffbeb',
          100: '#fef3c7',
          200: '#fde68a',
          300: '#fcd34d',
          400: '#fbbf24',
          500: '#E2CF4B',
          600: '#d69e2e',
          700: '#b7791f',
          800: '#975a16',
          900: '#744210',
        }
      }
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
  darkMode: 'class',
}