module.exports = {
  mode: 'jit',
  purge: ['**/*.blade.php', '**/*.vue'],
  darkMode: false, // or 'media' or 'class'
  corePlugins: {
    preflight: false,
  },
  prefix: 'tw-',
  important: true,
  theme: {
    extend: {
      boxShadow: {
        DEFAULT: '0 0 20px rgb(0 0 0 / 12%)',
    },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
