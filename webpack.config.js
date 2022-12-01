// Generated using webpack-cli https://github.com/webpack/webpack-cli
const MiniCssExtractPlugin = require('mini-css-extract-plugin'),
	ImageMinimizerPlugin = require('image-minimizer-webpack-plugin'),
	path = require('path'),
	CopyPlugin = require('copy-webpack-plugin'),
	BrowserSyncPlugin = require('browser-sync-webpack-plugin'),
	TerserPlugin = require('terser-webpack-plugin'),
	WebpackBar = require('webpackbar'),
	wpPot = require('wp-pot'),
	isProduction = process.env.NODE_ENV == 'production'

const LOCALURL = 'http://localhost:10033/',
	SRCPATH = path.resolve(__dirname, 'src'),
	DISTPATH = path.resolve(__dirname, 'dist'),
	localpath = {
		styles: {
			src: `${SRCPATH}/sass/style.scss`,
			dist: `./`,
		},
		scripts: { src: `${SRCPATH}/js/main.js` },
		images: { src: `${SRCPATH}/images/` },
		fonts: { src: `${SRCPATH}/fonts/` },
	}

const config = {
	entry: [localpath.scripts.src, localpath.styles.src],
	output: {
		path: path.resolve(__dirname, 'dist'),
	},
	devServer: {
		open: true,
		host: 'localhost',
	},
	module: {
		rules: [
			{
				test: /\.(js|jsx)$/i,
				loader: 'babel-loader',
			},
			{
				test: /\.(css|scss)/i,
				exclude: /node_modules/,
				use: [
					MiniCssExtractPlugin.loader,
					'css-loader',
					'postcss-loader',
					'sass-loader',
				],
			},
			{
				test: /\.(jpe?g|png|gif|svg)$/i,
				type: 'asset',
			},
		],
	},
	optimization: {
		minimizer: [
			new TerserPlugin(),
			new ImageMinimizerPlugin({
				deleteOriginalAssets: false,
				generator: [
					{
						// Apply generator for copied assets
						type: 'asset',
						preset: 'webp',
						implementation: ImageMinimizerPlugin.imageminGenerate,
						options: {
							plugins: ['imagemin-webp'],
						},
					},
				],
				minimizer: {
					implementation: ImageMinimizerPlugin.imageminMinify,
					options: {
						plugins: [
							['gifsicle', { interlaced: true }],
							['jpegtran', { progressive: true }],
							['optipng', { optimizationLevel: 5 }],
							// Svgo configuration here https://github.com/svg/svgo#configuration
							[
								'svgo',
								{
									plugins: [
										{
											name: 'preset-default',
											params: {
												overrides: {
													removeViewBox: false,
													addAttributesToSVGElement: {
														params: {
															attributes: [
																{ xmlns: 'http://www.w3.org/2000/svg' },
															],
														},
													},
												},
											},
										},
									],
								},
							],
						],
					},
				},
			}),
		],
	},
	plugins: [
		new WebpackBar(),
		new MiniCssExtractPlugin({
			filename: `../style.css`,
		}),
		new CopyPlugin({
			patterns: [
				{ from: localpath.images.src, to: './images', noErrorOnMissing: true },
				{ from: localpath.fonts.src, to: './fonts', noErrorOnMissing: true },
			],
		}),
		// Comment this if you don't want to use CSS Live reload
		new BrowserSyncPlugin(
			{
				proxy: LOCALURL,
				files: [localpath.scripts.dist, localpath.images.dist, './style.css'],
				injectCss: true,
			},
			{ reload: true }
		),
	],
	output: {
		path: DISTPATH,
		filename: `js/[name].bundle.js`,
		clean: true,
	},
}

module.exports = () => {
	if (isProduction) {
		config.mode = 'production'
	} else {
		config.mode = 'development'
	}
	return config
}
