module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		uglify: {
			build: {
				files: [
					{
						expand: true,
						cwd: 'themes/default/js/',
						src: ['*.js', '!*.min.js'],
						dest: 'themes/default/js/',
						ext: '.min.js'
					}
				],
			}
		},
		watch: {
			css: {
				files: ['themes/default/css/*.css', '!colors.css', '!jquery-ui.css', '!reset.css'],
				tasks: ['cssmin:target_css'],
			},
			css_ps: {
				files: ['themes/default/css/page_styles/*.css'],
				tasks: ['cssmin:target_css_ps'],
			},
			uglify: {
				files: ['themes/default/js/*.js', '!themes/default/js/*.min.js'],
				tasks: ['uglify:build'],
			}
		},
		cssmin: {
			options: {
				keepBreaks: true,
				advanced: false,
			},
			target_css: {
				files: [
					{
						expand: true,
						cwd: 'themes/default/css',
						src: ['*.css', '!themes/default/min/css/*.min.css', '!themes/default/min/css/colors.css', '!themes/default/min/css/jquery-ui.css', '!reset.css'],
						dest: 'themes/default/min/css',
						ext: '.min.css'
					}
				]
			},
			target_css_ps: {
				files: [
					{
						expand: true,
						cwd: 'themes/default/css/page_styles',
						src: ['*.css', '!*.min.css'],
						dest: 'themes/default/min/css/page_styles',
						ext: '.min.css'
					}
				]
			}
		}
	});

	// Load the plugin that provides the task.
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-watch');

	// Default task(s).
	grunt.registerTask('0-default', ['uglify', 'cssmin', 'watch']);
};