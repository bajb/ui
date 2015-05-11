module.exports = function (grunt)
{

  grunt.initConfig(
    {
      cssmin: {
        dist:   {
          files: {
            'assets/css/PageElements.min.css': ['assets_src/css/PageElements/*.css']
          }
        },
        target: {
          files: [{
            expand: true,
            cwd:    'assets_src/css/',
            src:    ['**/*.css', '!*.min.css'],
            dest:   'assets/css/',
            ext:    '.min.css'
          }]
        }
      }
    }
  );

  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.registerTask('default', ['cssmin']);

};
