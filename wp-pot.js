const wpPot = require('wp-pot')

wpPot({
	destFile: './languages/afb.pot',
	package: 'All Flavour Beans',
	src: ['./*.php', './templates/**/*.php'],
})
