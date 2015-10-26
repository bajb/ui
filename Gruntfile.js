module.exports = function (grunt)
{

  grunt.initConfig(
    {
      cssmin:  {
        dist:   {
          files: {
            'assets/css/PageElements.min.css':    ['assets_src/assets/css/PageElements/*.css'],
            'assets/css/ContentElements.min.css': ['assets_src/assets/css/ContentElements/*.css'],
            'assets/css/GlobalElements.min.css':  ['assets_src/assets/css/GlobalElements/*.css'],
            'assets/css/Decorators.min.css':      ['assets_src/assets/css/Decorators/*.css']
          }
        },
        target: {
          files: [{
            expand: true,
            cwd:    'assets_src/assets/css/',
            src:    ['*.css', '!*.min.css'],
            dest:   'assets/css/',
            ext:    '.min.css'
          }]
        }
      },
      uglify: {
        dist: {
          files: {
            'assets/js/PageElements.min.js':    ['assets_src/assets/js/PageElements/*.js'],
            'assets/js/ContentElements.min.js': ['assets_src/assets/js/ContentElements/*.js'],
            'assets/js/GlobalElements.min.js':  ['assets_src/assets/js/GlobalElements/*.js'],
            'assets/js/Decorators.min.js':      ['assets_src/assets/js/Decorators/*.js']
          }
        }
      },
      copy:   {
        images: {
          files: [{
            expand: true,
            cwd:    'assets_src/assets/img/',
            src:    ['**'],
            dest:   'assets/img/'
          }]
        },
        vendor: {
          files: [{
            expand: true,
            cwd:    'assets_src/assets/vendor/',
            src:    ['**'],
            dest:   'assets/vendor/'
          }]
        }
      },
      replace: {
        dist: {
          options: {
            usePrefix: false,
            patterns:  [
              {

                match:       '../../img',
                replacement: '../img'
              }
            ]
          },
          files:   [
            {
              expand:  true,
              flatten: true,
              src:     ['assets/css/*.css'],
              dest:    'assets/css'
            }
          ]
        }
      }
    }
  );

  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-replace');
  grunt.registerTask('default', ['copy', 'cssmin', 'uglify', 'replace']);

};
