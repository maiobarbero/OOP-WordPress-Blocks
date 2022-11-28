import gulp from 'gulp'
import replace from 'gulp-replace'

import yargs from 'yargs'
import postcss from 'gulp-postcss'
import autoprefixer from 'autoprefixer'
import cssnano from 'cssnano'
import assets from 'postcss-assets'
import gulpif from 'gulp-if'

const sass = require('gulp-sass')(require('sass'))

import imagemin from 'gulp-imagemin'
import webp from 'gulp-webp'

import webpack from 'webpack-stream'
import uglify from 'gulp-uglify'

import wpPot from 'gulp-wp-pot'

import browserSync from 'browser-sync'

import del from 'del'

const projectURL = 'http://localhost:10033/'
const paths = {
	styles: {
		src: ['src/sass/style.scss'],
		dest: './',
	},
	images: {
		src: 'src/images/**/*.{jpg,jpeg,png,svg,gif,webp}',
		dest: 'dist/images',
	},
	webp: {
		src: 'src/images/**/*.{jpg,jpeg,png,svg,gif,webp}',
		dest: 'dist/images',
	},
	scripts: {
		src: ['src/js/index.js'],
		dest: 'dist/js',
	},
	other: {
		src: ['src/**/*', '!src/{images,js,sass}', '!src/{images,js,sass}/**/*'],
		dest: 'dist',
	},
	languages: {
		src: '**/*.php',
		dest: `languages/efb.pot`,
	},
	package: {
		src: [
			'**/*',
			'!.vscode',
			'!node_modules{,/**}',
			'!packaged{,/**}',
			'!src{,/**}',
			'!.babelrc',
			'!.gitignore',
			'!gulpfile.babel.js',
			'!package.json',
			'!package-lock.json',
		],
		dest: 'packaged',
	},
}

const PRODUCTION = yargs.argv.prod

export const styles = () => {
	let processors = [autoprefixer]
	if (PRODUCTION) processors.push(cssnano)
	return gulp
		.src(paths.styles.src)
		.pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
		.pipe(
			postcss([
				assets({
					loadPaths: ['dist/assets/images'],
				}),
			])
		)
		.pipe(postcss(processors))
		.pipe(replace('/*!', '/*'))
		.pipe(gulp.dest(paths.styles.dest))
		.pipe(browserSync.stream({ match: '**/*.css' }))
}

export const images = () => {
	return gulp
		.src(paths.images.src)
		.pipe(gulpif(PRODUCTION, imagemin()))
		.pipe(gulp.dest(paths.images.dest))
		.pipe(webp())
		.pipe(gulp.dest(paths.webp.dest))
		.pipe(browserSync.stream({ match: '**/*.{jpg,jpeg,png,svg,gif,webp}' }))
}

export const scripts = () => {
	return gulp
		.src(paths.scripts.src)
		.pipe(
			webpack({
				mode: !PRODUCTION ? 'development' : 'production',
				module: {
					rules: [
						{
							test: /\.js$/,
							use: {
								loader: 'babel-loader',
								options: {
									presets: ['@babel/preset-env'],
								},
							},
						},
						{
							test: /\.css$/i,
							use: ['style-loader', 'css-loader'],
						},
					],
				},
				output: {
					filename: '[name].js',
				},
				externals: {
					jquery: 'jQuery',
				},
				devtool: !PRODUCTION ? 'inline-source-map' : false,
			})
		)
		.pipe(gulpif(PRODUCTION, uglify()))
		.pipe(gulp.dest(paths.scripts.dest))
		.pipe(browserSync.stream({ match: '**/*.js' }))
}

export const pot = () => {
	return gulp
		.src('**/*.php')
		.pipe(
			wpPot({
				domain: `efb`,
				package: 'everyflavourbeans',
			})
		)
		.pipe(gulp.dest(`languages/everyflavourbeans.pot`))
}

export const clean = () => del(['dist'])

export const copy = () => {
	return gulp
		.src(paths.other.src)
		.pipe(gulp.dest(paths.other.dest))
		.pipe(
			browserSync.reload({
				stream: true,
			})
		)
}
export const watch = () => {
	gulp.watch('src/sass/**', styles)
	gulp.watch('src/js/**', gulp.series(scripts))
	gulp.watch('**/*.php')
	gulp.watch(paths.images.src, gulp.series(images))
	gulp.watch(paths.other.src, gulp.series(copy))
	browserSync.init({
		proxy: projectURL,
		open: true,
		injectChanges: true,
		watch: true,
		watchOptions: {
			debounceDelay: 1000, // This introduces a small delay when watching for file change events to avoid triggering too many reloads
		},
	})
}

export const dev = gulp.series(
	clean,
	gulp.parallel(styles, scripts, images, copy),
	watch
)
export const build = gulp.series(
	clean,
	gulp.parallel(styles, scripts, images, copy, pot)
)

export default dev
