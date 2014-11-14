module.exports = function (grunt) {
    var path = require('path');
    grunt.initConfig({

        watch: {
            options: {
                livereload: false
            },
            jsfile: {
                files: ['app/Resources/scripts/**/*.js'],
                tasks: ['concat:dev']
            },
            compassfile: {
                files: ['app/Resources/style/**/*.scss'],
                tasks: ['compass:dev']
            },
            pofiles: {
                files: ['./src/Trademachines/ContentBundle/Resources/translations/??/*.po'],
                tasks: ['concat-pofiles']
            }

        },
        casperjs: {
            options: {
                casperjsOptions: [
                    '--url=http://dev_en.tm.dev',
                    '--xunit=app/build/logs/js-behaviour.xml'
                ],
                async: {
                    parallel: false
                }
            },
            files: ['app/Resources/tests/behavior']
        },

        karma: {
            'unit': {
                configFile: 'app/Resources/tests/karma.conf.js'
            }
        }
    });

    // Load the plugins

    require('load-grunt-tasks')(grunt);

    // Test front end with mocha and casperjs
    grunt.registerTask('test', ['karma', 'casperjs']);

    //#################### END TASKS REGISTER ####################

    // Watcher
    grunt.event.on('watch', function(action, filepath, target) {
        grunt.log.writeln(target + ': ' + filepath + ' has ' + action);
    });
};
