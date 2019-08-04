module.exports = {
  theme: {
    container: {
      center: true,
    },
    extend: {
      boxShadow: {
        'active': 'inset 0 3px 5px rgba(#000000, .125)',
        'active-focus': "0 0 0 .2rem rgba(theme('colors.mint.500'), .25), inset 0 3px 5px rgba(#000000, .125)",
        'focus': "0 0 0 .2rem rgba(theme('colors.mint.500'), .25)",
      },
      colors: {
        mint: {
          800: '#113534',
          700: '#226968',
          600: '#329E9C',
          500: '#38AFAD',
          400: '#74C7C6',
          300: '#AFDFDE',
          200: '#EBF7F7'
        }
      },
      height: {
        '80': '20rem',
        '96': '24rem',
        '112': '28rem',
        '1/3': '66vh'
      },
      inset: {
        '20': '5rem',
        '24': '6rem'
      },
      width: {
        '80': '20rem'
      },
      zIndex: {
        '-1': '-1',
      }
    },
    variants: {},
    plugins: []
  }
}
