# OOP--WordPress-Blocks

## How To use

First of all you need to run:

```
composer install
```

and

```
npm install
```

Then:

- First of all edit `gulp.babel.js` and change `const projectURL` with your local dev url.
- Run `npm run start` to start the dev enviroment
- When the theme is ready for production run `npm run build`

<i>You can find all your script and images inside the dist folder</i>

### uselfullethods:

Use this inside the functions.php file
<strong>You can check the params to pass inside class/Theme.php</strong>

- `addThemeSupport()` => add theme support (some value passed by default);
- `$theme->script->script()` => register new script;
- `$theme->script->script` => register new style;
- `addThemeSupport()` => add theme support (some value passed by default);
- `loadTextdomain()` => load text domain;
- `registerNavMenu()` => register nav menu (some value passed by default);
- `addImageSize()` => set new image size;
- `removeImageSize()` => remove image size;
- `customPost->register()` => register custom post type;
- `customTaxonomy->register()` => register custom taxonomy;
- `setBlockPath()` => set the block folder path;

## block folder

Here you can add your blocks created with [Carbon Fields](https://docs.carbonfields.net/learn/containers/gutenberg-blocks.html)

## Start the theme

- First of all edit `gulp.babel.js` and change `const projectURL` with your local dev url.
