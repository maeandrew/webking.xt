module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		// uglify: {
		// 	options: {
		// 		banner: '/*! <%= pkg.name %> <%= grunt.template.today("yyyy-mm-dd") %> */\n'
		// 	},
		// 	build: {
		// 		src: 'src/<%= pkg.name %>.js',
		// 		dest: 'build/<%= pkg.name %>.min.js'
		// 	}
		// },
		watch: {
			css: {
				files: ['themes/default/css/*.css'],
				tasks: ['cssmin:target_css'],
			},
			css_ps: {
				files: ['themes/default/css/page_styles/*.css'],
				tasks: ['cssmin:target_css_ps'],
			},
			options: {
				spawn: true
			}
		},
		cssmin: {
			options: {
				keepBreaks: true,
				advanced: false
			},
			target_css: {
				files: [
					{
						expand: true,
						cwd: 'themes/default/css',
						src: ['*.css', '!*.min.css'],
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
	// grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-watch');

	// Default task(s).
	grunt.registerTask('default', [/*'uglify', */'cssmin', 'watch']);
};