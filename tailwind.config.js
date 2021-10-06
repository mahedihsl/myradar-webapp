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
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
