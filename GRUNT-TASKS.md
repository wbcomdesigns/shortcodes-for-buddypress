# Grunt Task Documentation

## Installation

First, install the required dependencies:

```bash
npm install
```

## Available Grunt Tasks

### Development Tasks

#### `grunt` or `grunt default`
Runs the default development tasks:
- Cleans CSS and JS directories
- Minifies CSS files (with source maps)
- Minifies JavaScript files (with source maps)
- Generates RTL stylesheets
- Checks text domains for i18n

#### `grunt dev`
Runs default tasks and starts watching for file changes with live reload enabled.

#### `grunt watch`
Watches for file changes and automatically:
- Minifies CSS/JS when source files change
- Generates RTL styles when CSS changes
- Checks text domain when PHP files change
- Includes live reload support

### Build Tasks

#### `grunt build`
Creates a production-ready build:
1. Cleans all generated files
2. Checks text domains
3. Minifies all CSS and JS files
4. Generates RTL stylesheets
5. Creates POT file for translations
6. Copies files to build directory
7. Creates a versioned ZIP file
8. Cleans up build directory

### Specific Tasks

#### `grunt css`
Processes only CSS files:
- Cleans CSS directories
- Minifies all CSS files
- Generates RTL versions

#### `grunt js`
Processes only JavaScript files:
- Runs JSHint for code quality
- Cleans JS directories
- Minifies all JavaScript files

#### `grunt minify`
Quick minification without cleaning:
- Minifies CSS files
- Minifies JavaScript files

#### `grunt i18n`
Internationalization tasks:
- Checks text domains
- Generates POT file for translations

#### `grunt quality`
Code quality checks:
- Runs JSHint on JavaScript
- Checks text domains
- Runs PHP CodeSniffer (if installed)

#### `grunt fix`
Automatically fixes code style issues using PHP Code Beautifier (if installed).

#### `grunt clean`
Removes all generated files:
- Minified CSS files
- Minified JS files
- RTL stylesheets
- Build directory
- Temporary files

## NPM Scripts

You can also use npm scripts as shortcuts:

```bash
npm run build     # Same as grunt build
npm run dev       # Same as grunt dev
npm run css       # Same as grunt css
npm run js        # Same as grunt js
npm run minify    # Same as grunt minify
npm run i18n      # Same as grunt i18n
npm run quality   # Same as grunt quality
npm run fix       # Same as grunt fix
npm run watch     # Same as grunt watch
npm run clean     # Same as grunt clean
```

## Features

### Concurrent Processing
CSS and JavaScript tasks run concurrently for faster builds.

### Source Maps
Development builds include source maps for easier debugging.

### Live Reload
When using `grunt dev` or `grunt watch`, the browser automatically reloads when files change.

### RTL Support
Automatically generates RTL versions of all stylesheets.

### Code Quality
- JSHint for JavaScript linting
- Text domain checking for proper internationalization
- Optional PHP CodeSniffer integration

### Production Build
The `grunt build` task creates a production-ready ZIP file with:
- Minified assets
- No development files
- Proper file structure
- Version numbering

## Configuration

The Grunt configuration can be customized in `Gruntfile.js`. Key configuration options:

- **Clean**: Directories to clean
- **Copy**: Files to include/exclude in build
- **CSSMin**: CSS minification settings
- **Uglify**: JavaScript minification settings
- **Watch**: File patterns to watch
- **Concurrent**: Parallel task execution

## Troubleshooting

1. **npm install fails**: Make sure you have Node.js 14+ and npm 6+ installed
2. **Grunt command not found**: Install grunt-cli globally: `npm install -g grunt-cli`
3. **PHP commands fail**: Ensure WP-CLI is installed for i18n commands
4. **Build fails**: Check that all source files are valid CSS/JS