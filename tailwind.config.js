export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  theme: {
    extend: {
      colors: {
        ink: '#0D1B14',
        'ink-soft': '#2B372F',
        canvas: '#F6F7F3',
        'canvas-alt': '#EEF0E9',
        pine: {
          DEFAULT: '#1B6B45',
          dark: '#134F33',
          bright: '#2FA860',
        },
        brand: {
          DEFAULT: '#1B6B45',
          dark: '#134F33',
        },
        freight: '#2E5C94',
        rust: '#B8461F',
        amber: {
          DEFAULT: '#C68A1E',
          dark: '#8F6314',
        },
        steel: {
          DEFAULT: '#6B7570',
          light: '#9CA39D',
        },
      },
      fontFamily: {
        display: ['Fraunces', 'serif'],
        body: ['Inter', 'sans-serif'],
        'mono-data': ['"IBM Plex Mono"', 'monospace'],
      },
      boxShadow: {
        crate: '0 1px 2px rgba(13,27,20,0.04), 0 4px 12px rgba(13,27,20,0.05)',
        'crate-lg': '0 4px 8px rgba(13,27,20,0.05), 0 12px 32px rgba(13,27,20,0.08)',
      },
      borderRadius: {
        card: '18px',
      },
    },
  },
  plugins: [],
};