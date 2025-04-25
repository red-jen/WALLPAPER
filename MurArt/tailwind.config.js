/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        // Primary color palette
        navy: '#4A6C8B',      // Muted blue (primary)
        'navy-light': '#6D8BA6', // Lighter version for hover states
        'navy-dark': '#354E64',  // Darker version for contrast
        gold: '#D9A566',      // Warm gold (secondary)
        'gold-light': '#E6C393', // Lighter gold for hover states
        'gold-dark': '#B78546',  // Darker gold for contrast
        accent: '#9C6A8C',    // Soft purple as an accent
        ivory: '#F8F7F5',     // Off-white background
        charcoal: '#2D3142',  // Deep blue-gray for text
        neutral: '#E0DED8',   // Warm gray for backgrounds
        
        // UI state colors
        success: '#5A7D63',    // Muted green for success states
        error: '#A55042',      // Muted red for error states
        warning: '#D4B86A',    // Muted yellow for warning states
        info: '#4A6C8B',       // Using our navy for info states
      },
      fontFamily: {
        sans: ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        serif: ['Playfair Display', 'ui-serif', 'Georgia', 'serif'],
      },
      boxShadow: {
        'subtle': '0 4px 20px rgba(0, 0, 0, 0.05)',
        'elevated': '0 10px 30px rgba(0, 0, 0, 0.08)',
      },
      borderRadius: {
        'sm': '4px',
        DEFAULT: '8px',
        'lg': '12px',
      },
      animation: {
        'fade-in': 'fadeIn 0.7s ease-in-out forwards',
        'slide-up': 'slideUp 0.7s ease-out forwards',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideUp: {
          '0%': { transform: 'translateY(20px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('@tailwindcss/aspect-ratio'),
  ],
}