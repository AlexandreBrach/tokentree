module.exports = function(grunt) {
	grunt.initConfig({
		watch: {
			files: ['src/**','tests/**'],
			tasks: ['phpunit']
		},
		phpunit: {
			classes: {
				dir: 'tests/'
			},
			options: {
				bin: 'phpunit',
//				bootstrap: '',
				colors: true
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-phpunit');
	grunt.registerTask('default', ['watch']);
};
